<?php

namespace Tests\Unit;

use App\Support\ContentLibrary;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ContentLibraryTest extends TestCase
{
    protected string $dir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dir = storage_path('framework/testing/konten-'.uniqid());
        File::ensureDirectoryExists($this->dir.'/articles');

        File::put($this->dir.'/articles/01-contoh.md', "---\ntitle: Judul Contoh\nslug: judul-contoh\ncategory: perdata\nauthor: rani-paramitha\nexcerpt: Ringkasan.\ncover_alt: Ilustrasi\ncover_motif: buku\n---\nPembuka.\n\n## Bagian\n\nIsi.\n");
        File::put($this->dir.'/halaman.md', <<<'MD'
## Profil

Paragraf profil firma fiktif.

## Etika

Paragraf etika.

## Bidang praktik

### Hukum Perdata
slug: hukum-perdata
**ikon:** timbangan
ringkasan: Ringkasan bidang.
deskripsi:
Paragraf satu.

Paragraf dua.
layanan:
- Layanan A
- Layanan B
dasar_hukum:
- Kitab Undang-Undang Hukum Perdata

## Tim

### Rani Paramitha
slug: rani-paramitha
jabatan: Advokat Pengelola
fokus: Hukum bisnis
bio: Bio singkat.

## FAQ

### Bagaimana alurnya?
Jawaban pertama.

Paragraf kedua jawaban.

### Apakah gratis?
Jawaban kedua.

## Privasi

### Data yang dikumpulkan
Nama dan email.
MD);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->dir);

        parent::tearDown();
    }

    public function test_membaca_artikel_dan_frontmatter(): void
    {
        $articles = (new ContentLibrary($this->dir))->articles();

        $this->assertCount(1, $articles);
        $this->assertSame('judul-contoh', $articles[0]['meta']['slug']);
        $this->assertSame('buku', $articles[0]['meta']['cover_motif']);
        $this->assertStringStartsWith('Pembuka.', $articles[0]['body']);
    }

    public function test_membaca_bagian_halaman(): void
    {
        $content = new ContentLibrary($this->dir);

        $this->assertSame('Paragraf profil firma fiktif.', $content->profile());
        $this->assertSame('Paragraf etika.', $content->ethics());
        $this->assertStringContainsString('### Data yang dikumpulkan', $content->privacy());

        $area = $content->practiceAreas()[0];
        $this->assertSame('Hukum Perdata', $area['name']);
        $this->assertSame('timbangan', $area['icon']);
        $this->assertSame("Paragraf satu.\n\nParagraf dua.", $area['description']);
        $this->assertSame(['Layanan A', 'Layanan B'], $area['services']);
        $this->assertSame(['Kitab Undang-Undang Hukum Perdata'], $area['legal_basis']);

        $member = $content->team()[0];
        $this->assertSame(['Rani Paramitha', 'rani-paramitha', 'Advokat Pengelola', 'Hukum bisnis', 'Bio singkat.'], array_values($member));

        $faqs = $content->faqs();
        $this->assertCount(2, $faqs);
        $this->assertSame('Bagaimana alurnya?', $faqs[0]['question']);
        $this->assertSame("Jawaban pertama.\n\nParagraf kedua jawaban.", $faqs[0]['answer']);
    }
}
