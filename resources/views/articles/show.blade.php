@php
    $rendered = $article->rendered();
    $crumbs = [
        ['label' => 'Artikel', 'url' => route('articles.index')],
        ['label' => $article->category->name, 'url' => route('articles.category', $article->category)],
        ['label' => $article->title, 'url' => route('articles.show', $article)],
    ];
@endphp
<x-layouts.app
    :title="$article->title"
    :description="$article->excerpt"
    og-type="article"
    :og-image="$article->coverUrl() ? url($article->coverUrl()) : null"
    :og-image-alt="$article->cover_alt"
    :breadcrumbs="$crumbs"
    :schema="[\App\Support\StructuredData::article($article)]"
    :article="$article"
>
    <div class="read-progress" aria-hidden="true"></div>
    <article>
        <header class="border-b border-line bg-paper-2/60">
            <div class="container-page py-10 sm:py-14">
                <x-breadcrumbs :items="$crumbs" class="mb-6" />
                <p class="eyebrow">{{ $article->category->name }}</p>
                <h1 class="mt-3 max-w-4xl text-[2.125rem] sm:text-5xl">{{ $article->title }}</h1>
                <p class="mt-4 max-w-3xl text-lg text-ink-2">{{ $article->excerpt }}</p>
                <div class="mt-6 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-muted">
                    @if ($article->author)
                        <span class="flex items-center gap-2">
                            <x-avatar :variant="$article->author->avatar_variant" class="size-8 overflow-hidden rounded-full" />
                            <span>Oleh <a href="{{ route('team') }}#{{ $article->author->slug }}" class="font-semibold text-ink-2 underline-offset-4 hover:underline">{{ $article->author->name }}</a></span>
                        </span>
                    @endif
                    <span class="flex items-center gap-1.5">
                        <x-ikon name="calendar" class="size-4" />
                        <time datetime="{{ $article->published_at->toDateString() }}">{{ $article->published_at->translatedFormat('j F Y') }}</time>
                    </span>
                    <span class="flex items-center gap-1.5"><x-ikon name="clock" class="size-4" /> {{ $article->readingMinutes() }} menit baca</span>
                </div>
            </div>
        </header>

        <div class="container-page grid gap-10 py-10 sm:py-12 lg:grid-cols-[minmax(0,1fr)_17rem] lg:gap-14">
            <div class="min-w-0">
                @if ($article->coverUrl())
                    <figure class="overflow-hidden rounded-[var(--radius-card)] border border-line bg-paper-2">
                        <img src="{{ $article->coverUrl() }}" alt="{{ $article->cover_alt }}" width="1200" height="630" class="aspect-[40/21] w-full object-cover" fetchpriority="high" decoding="async">
                    </figure>
                @endif

                @if (count($rendered['toc']) > 2)
                    <nav class="card mt-8 p-5 lg:hidden" aria-labelledby="ns-daftar-isi-seluler">
                        <h2 id="ns-daftar-isi-seluler" class="font-sans text-sm font-semibold uppercase tracking-[0.14em] text-brass-ink">Daftar isi</h2>
                        <ol class="mt-3 space-y-2 text-[0.9375rem]">
                            @foreach ($rendered['toc'] as $item)
                                <li @class(['pl-4' => $item['level'] === 3])><a href="#{{ $item['id'] }}" class="text-ink-2 underline-offset-4 hover:text-ink hover:underline">{{ $item['text'] }}</a></li>
                            @endforeach
                        </ol>
                    </nav>
                @endif

                <div class="prose-legal article-body mt-8 max-w-[44rem]">
                    {!! $rendered['html'] !!}
                </div>

                <aside class="mt-12 max-w-[44rem] rounded-xl border border-brass bg-notice/30 p-5 text-[0.9375rem] text-ink-2" aria-label="Catatan artikel">
                    <p><strong class="text-ink">Catatan:</strong> artikel ini informasi umum berdasarkan peraturan yang berlaku saat ditulis ({{ $article->published_at->translatedFormat('j F Y') }}), bukan nasihat hukum untuk perkara tertentu. Peraturan dapat berubah; periksa status terbarunya di <a href="https://peraturan.bpk.go.id" class="font-semibold text-pine-700 underline" rel="noopener noreferrer">JDIH BPK</a>. Firma dan penulis di situs ini fiktif.</p>
                </aside>
            </div>

            <aside class="hidden lg:block">
                <div class="sticky top-6 space-y-6">
                    @if (count($rendered['toc']) > 2)
                        <nav aria-labelledby="ns-daftar-isi">
                            <h2 id="ns-daftar-isi" class="font-sans text-xs font-semibold uppercase tracking-[0.16em] text-brass-ink">Daftar isi</h2>
                            <ol class="mt-3 space-y-2.5 border-l border-line text-sm">
                                @foreach ($rendered['toc'] as $item)
                                    <li @class(['pl-4' => $item['level'] === 2, 'pl-7' => $item['level'] === 3])><a href="#{{ $item['id'] }}" class="text-ink-2 no-underline hover:text-ink hover:underline">{{ $item['text'] }}</a></li>
                                @endforeach
                            </ol>
                        </nav>
                    @endif
                    <div class="card p-5">
                        <h2 class="text-lg">Butuh penjelasan untuk kasus Anda?</h2>
                        <a href="{{ route('contact') }}#form-konsultasi" class="btn btn-primary mt-4 w-full">Minta konsultasi</a>
                    </div>
                </div>
            </aside>
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="border-t border-line bg-card" aria-labelledby="ns-artikel-lain">
            <div class="container-page py-14">
                <h2 id="ns-artikel-lain" class="text-3xl">Artikel lain</h2>
                <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $item)
                        <x-article-card :article="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
