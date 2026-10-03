@php
    $nav = [
        ['label' => 'Profil', 'route' => 'profile', 'active' => 'profile'],
        ['label' => 'Bidang Praktik', 'route' => 'practice-areas.index', 'active' => 'practice-areas.*'],
        ['label' => 'Tim', 'route' => 'team', 'active' => 'team'],
        ['label' => 'Artikel', 'route' => 'articles.index', 'active' => 'articles.*'],
        ['label' => 'FAQ', 'route' => 'faq', 'active' => 'faq'],
        ['label' => 'Kontak', 'route' => 'contact', 'active' => 'contact'],
    ];
@endphp
<header class="site-header relative border-b border-line bg-paper">
    <div class="container-page flex h-[4.5rem] items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="rounded-md no-underline" aria-label="{{ config('firm.name') }}, ke beranda">
            <x-logo />
        </a>

        <nav class="hidden lg:block" aria-label="Navigasi utama">
            <ul class="flex items-center gap-1">
                @foreach ($nav as $item)
                    @php($active = request()->routeIs($item['active']))
                    <li>
                        <a href="{{ route($item['route']) }}" @if ($active) aria-current="page" @endif
                            @class(['rounded-full px-3.5 py-2 text-[0.9375rem] font-medium no-underline transition-colors', 'bg-paper-2 text-ink' => $active, 'text-ink-2 hover:bg-paper-2 hover:text-ink' => ! $active])>{{ $item['label'] }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="flex items-center gap-2">
            <a href="{{ route('contact') }}#form-konsultasi" class="btn btn-primary hidden sm:inline-flex">Minta konsultasi</a>

            <details class="nav-mobile lg:hidden">
                <summary class="flex min-h-11 items-center gap-2 rounded-full border border-line-2 px-4 font-semibold">
                    <x-ikon name="menu" class="nav-open size-5" />
                    <x-ikon name="x" class="nav-close size-5" />
                    <span>Menu</span>
                </summary>
                <nav class="absolute inset-x-0 top-full z-40 border-b border-line bg-card shadow-lg" aria-label="Navigasi seluler">
                    <ul class="container-page grid gap-1 py-3">
                        <li><a href="{{ route('home') }}" class="block rounded-lg px-3 py-3 font-medium no-underline hover:bg-paper-2" @if (request()->routeIs('home')) aria-current="page" @endif>Beranda</a></li>
                        @foreach ($nav as $item)
                            <li><a href="{{ route($item['route']) }}" class="block rounded-lg px-3 py-3 font-medium no-underline hover:bg-paper-2" @if (request()->routeIs($item['active'])) aria-current="page" @endif>{{ $item['label'] }}</a></li>
                        @endforeach
                        <li class="pt-2"><a href="{{ route('contact') }}#form-konsultasi" class="btn btn-primary w-full">Minta konsultasi</a></li>
                    </ul>
                </nav>
            </details>
        </div>
    </div>
</header>
