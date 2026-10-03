@props(['items' => []])
<nav aria-label="Breadcrumb" {{ $attributes->merge(['class' => 'text-sm']) }}>
    <ol class="flex flex-wrap items-center gap-1.5 text-muted">
        <li><a href="{{ route('home') }}" class="text-muted underline-offset-4 hover:text-ink">Beranda</a></li>
        @foreach ($items as $item)
            <li class="flex items-center gap-1.5">
                <x-ikon name="chevron-right" class="size-3.5" />
                @if ($loop->last)
                    <span aria-current="page" class="text-ink-2">{{ $item['label'] }}</span>
                @else
                    <a href="{{ $item['url'] }}" class="text-muted underline-offset-4 hover:text-ink">{{ $item['label'] }}</a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
