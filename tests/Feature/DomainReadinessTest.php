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

    public function test_tidak_ada_alamat_staging_atau_ip_vps_di_berkas_proyek(): void
    {
        // Pola dirakit di sini supaya berkas test ini tidak ikut cocok.
        $patterns = ['sslip'.'.io', '169.58'.'.123.8', '169-58'.'-123-8', '2a02:'.'c207'];
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
                if (str_contains($contents, $pattern)) {
                    $found[] = str_replace(base_path().'/', '', $path)." ({$pattern})";
                }
            }
        }

        $this->assertSame([], $found, 'Alamat situs harus dibaca dari domain.env.');
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
}
