<?php

namespace App\Support;

use App\Models\Article;
use Illuminate\Support\Collection;

/**
 * Data terstruktur schema.org (JSON-LD). Sengaja tidak menyentuh database untuk
 * entitas firma, supaya halaman error 500 tetap bisa memuatnya.
 */
class StructuredData
{
    public static function legalService(array $knowsAbout = []): array
    {
        $address = config('firm.address');

        return array_filter([
            '@type' => 'LegalService',
            '@id' => url('/').'#firma',
            'name' => config('firm.name'),
            'alternateName' => config('firm.short_name'),
            'description' => config('firm.description'),
            'url' => url('/'),
            'logo' => asset('images/logo-512.png'),
            'image' => asset('images/og-default.png'),
            'email' => config('firm.email'),
            'telephone' => config('firm.phone'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $address['street'],
                'addressLocality' => $address['locality'],
                'addressRegion' => $address['region'],
                'postalCode' => $address['postal_code'],
                'addressCountry' => $address['country'],
            ],
            'openingHoursSpecification' => [[
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'opens' => '09:00',
                'closes' => '17:00',
            ]],
            'areaServed' => ['@type' => 'Country', 'name' => 'Indonesia'],
            'knowsAbout' => $knowsAbout ?: null,
        ]);
    }

    /** @param list<array{label: string, url: string}> $items */
    public static function breadcrumbs(array $items): array
    {
        $list = [['label' => 'Beranda', 'url' => url('/')], ...$items];

        return [
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($list)->values()->map(fn (array $item, int $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item['label'],
                'item' => $item['url'],
            ])->all(),
        ];
    }

    public static function article(Article $article): array
    {
        return array_filter([
            '@type' => 'Article',
            '@id' => route('articles.show', $article).'#artikel',
            'headline' => $article->title,
            'description' => $article->excerpt,
            'image' => $article->coverUrl() ? [url($article->coverUrl())] : null,
            'datePublished' => $article->published_at?->toIso8601String(),
            'dateModified' => $article->updated_at?->toIso8601String(),
            'inLanguage' => 'id-ID',
            'articleSection' => $article->category?->name,
            'author' => $article->author
                ? ['@type' => 'Person', 'name' => $article->author->name, 'url' => route('team').'#'.$article->author->slug]
                : ['@id' => url('/').'#firma'],
            'publisher' => ['@id' => url('/').'#firma'],
            'mainEntityOfPage' => route('articles.show', $article),
        ]);
    }

    /** @param Collection<int, \App\Models\Faq> $faqs */
    public static function faqPage(Collection $faqs): array
    {
        return [
            '@type' => 'FAQPage',
            'mainEntity' => $faqs->map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq->question,
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => Markdown::plainText($faq->answer)],
            ])->values()->all(),
        ];
    }

    public static function toScript(array $graph): string
    {
        $json = json_encode(
            ['@context' => 'https://schema.org', '@graph' => array_values(array_filter($graph))],
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP
        );

        return '<script type="application/ld+json">'.$json.'</script>';
    }
}
