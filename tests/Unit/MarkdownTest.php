<?php

namespace Tests\Unit;

use App\Support\Markdown;
use Tests\TestCase;

class MarkdownTest extends TestCase
{
    public function test_html_mentah_dan_tautan_berbahaya_dibuang(): void
    {
        $html = Markdown::render("<script>alert(1)</script>\n\n[klik](javascript:alert(1)) <img src=x onerror=alert(1)>")['html'];

        $this->assertStringNotContainsString('<script', $html);
        $this->assertStringNotContainsString('javascript:', $html);
        $this->assertStringNotContainsString('onerror', $html);
    }

    public function test_subjudul_diberi_id_untuk_daftar_isi(): void
    {
        $result = Markdown::render("## Syarat Sah\n\nTeks.\n\n### Kecakapan\n\n## Syarat Sah\n");

        $this->assertStringContainsString('<h2 id="syarat-sah">', $result['html']);
        $this->assertStringContainsString('<h2 id="syarat-sah-2">', $result['html']);
        $this->assertSame(['syarat-sah', 'kecakapan', 'syarat-sah-2'], array_column($result['toc'], 'id'));
    }

    public function test_catatan_kaki_dan_tautan_eksternal(): void
    {
        $html = Markdown::render("Teks[^1] dan [JDIH](https://peraturan.bpk.go.id).\n\n[^1]: Rujukan.")['html'];

        $this->assertStringContainsString('footnote', $html);
        $this->assertStringContainsString('rel="noopener noreferrer"', $html);
        $this->assertStringNotContainsString('doc-endnote"', $html, 'role usang doc-endnote dibuang');
        $this->assertStringContainsString('aria-label="Kembali ke teks"', $html);
    }
}
