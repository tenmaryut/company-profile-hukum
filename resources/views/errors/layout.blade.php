{{-- Layout halaman error: mandiri, tanpa database/session, supaya tetap tampil saat aplikasi bermasalah. --}}
@php
    try {
        $css = \Illuminate\Support\Facades\Vite::asset('resources/css/app.css');
    } catch (\Throwable) {
        $css = null;
    }
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{ config('firm.short_name') }}</title>
    <meta name="robots" content="noindex">
    <meta name="description" content="@yield('title'). {{ config('firm.demo_notice') }}">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    @if ($css)
        <link rel="stylesheet" href="{{ $css }}">
    @endif
</head>
<body class="flex min-h-screen flex-col">
    <x-demo-banner />
    <header class="border-b border-line">
        <div class="container-page flex h-[4.5rem] items-center">
            <a href="{{ url('/') }}" class="rounded-md no-underline" aria-label="{{ config('firm.name') }}, ke beranda"><x-logo /></a>
        </div>
    </header>
    <main class="flex flex-1 items-center">
        <div class="container-page grid gap-10 py-16 sm:py-24 md:grid-cols-[auto_1fr] md:items-center md:gap-16">
            <p class="font-display text-[5.5rem] leading-none text-brass sm:text-[8rem]" aria-hidden="true">@yield('code')</p>
            <div class="max-w-xl">
                <p class="eyebrow">Kode @yield('code')</p>
                <h1 class="mt-3 text-4xl sm:text-5xl">@yield('title')</h1>
                <p class="mt-4 text-lg text-ink-2">@yield('message')</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    @yield('actions')
                    <a href="{{ url('/') }}" class="btn btn-primary">Ke beranda</a>
                </div>
            </div>
        </div>
    </main>
    <footer class="border-t border-line">
        <div class="container-page py-6 text-sm text-muted">{{ config('firm.demo_notice') }}</div>
    </footer>
</body>
</html>
