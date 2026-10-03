@php
    $crumbs = [['label' => 'Artikel', 'url' => route('articles.index')]];
    if ($activeCategory) {
        $crumbs[] = ['label' => $activeCategory->name, 'url' => route('articles.category', $activeCategory)];
    }
    $title = $activeCategory ? 'Artikel '.$activeCategory->name : 'Artikel Hukum';
    $description = $activeCategory?->description ?: 'Artikel hukum berbahasa Indonesia dari Nalar Saksama (situs demo): KUHP Nasional, KUHAP baru, pelindungan data pribadi, perjanjian, dan ketenagakerjaan.';
    $formAction = $activeCategory ? route('articles.category', $activeCategory) : route('articles.index');
@endphp
<x-layouts.app
    :title="$search !== '' ? 'Hasil pencarian: '.$search : ($articles->currentPage() > 1 ? $title.' (halaman '.$articles->currentPage().')' : $title)"
    :description="$description"
    :breadcrumbs="$crumbs"
    :robots="$search !== '' ? 'noindex, follow' : 'index, follow'"
    :canonical="$articles->currentPage() > 1 ? $articles->url($articles->currentPage()) : $formAction"
>
    <x-page-header
        eyebrow="Artikel hukum"
        :title="$activeCategory ? 'Kategori: '.$activeCategory->name : 'Memahami aturan yang berlaku'"
        :lead="$activeCategory?->description ?: 'Penjelasan ringkas tentang peraturan yang berlaku, dengan rujukan ke sumber resmi. Artikel bersifat informasi umum, bukan nasihat hukum.'"
        :breadcrumbs="$crumbs"
    >
        <form method="GET" action="{{ $formAction }}" role="search" class="mt-8 flex max-w-xl gap-2">
            <label for="q" class="sr-only">Cari artikel</label>
            <div class="relative flex-1">
                <x-ikon name="search" class="pointer-events-none absolute left-3.5 top-1/2 size-5 -translate-y-1/2 text-muted" />
                <input type="search" id="q" name="q" value="{{ $search }}" placeholder="Cari, mis. wanprestasi" class="field-input pl-11" maxlength="100">
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </x-page-header>

    <section class="container-page py-12 sm:py-14">
        <nav aria-label="Kategori artikel">
            <ul class="flex flex-wrap gap-2">
                <li>
                    <a href="{{ route('articles.index') }}" @if (! $activeCategory) aria-current="page" @endif
                        @class(['inline-flex min-h-10 items-center rounded-full border px-4 text-sm font-medium no-underline', 'border-ink bg-ink text-paper' => ! $activeCategory, 'border-line-2 text-ink-2 hover:border-ink' => $activeCategory])>Semua</a>
                </li>
                @foreach ($categories as $category)
                    @php($isActive = $activeCategory?->is($category))
                    <li>
                        <a href="{{ route('articles.category', $category) }}" @if ($isActive) aria-current="page" @endif
                            @class(['inline-flex min-h-10 items-center gap-1.5 rounded-full border px-4 text-sm font-medium no-underline', 'border-ink bg-ink text-paper' => $isActive, 'border-line-2 text-ink-2 hover:border-ink' => ! $isActive])>
                            {{ $category->name }} <span @class(['text-xs', 'text-paper/80' => $isActive, 'text-muted' => ! $isActive])>({{ $category->articles_count }})</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        @if ($search !== '')
            <p class="mt-8 text-ink-2" role="status">
                {{ $articles->total() }} artikel ditemukan untuk <strong>“{{ $search }}”</strong>.
                <a href="{{ $formAction }}" class="font-semibold text-pine-700 underline">Hapus pencarian</a>
            </p>
        @endif

        @if ($articles->isEmpty())
            <div class="card mt-8 p-8 text-center">
                <h2 class="text-2xl">Belum ada artikel yang cocok</h2>
                <p class="mt-2 text-ink-2">Coba kata kunci lain atau lihat semua artikel.</p>
                <a href="{{ route('articles.index') }}" class="btn btn-secondary mt-5">Semua artikel</a>
            </div>
        @else
            <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($articles as $article)
                    <x-article-card :article="$article" heading-level="h2" :eager="$loop->first" />
                @endforeach
            </div>
            <div class="mt-10">
                {{ $articles->onEachSide(1)->links('components.pagination') }}
            </div>
        @endif
    </section>
</x-layouts.app>
