<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\PageContent;
use App\Models\PracticeArea;
use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SeededContentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->seed();
    }

    public function test_konten_demo_memenuhi_brief(): void
    {
        $this->assertGreaterThanOrEqual(5, Article::published()->count());

        $names = PracticeArea::pluck('name')->implode('|');
        foreach (['Perdata', 'Pidana', 'Ketenagakerjaan', 'Data Pribadi'] as $area) {
            $this->assertStringContainsString($area, $names);
        }

        $bodies = Article::pluck('body')->implode("\n");
        $this->assertStringContainsString('Undang-Undang Nomor 1 Tahun 2023', $bodies);
        $this->assertStringContainsString('Undang-Undang Nomor 20 Tahun 2025', $bodies);

        $this->assertSame(['etika', 'privasi', 'profil'], PageContent::orderBy('key')->pluck('key')->all());
        $this->assertGreaterThanOrEqual(5, TeamMember::count());
    }

    public function test_setiap_artikel_punya_sampul_teks_alternatif_dan_penulis(): void
    {
        foreach (Article::with('author')->get() as $article) {
            $this->assertNotNull($article->cover_path, $article->slug);
            Storage::disk('public')->assertExists($article->cover_path);
            $this->assertNotEmpty($article->cover_alt, $article->slug);
            $this->assertNotNull($article->author, $article->slug);
            $this->assertLessThanOrEqual(160, mb_strlen($article->excerpt), $article->slug);
        }
    }

    public function test_semua_halaman_konten_tampil(): void
    {
        foreach (Article::all() as $article) {
            $this->get(route('articles.show', $article))->assertOk()->assertSee($article->title);
        }

        foreach (PracticeArea::all() as $area) {
            $this->get(route('practice-areas.show', $area))->assertOk()->assertSee($area->name);
        }

        $this->get('/')->assertOk();
        $this->get('/profil')->assertOk()->assertSee('fiktif');
        $this->get('/privasi')->assertOk()->assertSee('7 hari');
    }

    public function test_konten_bebas_klaim_terbaik_dan_janji_menang(): void
    {
        $texts = collect([
            Article::pluck('body'),
            PracticeArea::pluck('description'),
            PageContent::pluck('body'),
        ])->flatten()->implode("\n");

        $this->assertDoesNotMatchRegularExpression('/\b(ter)?baik di|nomor satu|paling terpercaya|pasti menang|dijamin menang|jaminan menang/iu', $texts);
    }
}
