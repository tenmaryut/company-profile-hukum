<?php

namespace Tests\Feature;

use App\Filament\Resources\Articles\Pages\CreateArticle;
use App\Filament\Resources\ConsultationRequests\ConsultationRequestResource;
use App\Filament\Resources\ConsultationRequests\Pages\ListConsultationRequests;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ConsultationRequest;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('admin');
    }

    public function test_tamu_diarahkan_ke_halaman_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/artikel')->assertRedirect('/admin/login');
        $this->get('/admin/permintaan-konsultasi')->assertRedirect('/admin/login');
    }

    public function test_halaman_login_menampilkan_akun_demo_dan_banner(): void
    {
        $this->get('/admin/login')
            ->assertOk()
            ->assertSee(config('firm.demo_account.email'))
            ->assertSee(config('firm.demo_account.password'))
            ->assertSee(config('firm.demo_notice'));
    }

    /** @return array<string, array{string}> */
    public static function adminPages(): array
    {
        return [
            'dasbor' => ['/admin'],
            'bidang praktik' => ['/admin/bidang-praktik'],
            'tim' => ['/admin/tim'],
            'artikel' => ['/admin/artikel'],
            'artikel baru' => ['/admin/artikel/create'],
            'kategori' => ['/admin/kategori-artikel'],
            'faq' => ['/admin/faq'],
            'teks halaman' => ['/admin/teks-halaman'],
            'permintaan konsultasi' => ['/admin/permintaan-konsultasi'],
        ];
    }

    #[DataProvider('adminPages')]
    public function test_akun_demo_bisa_membuka_panel(string $url): void
    {
        $this->actingAs(User::factory()->demo()->create())
            ->get($url)
            ->assertOk()
            ->assertSee(config('firm.demo_notice'));
    }

    public function test_akun_demo_hanya_melihat_data_contoh_dan_kirimannya_sendiri(): void
    {
        $demo = User::factory()->demo()->create();
        $sample = ConsultationRequest::factory()->sample()->create();
        $own = ConsultationRequest::factory()->create(['submitter_token_hash' => ConsultationRequest::hashToken(str_repeat('a', 40))]);
        $other = ConsultationRequest::factory()->create(['submitter_token_hash' => ConsultationRequest::hashToken(str_repeat('b', 40))]);

        $this->actingAs($demo)->get(ConsultationRequestResource::getUrl('view', ['record' => $sample]))->assertOk();
        $this->actingAs($demo)->get(ConsultationRequestResource::getUrl('view', ['record' => $other]))->assertNotFound();
        $this->actingAs($demo)->get(ConsultationRequestResource::getUrl('view', ['record' => $own]))->assertNotFound();

        $this->actingAs($demo)
            ->withCookie(ConsultationRequest::SUBMITTER_COOKIE, str_repeat('a', 40))
            ->get(ConsultationRequestResource::getUrl('view', ['record' => $own]))
            ->assertOk()
            ->assertSee($own->name);

        $this->actingAs($demo);
        Livewire::test(ListConsultationRequests::class)
            ->assertCanSeeTableRecords([$sample])
            ->assertCanNotSeeTableRecords([$other, $own]);
    }

    public function test_admin_asli_melihat_semua_kiriman(): void
    {
        $admin = User::factory()->create();
        $requests = ConsultationRequest::factory()->count(3)->create();

        $this->actingAs($admin);
        Livewire::test(ListConsultationRequests::class)->assertCanSeeTableRecords($requests);
        $this->get(ConsultationRequestResource::getUrl('view', ['record' => $requests->first()]))->assertOk();
    }

    public function test_akun_demo_tidak_bisa_mengubah_profil_sendiri(): void
    {
        $this->actingAs(User::factory()->demo()->create())->get('/admin/profile')->assertForbidden();
        $this->actingAs(User::factory()->create())->get('/admin/profile')->assertOk();
    }

    public function test_permintaan_konsultasi_tidak_bisa_dibuat_dari_admin(): void
    {
        $this->actingAs(User::factory()->create())->get('/admin/permintaan-konsultasi/create')->assertNotFound();
    }

    public function test_admin_bisa_membuat_artikel_dengan_gambar(): void
    {
        Storage::fake('public');
        $category = ArticleCategory::factory()->create();
        $this->actingAs(User::factory()->demo()->create());

        Livewire::test(CreateArticle::class)
            ->fillForm([
                'title' => 'Artikel Uji Coba',
                'slug' => 'artikel-uji-coba',
                'excerpt' => 'Ringkasan artikel uji coba.',
                'body' => "## Subjudul\n\nIsi artikel.",
                'article_category_id' => $category->id,
                'published_at' => now()->subHour(),
                'cover_path' => UploadedFile::fake()->image('sampul.png', 1200, 630),
                'cover_alt' => 'Ilustrasi uji',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $article = Article::sole();
        $this->assertSame('artikel-uji-coba', $article->slug);
        Storage::disk('public')->assertExists($article->cover_path);
        $this->assertStringEndsWith('.webp', $article->cover_path);
    }

    public function test_unggahan_svg_dan_file_terlalu_besar_ditolak(): void
    {
        Storage::fake('public');
        $category = ArticleCategory::factory()->create();
        $this->actingAs(User::factory()->create());

        $base = [
            'title' => 'Artikel Upload',
            'slug' => 'artikel-upload',
            'excerpt' => 'Ringkasan.',
            'body' => 'Isi.',
            'article_category_id' => $category->id,
            'cover_alt' => 'Ilustrasi',
        ];

        Livewire::test(CreateArticle::class)
            ->fillForm([...$base, 'cover_path' => UploadedFile::fake()->createWithContent('sampul.svg', '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>')])
            ->call('create')
            ->assertHasFormErrors(['cover_path']);

        Livewire::test(CreateArticle::class)
            ->fillForm([...$base, 'cover_path' => UploadedFile::fake()->image('besar.jpg')->size(4096)])
            ->call('create')
            ->assertHasFormErrors(['cover_path']);

        $this->assertDatabaseCount('articles', 0);
    }
}
