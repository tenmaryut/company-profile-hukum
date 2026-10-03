<?php

namespace Tests\Feature;

use App\Models\PageContent;
use App\Models\PracticeArea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Putaran 4: situs berjalan di balik Tailscale Funnel → Caddy (mode tunnel). PHP menerima
 * REMOTE_ADDR 127.0.0.1 dan header X-Forwarded-*; hanya proxy 127.0.0.1 yang dipercaya.
 */
class BehindProxyTest extends TestCase
{
    use RefreshDatabase;

    private const HOST = 'hukum.contoh.test';

    protected function setUp(): void
    {
        parent::setUp();

        foreach (['profil', 'etika', 'privasi'] as $key) {
            PageContent::create(['key' => $key, 'title' => $key, 'body' => 'Isi.']);
        }
    }

    /** Header yang dikirim Funnel lewat Caddy untuk satu pengunjung. */
    private function viaFunnel(string $visitorIp): static
    {
        return $this->withServerVariables(['REMOTE_ADDR' => '127.0.0.1'])->withHeaders([
            'X-Forwarded-For' => $visitorIp.', 127.0.0.1',
            'X-Forwarded-Proto' => 'https',
            'X-Forwarded-Host' => self::HOST,
            'Host' => self::HOST,
        ]);
    }

    /** @return array<string, mixed> */
    private function invalidForm(): array
    {
        // Sengaja tidak valid: rate limit tetap dihitung, tetapi tidak ada data yang tersimpan.
        return ['name' => '', 'email' => 'bukan-email', 'message' => 'pendek', 'form_started_at' => encrypt(now()->subMinute()->timestamp)];
    }

    public function test_ip_pengunjung_asli_dan_skema_https_dari_proxy_lokal(): void
    {
        $request = null;
        $this->app['router']->get('/_uji-proxy', function (\Illuminate\Http\Request $r) use (&$request) {
            $request = $r;

            return 'ok';
        });

        $this->viaFunnel('203.0.113.7')->get('/_uji-proxy')->assertOk();

        $this->assertSame('203.0.113.7', $request->ip());
        $this->assertTrue($request->isSecure());
        $this->assertSame('https://'.self::HOST, $request->getSchemeAndHttpHost());
    }

    public function test_header_proxy_dari_alamat_tak_dipercaya_diabaikan(): void
    {
        $request = null;
        $this->app['router']->get('/_uji-proxy', function (\Illuminate\Http\Request $r) use (&$request) {
            $request = $r;

            return 'ok';
        });

        $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.9'])
            ->withHeaders(['X-Forwarded-For' => '203.0.113.99', 'X-Forwarded-Proto' => 'https', 'X-Forwarded-Host' => 'palsu.example'])
            ->get('/_uji-proxy')
            ->assertOk();

        $this->assertSame('198.51.100.9', $request->ip(), 'IP palsu di X-Forwarded-For tidak boleh dipercaya');
        $this->assertFalse($request->isSecure());
        $this->assertNotSame('palsu.example', $request->getHost());
    }

    public function test_url_absolut_cookie_secure_dan_redirect_https(): void
    {
        config(['session.secure' => null]); // biarkan Laravel menentukan dari skema request

        $response = $this->viaFunnel('203.0.113.7')->get('/');

        $response->assertOk()
            ->assertSee('<link rel="canonical" href="https://'.self::HOST, false)
            ->assertSee('content="https://'.self::HOST.'/images/og-default.png"', false)
            ->assertDontSee('http://'.self::HOST, false);

        foreach ($response->headers->getCookies() as $cookie) {
            $this->assertTrue($cookie->isSecure(), "cookie {$cookie->getName()} harus Secure");
        }

        $redirect = $this->viaFunnel('203.0.113.7')->post('/kontak', $this->invalidForm())->assertRedirect();
        $this->assertStringStartsWith('https://'.self::HOST, $redirect->headers->get('Location'));
    }

    public function test_rate_limit_terpisah_per_pengunjung_di_balik_proxy(): void
    {
        Notification::fake();

        for ($i = 1; $i <= 5; $i++) {
            $this->viaFunnel('203.0.113.10')->post('/kontak', $this->invalidForm())
                ->assertHeader('X-RateLimit-Remaining', (string) (5 - $i))
                ->assertSessionMissing('errors.form');
        }

        // Pengunjung A kena batas ...
        $this->viaFunnel('203.0.113.10')->post('/kontak', $this->invalidForm())
            ->assertHeader('Retry-After')
            ->assertSessionHasErrors('form');

        // ... sedangkan pengunjung B punya kuota sendiri.
        $this->viaFunnel('203.0.113.20')->post('/kontak', $this->invalidForm())
            ->assertHeader('X-RateLimit-Remaining', '4')
            ->assertSessionDoesntHaveErrors('form');

        $this->assertDatabaseCount('consultation_requests', 0);
    }
}
