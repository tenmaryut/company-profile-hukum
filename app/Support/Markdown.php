<?php

namespace App\Support;

use Illuminate\Support\Str;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\Footnote\FootnoteExtension;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Node\StringContainerHelper;

/**
 * Mengubah Markdown artikel menjadi HTML yang aman.
 *
 * HTML mentah dibuang dan tautan berbahaya (javascript:, data:) ditolak, karena
 * isi artikel bisa diubah lewat akun demo publik. Subjudul h2/h3 diberi id
 * supaya bisa dipakai sebagai daftar isi.
 */
class Markdown
{
    /**
     * @return array{html: string, toc: list<array{id: string, text: string, level: int}>}
     */
    public static function render(string $markdown): array
    {
        $toc = [];

        $environment = new Environment([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 20,
            'external_link' => [
                'internal_hosts' => [parse_url((string) config('app.url'), PHP_URL_HOST) ?: 'localhost'],
                'open_in_new_window' => false,
                'nofollow' => '',
                'noopener' => 'external',
                'noreferrer' => 'external',
            ],
            'footnote' => [
                'backref_symbol' => '↩',
            ],
        ]);

        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new AutolinkExtension);
        $environment->addExtension(new ExternalLinkExtension);
        $environment->addExtension(new FootnoteExtension);

        $environment->addEventListener(DocumentParsedEvent::class, function (DocumentParsedEvent $event) use (&$toc): void {
            $used = [];

            foreach ($event->getDocument()->iterator() as $node) {
                if (! $node instanceof Heading || $node->getLevel() < 2 || $node->getLevel() > 3) {
                    continue;
                }

                $text = trim(StringContainerHelper::getChildText($node));
                $id = Str::slug($text) ?: 'bagian';
                $base = $id;

                for ($i = 2; isset($used[$id]); $i++) {
                    $id = $base.'-'.$i;
                }

                $used[$id] = true;
                $node->data->set('attributes/id', $id);
                $toc[] = ['id' => $id, 'text' => $text, 'level' => $node->getLevel()];
            }
        });

        $html = (string) (new MarkdownConverter($environment))->convert($markdown);

        // Rapikan keluaran ekstensi catatan kaki: role doc-endnote sudah usang (DPUB-ARIA 1.1),
        // atribut rev tidak berlaku di HTML5, dan tautan kembali butuh nama yang jelas.
        $html = str_replace(
            [' role="doc-endnote"', ' rev="footnote"', 'class="footnote-backref"'],
            ['', '', 'class="footnote-backref" aria-label="Kembali ke teks"'],
            $html,
        );

        return ['html' => $html, 'toc' => $toc];
    }

    public static function plainText(string $markdown): string
    {
        $html = (string) (new MarkdownConverter(tap(new Environment(['html_input' => 'strip']), fn (Environment $env) => $env->addExtension(new CommonMarkCoreExtension))))->convert($markdown);

        return trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($html))));
    }
}
