@props([
    'title' => null,
    'description' => null,
    'canonical' => null,
    'ogImage' => null,
    'ogImageAlt' => null,
    'ogType' => 'website',
    'robots' => 'index, follow',
    'breadcrumbs' => [],
    'schema' => [],
    'article' => null,
])
@php
    $fullTitle = $title ? $title.' | '.config('firm.short_name') : config('firm.name').': '.config('firm.tagline');
    $description = $description ?: config('firm.description');
    $canonical = $canonical ?: url()->current();
    $ogImage = $ogImage ?: asset('images/og-default.png');
    $graph = [\App\Support\StructuredData::legalService(), $breadcrumbs ? \App\Support\StructuredData::breadcrumbs($breadcrumbs) : null, ...$schema];
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $fullTitle }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="robots" content="{{ $robots }}">
    <link rel="canonical" href="{{ $canonical }}">
    <meta name="theme-color" content="#f7f3ea">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="preload" href="{{ Vite::asset('resources/fonts/newsreader-latin-600-normal.woff2') }}" as="font" type="font/woff2" crossorigin>
    @vite('resources/css/app.css')

    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="{{ config('firm.name') }} (situs demo)">
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:title" content="{{ $title ?: config('firm.name') }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:alt" content="{{ $ogImageAlt ?: config('firm.name').', situs demo portofolio' }}">
    @if ($article)
        <meta property="article:published_time" content="{{ $article->published_at?->toIso8601String() }}">
        <meta property="article:modified_time" content="{{ $article->updated_at?->toIso8601String() }}">
        <meta property="article:section" content="{{ $article->category?->name }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?: config('firm.name') }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
    {!! \App\Support\StructuredData::toScript($graph) !!}
</head>
<body class="min-h-screen flex flex-col">
    <a href="#konten" class="sr-only focus:not-sr-only focus:fixed focus:left-3 focus:top-3 focus:z-50 focus:rounded-full focus:bg-ink focus:px-4 focus:py-2 focus:text-paper">Langsung ke konten utama</a>
    <x-demo-banner />
    <x-site-header />
    <main id="konten" class="flex-1">
        {{ $slot }}
    </main>
    <x-site-footer />
</body>
</html>
