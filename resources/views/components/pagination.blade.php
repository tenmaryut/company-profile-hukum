@if ($paginator->hasPages())
    <nav aria-label="Navigasi halaman" class="flex items-center justify-between gap-4 border-t border-line pt-6">
        @if ($paginator->onFirstPage())
            <span class="text-sm text-muted">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="btn btn-secondary"><x-ikon name="arrow-left" class="size-4" /> Sebelumnya</a>
        @endif
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="btn btn-secondary">Berikutnya <x-ikon name="arrow-right" class="size-4" /></a>
        @else
            <span class="text-sm text-muted">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</span>
        @endif
    </nav>
@endif
