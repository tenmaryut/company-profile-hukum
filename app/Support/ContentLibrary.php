<?php

namespace App\Support;

use Illuminate\Support\Str;
use RuntimeException;

/**
 * Membaca konten demo dari database/content (Markdown). Dipakai seeder dan
 * perintah demo:reset supaya isi situs bisa dikembalikan ke kondisi awal.
 *
 * - articles/*.md: frontmatter satu baris per kunci, lalu isi Markdown.
 * - halaman.md: bagian "## Profil", "## Etika", "## Bidang praktik", "## Tim", "## FAQ", "## Privasi".
 */
class ContentLibrary
{
    public function __construct(protected ?string $path = null)
    {
        $this->path ??= database_path('content');
    }

    /**
     * @return list<array{meta: array<string, string>, body: string}>
     */
    public function articles(): array
    {
        $files = glob($this->path.'/articles/*.md') ?: [];
        sort($files);

        return array_map(function (string $file): array {
            $text = str_replace("\r\n", "\n", (string) file_get_contents($file));

            if (! preg_match('/\A---\n(.*?)\n---\n(.*)\z/s', $text, $match)) {
                throw new RuntimeException("Frontmatter tidak ditemukan di {$file}.");
            }

            return ['meta' => $this->keyValues($match[1]), 'body' => trim($match[2])];
        }, $files);
    }

    public function coverPath(string $slug): ?string
    {
        $file = $this->path.'/covers/'.$slug.'.webp';

        return is_file($file) ? $file : null;
    }

    public function profile(): string
    {
        return $this->section('Profil');
    }

    public function ethics(): string
    {
        return $this->section('Etika');
    }

    public function privacy(): string
    {
        return $this->section('Privasi');
    }

    /**
     * @return list<array{name: string, slug: string, icon: string, summary: string, description: string, services: list<string>, legal_basis: list<string>}>
     */
    public function practiceAreas(): array
    {
        return array_map(function (array $entry): array {
            $fields = $this->fieldBlocks($entry['body'], ['slug', 'ikon', 'ringkasan', 'deskripsi', 'layanan', 'dasar_hukum']);

            return [
                'name' => $entry['title'],
                'slug' => $fields['slug'] ?: Str::slug($entry['title']),
                'icon' => $fields['ikon'] ?: 'timbangan',
                'summary' => $fields['ringkasan'],
                'description' => $fields['deskripsi'],
                'services' => $this->listItems($fields['layanan']),
                'legal_basis' => $this->listItems($fields['dasar_hukum']),
            ];
        }, $this->entries('Bidang praktik'));
    }

    /**
     * @return list<array{name: string, slug: string, position: string, focus: string, bio: string}>
     */
    public function team(): array
    {
        return array_map(function (array $entry): array {
            $fields = $this->fieldBlocks($entry['body'], ['slug', 'jabatan', 'fokus', 'bio']);

            return [
                'name' => $entry['title'],
                'slug' => $fields['slug'] ?: Str::slug($entry['title']),
                'position' => $fields['jabatan'],
                'focus' => $fields['fokus'],
                'bio' => $fields['bio'],
            ];
        }, $this->entries('Tim'));
    }

    /**
     * @return list<array{question: string, answer: string}>
     */
    public function faqs(): array
    {
        return array_map(fn (array $entry): array => [
            'question' => $entry['title'],
            'answer' => trim($entry['body']),
        ], $this->entries('FAQ'));
    }

    protected function halaman(): string
    {
        $file = $this->path.'/halaman.md';

        if (! is_file($file)) {
            throw new RuntimeException("File konten {$file} tidak ditemukan.");
        }

        return str_replace("\r\n", "\n", (string) file_get_contents($file));
    }

    protected function section(string $title): string
    {
        $parts = preg_split('/^## +/m', "\n".$this->halaman());

        foreach ($parts as $part) {
            [$heading, $body] = array_pad(explode("\n", $part, 2), 2, '');

            if (Str::lower(trim($heading)) === Str::lower($title)) {
                return trim($body);
            }
        }

        throw new RuntimeException("Bagian \"## {$title}\" tidak ditemukan di halaman.md.");
    }

    /**
     * @return list<array{title: string, body: string}>
     */
    protected function entries(string $section): array
    {
        $parts = preg_split('/^### +/m', "\n".$this->section($section));
        array_shift($parts);

        return array_values(array_map(function (string $part): array {
            [$title, $body] = array_pad(explode("\n", $part, 2), 2, '');

            return ['title' => trim($title), 'body' => trim($body)];
        }, $parts));
    }

    /**
     * Memecah teks "kunci: nilai" (nilai boleh berbaris-baris sampai kunci berikutnya).
     *
     * @param  list<string>  $keys
     * @return array<string, string>
     */
    protected function fieldBlocks(string $body, array $keys): array
    {
        $fields = array_fill_keys($keys, '');
        $current = null;
        $pattern = '/^\**('.implode('|', array_map('preg_quote', $keys)).')\**\s*:\s*\**\s*(.*)$/i';

        foreach (explode("\n", $body) as $line) {
            if (preg_match($pattern, trim($line), $match)) {
                $current = Str::lower($match[1]);
                $fields[$current] = trim($match[2]);

                continue;
            }

            if ($current !== null) {
                $fields[$current] .= "\n".$line;
            }
        }

        return array_map(fn (string $value): string => trim($value), $fields);
    }

    /** @return list<string> */
    protected function listItems(string $block): array
    {
        preg_match_all('/^\s*[-*]\s+(.+)$/m', $block, $matches);

        return array_values(array_map(fn (string $item): string => trim($item), $matches[1]));
    }

    /** @return array<string, string> */
    protected function keyValues(string $block): array
    {
        $values = [];

        foreach (explode("\n", $block) as $line) {
            if (preg_match('/^([a-z_]+):\s*(.*)$/', trim($line), $match)) {
                $values[$match[1]] = trim($match[2]);
            }
        }

        return $values;
    }
}
