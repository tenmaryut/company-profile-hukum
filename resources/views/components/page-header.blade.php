@props(['eyebrow' => null, 'title', 'lead' => null, 'breadcrumbs' => []])
<section class="border-b border-line bg-paper-2/60">
    <div class="container-page py-10 sm:py-14">
        @if ($breadcrumbs)
            <x-breadcrumbs :items="$breadcrumbs" class="mb-6" />
        @endif
        @if ($eyebrow)
            <p class="eyebrow">{{ $eyebrow }}</p>
        @endif
        <h1 class="mt-3 max-w-3xl text-4xl sm:text-5xl">{{ $title }}</h1>
        @if ($lead)
            <p class="mt-4 max-w-2xl text-lg text-ink-2">{{ $lead }}</p>
        @endif
        {{ $slot }}
    </div>
</section>
