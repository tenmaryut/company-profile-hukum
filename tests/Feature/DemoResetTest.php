<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ConsultationRequest;
use App\Models\Faq;
use App\Models\PracticeArea;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DemoResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_demo_mengembalikan_semua_data_ke_kondisi_awal(): void
    {
        Storage::fake('public');
        $this->seed();

        $admin = User::factory()->create(['email' => 'admin@nalarsaksama.example']);
        $demo = User::query()->where('is_demo', true)->sole();
        $original = [
            'articles' => Article::count(),
            'faqs' => Faq::count(),
            'areas' => PracticeArea::count(),
            'team' => TeamMember::count(),
            'samples' => ConsultationRequest::where('is_sample', true)->count(),
        ];
        $firstArticle = Article::query()->orderBy('id')->first();
        $originalTitle = $firstArticle->title;

        // Pengunjung demo "merusak" data.
        $firstArticle->update(['title' => 'Judul diubah pengunjung demo']);
        Faq::query()->delete();
        PracticeArea::query()->first()->update(['is_published' => false]);
        ConsultationRequest::factory()->count(2)->create();
        $demo->update(['password' => 'kata-sandi-diganti-123', 'name' => 'Nama diganti']);
        DB::table('sessions')->insert(['id' => 'sesi-demo', 'user_id' => $demo->id, 'payload' => '', 'last_activity' => time()]);
        Storage::disk('public')->put('articles/unggahan-pengunjung.webp', 'x');
        User::factory()->demo()->create(['email' => 'demo-lain@contoh.example']);

        $this->artisan('demo:reset', ['--force' => true])->assertSuccessful();

        $this->assertSame($original['articles'], Article::count());
        $this->assertSame($original['faqs'], Faq::count());
        $this->assertSame($original['areas'], PracticeArea::where('is_published', true)->count());
        $this->assertSame($original['team'], TeamMember::count());
        $this->assertSame($original['samples'], ConsultationRequest::count(), 'hanya data contoh yang tersisa');
        $this->assertTrue(Article::query()->where('title', $originalTitle)->exists());
        $this->assertFalse(Article::query()->where('title', 'Judul diubah pengunjung demo')->exists());

        $demo = User::query()->where('is_demo', true)->sole();
        $this->assertTrue(Hash::check(config('firm.demo_account.password'), $demo->password));
        $this->assertSame(config('firm.demo_account.name'), $demo->name);
        $this->assertDatabaseMissing('sessions', ['id' => 'sesi-demo']);

        $this->assertModelExists($admin);
        Storage::disk('public')->assertMissing('articles/unggahan-pengunjung.webp');
        foreach (Article::all() as $article) {
            Storage::disk('public')->assertExists($article->cover_path);
        }
    }

    public function test_reset_dibatalkan_tanpa_menghapus_data_jika_konten_tidak_lengkap(): void
    {
        Storage::fake('public');
        $this->seed();
        $articles = Article::count();
        $request = ConsultationRequest::factory()->create();

        $this->app->useDatabasePath(storage_path('framework/testing/tanpa-konten'));

        $this->artisan('demo:reset', ['--force' => true])->assertFailed();

        $this->assertSame($articles, Article::count());
        $this->assertModelExists($request);
    }

    public function test_timer_systemd_reset_demo_tersedia_di_repo(): void
    {
        $timer = file_get_contents(base_path('deploy/systemd/company-profile-hukum-demo-reset.timer'));
        $service = file_get_contents(base_path('deploy/systemd/company-profile-hukum-demo-reset.service'));

        $this->assertStringContainsString('OnCalendar=*-*-* 00:00:00 Asia/Jakarta', $timer);
        $this->assertStringContainsString('artisan demo:reset --force', $service);
        $this->assertStringContainsString('User=www-data', $service);
    }
}
