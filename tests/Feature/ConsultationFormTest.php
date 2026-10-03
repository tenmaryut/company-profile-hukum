<?php

namespace Tests\Feature;

use App\Models\ConsultationRequest;
use App\Models\PracticeArea;
use App\Models\User;
use App\Notifications\NewConsultationRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ConsultationFormTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<string, mixed> */
    protected function validData(array $overrides = []): array
    {
        return [
            'name' => 'Pengunjung Uji',
            'email' => 'uji@contoh.example',
            'phone' => '+62 812-0000-0000',
            'practice_area_id' => PracticeArea::factory()->create()->id,
            'message' => 'Saya ingin bertanya tentang perjanjian jual beli yang tidak dipenuhi penjual.',
            'consent' => '1',
            'website' => '',
            'form_started_at' => encrypt(now()->subSeconds(10)->timestamp),
            ...$overrides,
        ];
    }

    public function test_form_tampil_dengan_pemberitahuan_privasi_dan_proteksi(): void
    {
        $this->get('/kontak')
            ->assertOk()
            ->assertSee('name="_token"', false)
            ->assertSee('name="website"', false)
            ->assertSee('name="form_started_at"', false)
            ->assertSee('name="consent"', false)
            ->assertSee('pemberitahuan privasi')
            ->assertSee('jangan kirim data pribadi asli');
    }

    public function test_kiriman_valid_tersimpan_dan_admin_diberi_tahu(): void
    {
        Notification::fake();
        $admin = User::factory()->create();
        $demo = User::factory()->demo()->create();

        $response = $this->post('/kontak', $this->validData());

        $response->assertRedirect(route('contact').'#form-konsultasi')
            ->assertSessionHas('consultation_sent')
            ->assertCookie(ConsultationRequest::SUBMITTER_COOKIE);

        $request = ConsultationRequest::sole();
        $this->assertSame('Pengunjung Uji', $request->name);
        $this->assertNotNull($request->consented_at);
        $this->assertFalse($request->is_sample);
        $this->assertSame(64, strlen($request->submitter_token_hash));

        Notification::assertSentTo([$admin, $demo], NewConsultationRequest::class);

        $this->followRedirects($response)->assertSee('Permintaan konsultasi terkirim');
    }

    public function test_notifikasi_admin_lewat_queue_dan_tanpa_data_pribadi(): void
    {
        $user = User::factory()->create();
        $request = ConsultationRequest::factory()->create(['name' => 'Nama Rahasia', 'email' => 'rahasia@contoh.example']);
        $notification = new NewConsultationRequest($request);

        $this->assertInstanceOf(\Illuminate\Contracts\Queue\ShouldQueue::class, $notification);
        $payload = json_encode($notification->toDatabase($user));
        $this->assertStringNotContainsString('Nama Rahasia', $payload);
        $this->assertStringNotContainsString('rahasia@contoh.example', $payload);
    }

    public function test_validasi_server(): void
    {
        $this->from('/kontak')->post('/kontak', $this->validData([
            'name' => '',
            'email' => 'bukan-email',
            'phone' => 'abc<script>',
            'message' => 'pendek',
            'consent' => null,
        ]))->assertRedirect('/kontak')
            ->assertSessionHasErrors(['name', 'email', 'phone', 'message', 'consent']);

        $this->assertDatabaseCount('consultation_requests', 0);
    }

    public function test_bidang_yang_disembunyikan_ditolak(): void
    {
        $hidden = PracticeArea::factory()->create(['is_published' => false]);

        $this->post('/kontak', $this->validData(['practice_area_id' => $hidden->id]))
            ->assertSessionHasErrors('practice_area_id');
    }

    public function test_honeypot_terisi_tidak_disimpan_tetapi_tampak_sukses(): void
    {
        $this->post('/kontak', $this->validData(['website' => 'https://spam.example']))
            ->assertRedirect()
            ->assertSessionHas('consultation_sent');

        $this->assertDatabaseCount('consultation_requests', 0);
    }

    public function test_kiriman_terlalu_cepat_atau_token_waktu_palsu_diabaikan(): void
    {
        $this->post('/kontak', $this->validData(['form_started_at' => encrypt(now()->timestamp)]))->assertSessionHas('consultation_sent');
        $this->post('/kontak', $this->validData(['form_started_at' => 'palsu']))->assertSessionHas('consultation_sent');

        $this->assertDatabaseCount('consultation_requests', 0);
    }

    public function test_rate_limit_lima_kiriman_per_sepuluh_menit(): void
    {
        Notification::fake();

        for ($i = 0; $i < 5; $i++) {
            $this->post('/kontak', $this->validData())->assertSessionHasNoErrors();
        }

        $this->post('/kontak', $this->validData())->assertSessionHasErrors('form');
        $this->assertDatabaseCount('consultation_requests', 5);
    }

    public function test_data_lebih_dari_tujuh_hari_dihapus_otomatis(): void
    {
        $old = ConsultationRequest::factory()->create();
        $old->forceFill(['created_at' => now()->subDays(7)->subMinute()])->saveQuietly();
        $recent = ConsultationRequest::factory()->create();
        $recent->forceFill(['created_at' => now()->subDays(6)])->saveQuietly();

        $this->artisan('model:prune', ['--model' => [ConsultationRequest::class]])->assertSuccessful();

        $this->assertModelMissing($old);
        $this->assertModelExists($recent);
    }

    public function test_jadwal_prune_terdaftar_tiap_jam(): void
    {
        $this->artisan('schedule:list')->expectsOutputToContain('model:prune')->assertSuccessful();
    }
}
