<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Faq;
use App\Models\PageContent;
use App\Models\PracticeArea;
use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        PracticeArea::factory()->create(['name' => 'Hukum Perdata', 'slug' => 'hukum-perdata']);
        TeamMember::factory()->create(['name' => 'Rani Paramitha', 'slug' => 'rani-paramitha']);
        Faq::factory()->create(['question' => 'Bagaimana alur konsultasi?']);
        foreach (['profil', 'etika', 'privasi'] as $key) {
            PageContent::create(['key' => $key, 'title' => PageContent::KEYS[$key], 'body' => "Isi blok {$key}."]);
        }
    }

    /** @return array<string, array{string}> */
    public static function pages(): array
    {
        return [
            'beranda' => ['/'],
            'profil' => ['/profil'],
            'bidang praktik' => ['/bidang-praktik'],
            'detail bidang' => ['/bidang-praktik/hukum-perdata'],
            'tim' => ['/tim'],
            'faq' => ['/faq'],
            'kontak' => ['/kontak'],
            'artikel' => ['/artikel'],
            'privasi' => ['/privasi'],
        ];
    }

    #[DataProvider('pages')]
    public function test_halaman_publik_tampil_dengan_banner_demo_dan_meta_seo(string $url): void
    {
        $response = $this->get($url);

        $response->assertOk()
            ->assertSee(config('firm.demo_notice'))
            ->assertSee('<meta name="description"', false)
            ->assertSee('<link rel="canonical"', false)
            ->assertSee('<meta property="og:title"', false)
            ->assertSee('"@type":"LegalService"', false)
            ->assertSee('<html lang="id">', false);
    }

    public function test_artikel_terbit_tampil_lengkap(): void
    {
        $article = Article::factory()->create([
            'title' => 'Memahami Wanprestasi',
            'slug' => 'memahami-wanprestasi',
            'body' => "Pembuka.\n\n## Syarat sah\n\nTeks[^1].\n\n## Akibat\n\nTeks.\n\n## Upaya\n\nTeks.\n\n[^1]: Pasal 1320 KUHPerdata.",
            'cover_path' => 'articles/memahami-wanprestasi.webp',
            'cover_alt' => 'Ilustrasi timbangan',
        ]);

        $this->get('/artikel/memahami-wanprestasi')
            ->assertOk()
            ->assertSee('Memahami Wanprestasi')
            ->assertSee('id="syarat-sah"', false)
            ->assertSee('Daftar isi')
            ->assertSee('alt="Ilustrasi timbangan"', false)
            ->assertSee('"@type":"Article"', false)
            ->assertSee('"@type":"BreadcrumbList"', false)
            ->assertSee('<meta property="og:type" content="article">', false)
            ->assertSee('footnote', false);

        $this->get('/artikel')->assertOk()->assertSee($article->title);
    }

    public function test_draf_dan_terjadwal_tidak_bisa_dibuka_publik(): void
    {
        $draft = Article::factory()->draft()->create();
        $scheduled = Article::factory()->create(['published_at' => now()->addDay()]);

        $this->get('/artikel/'.$draft->slug)->assertNotFound();
        $this->get('/artikel/'.$scheduled->slug)->assertNotFound();
        $this->get('/artikel')->assertDontSee($draft->title)->assertDontSee($scheduled->title);
    }

    public function test_pencarian_dan_filter_kategori_artikel(): void
    {
        $pidana = ArticleCategory::factory()->create(['name' => 'Pidana', 'slug' => 'pidana']);
        $perdata = ArticleCategory::factory()->create(['name' => 'Perdata', 'slug' => 'perdata']);
        $kuhp = Article::factory()->for($pidana, 'category')->create(['title' => 'KUHP Nasional mulai berlaku']);
        $kontrak = Article::factory()->for($perdata, 'category')->create(['title' => 'Syarat sah perjanjian', 'body' => 'Membahas wanprestasi.']);

        $this->get('/artikel?q=wanprestasi')
            ->assertOk()
            ->assertSee($kontrak->title)
            ->assertDontSee($kuhp->title)
            ->assertSee('noindex, follow', false);

        $this->get('/artikel/kategori/pidana')
            ->assertOk()
            ->assertSee($kuhp->title)
            ->assertDontSee($kontrak->title);

        $this->get('/artikel?q=tidak-ada-yang-cocok')->assertOk()->assertSee('Belum ada artikel yang cocok');
    }

    public function test_bidang_praktik_yang_disembunyikan_tidak_tampil(): void
    {
        $hidden = PracticeArea::factory()->create(['is_published' => false]);

        $this->get('/bidang-praktik/'.$hidden->slug)->assertNotFound();
        $this->get('/bidang-praktik')->assertDontSee($hidden->name);
    }

    public function test_sitemap_dan_robots(): void
    {
        $article = Article::factory()->create();

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee(route('articles.show', $article), false)
            ->assertSee(route('practice-areas.show', 'hukum-perdata'), false);

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /admin')
            ->assertSee('Sitemap: '.route('sitemap'));
    }

    public function test_halaman_404_khusus(): void
    {
        $this->get('/halaman-yang-tidak-ada')
            ->assertNotFound()
            ->assertSee('Halaman tidak ditemukan')
            ->assertSee(config('firm.demo_notice'));
    }

    public function test_halaman_500_khusus(): void
    {
        config(['app.debug' => false]);
        Route::get('/uji-error', fn () => throw new \RuntimeException('uji'));

        $this->get('/uji-error')
            ->assertStatus(500)
            ->assertSee('Terjadi kesalahan di server')
            ->assertDontSee('RuntimeException');
    }

    public function test_tombol_whatsapp_memakai_nomor_placeholder(): void
    {
        $this->get('/kontak')
            ->assertOk()
            ->assertSee('https://wa.me/'.config('firm.whatsapp'), false)
            ->assertSee('placeholder');
    }
}
