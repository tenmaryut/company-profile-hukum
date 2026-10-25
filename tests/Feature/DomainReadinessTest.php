<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\PageContent;
use App\Models\PracticeArea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Tests\TestCase;

/**
 * Putaran 2: alamat situs hanya dari domain.env, gerbang staging di Caddy,
 * dan halaman publik yang tetap patuh CSP ketat (tanpa style/script inline).
 */
class DomainReadinessTest extends TestCase
{
    use RefreshDatabase;

    public function test_tidak_ada_alamat_staging_di_berkas_proyek(): void
    {
        // Pola dirakit di sini supaya berkas test ini tidak ikut cocok.
        $this->assertSame([], $this->filesMatching(['ss'.'lip\.io']), 'Alamat situs harus dibaca dari domain.env.');
    }

    public function test_tidak_ada_ip_vps_di_berkas_proyek(): void
    {
        // Pola IP dibaca dari denylist di luar repo (sama dengan hook git), jadi IP server tidak pernah
        // tertulis di repo ini, termasuk dalam bentuk regex atau sambungan string.
        $denylist = getenv('DENYLIST') ?: getenv('HOME').'/.config/git/denylist-publik';
        $patterns = is_readable($denylist) ? array_values(array_filter(array_map('trim', file($denylist)))) : [];

        if ($patterns === []) {
            $this->markTestSkipped("Tidak ada pola di {$denylist}, jadi IP server tidak dicek.");
        }

        $this->assertSame([], $this->filesMatching($patterns), 'IP server tidak boleh ada di berkas proyek.');
    }

    public function test_template_caddy_memuat_gerbang_staging_dan_csp_publik_tanpa_unsafe_inline(): void
    {
        $caddy = file_get_contents(base_path('deploy/company-profile-hukum.caddy.tmpl'));

        $this->assertMatchesRegularExpression('/^(http:\/\/)?__HUKUM_HOST__ \{\n\timport gerbang_staging\n/m', $caddy);
        $this->assertStringContainsString('php_fastcgi', $caddy);

        preg_match('/header @public Content-Security-Policy "([^"]+)"/', $caddy, $public);
        $this->assertNotEmpty($public, 'CSP publik harus ada.');
        $this->assertStringNotContainsString('unsafe-inline', $public[1]);
        $this->assertStringNotContainsString('unsafe-eval', $public[1]);

        $deploy = file_get_contents(base_path('deploy/deploy.sh'));
        $this->assertStringContainsString('domain.env', $deploy);
        $this->assertStringContainsString('HUKUM_URL', $deploy);
    }

    public function test_halaman_publik_tanpa_style_atau_script_inline(): void
    {
        $area = PracticeArea::factory()->create();
        $article = Article::factory()->create(['body' => "Pembuka.\n\n## Satu\n\nTeks[^1].\n\n## Dua\n\n## Tiga\n\n[^1]: Catatan."]);
        foreach (['profil', 'etika', 'privasi'] as $key) {
            PageContent::create(['key' => $key, 'title' => $key, 'body' => 'Isi.']);
        }

        foreach (['/', '/profil', '/bidang-praktik', '/bidang-praktik/'.$area->slug, '/tim', '/faq', '/kontak', '/artikel', '/artikel/'.$article->slug, '/privasi', '/tidak-ada'] as $url) {
            $html = $this->get($url)->getContent();

            $this->assertDoesNotMatchRegularExpression('/\sstyle="/', $html, "style inline di {$url}");
            $this->assertDoesNotMatchRegularExpression('/<style[\s>]/', $html, "tag <style> di {$url}");
            $this->assertSame(0, preg_match_all('/<script(?![^>]*type="application\/ld\+json")/', $html), "script inline di {$url}");
            $this->assertDoesNotMatchRegularExpression('/\son[a-z]+="/', $html, "atribut event inline di {$url}");
        }
    }

    /**
     * Berkas proyek (di luar docs/ dan hasil build) yang memuat salah satu pola regex.
     * Hanya jalur dan nomor baris yang dilaporkan, supaya IP tidak ikut tampil di log test.
     */
    private function filesMatching(array $patterns): array
    {
        $skip = ['/vendor/', '/node_modules/', '/docs/', '/.git/', '/storage/', '/public/build/', '/public/js/filament/', '/public/css/filament/', '/public/fonts/filament/', '/test-results/', '/playwright-report/', '/database/content/covers/', '/bootstrap/cache/'];
        $found = [];

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(base_path(), RecursiveDirectoryIterator::SKIP_DOTS));

        foreach ($files as $file) {
            $path = str_replace('\\', '/', $file->getPathname());

            if (! $file->isFile() || $file->getSize() > 2_000_000 || preg_match('/\.(png|jpe?g|webp|ico|woff2|sqlite|webm|zip)$/', $path)) {
                continue;
            }

            foreach ($skip as $dir) {
                if (str_contains($path, $dir)) {
                    continue 2;
                }
            }

            $contents = file_get_contents($path);

            foreach ($patterns as $pattern) {
                if (preg_match('~'.str_replace('~', '\~', $pattern).'~', $contents, $match, PREG_OFFSET_CAPTURE)) {
                    $found[] = str_replace(base_path().'/', '', $path).':'.(substr_count($contents, "\n", 0, $match[0][1]) + 1);
                }
            }
        }

        return $found;
    }
}
