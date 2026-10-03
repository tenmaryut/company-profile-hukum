@props(['article', 'headingLevel' => 'h3', 'eager' => false])
<div class="reveal lift h-full rounded-[var(--radius-card)]">
<article class="card group flex h-full flex-col overflow-hidden">
    <a href="{{ route('articles.show', $article) }}" class="block aspect-[40/21] overflow-hidden bg-paper-2" tabindex="-1" aria-hidden="true">
        @if ($article->coverUrl())
            <img src="{{ $article->coverUrl() }}" alt="" width="1200" height="630" class="h-full w-full object-cover motion-safe:transition-transform motion-safe:duration-300 motion-safe:group-hover:scale-[1.02]" @if ($eager) fetchpriority="high" @else loading="lazy" @endif decoding="async">
        @endif
    </a>
    <div class="flex flex-1 flex-col p-5 sm:p-6">
        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-brass-ink">{{ $article->category?->name }}</p>
        <{{ $headingLevel }} class="mt-2 font-display text-[1.375rem] leading-snug text-ink">
            <a href="{{ route('articles.show', $article) }}" class="no-underline hover:underline">{{ $article->title }}</a>
        </{{ $headingLevel }}>
        <p class="mt-3 flex-1 text-[0.9375rem] text-ink-2">{{ $article->excerpt }}</p>
        <p class="mt-4 flex items-center gap-2 text-sm text-muted">
            <x-ikon name="calendar" class="size-4" />
            <time datetime="{{ $article->published_at?->toDateString() }}">{{ $article->published_at?->translatedFormat('j F Y') }}</time>
            <span aria-hidden="true">·</span>
            <span>{{ $article->readingMinutes() }} menit baca</span>
        </p>
    </div>
</article>
</div>
