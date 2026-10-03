@php
    $crumbs = [
        ['label' => 'Bidang Praktik', 'url' => route('practice-areas.index')],
        ['label' => $practiceArea->name, 'url' => route('practice-areas.show', $practiceArea)],
    ];
@endphp
<x-layouts.app
    :title="$practiceArea->name"
    :description="$practiceArea->summary"
    :breadcrumbs="$crumbs"
>
    <x-page-header
        eyebrow="Bidang praktik"
        :title="$practiceArea->name"
        :lead="$practiceArea->summary"
        :breadcrumbs="$crumbs"
    />

    <section class="container-page grid gap-12 py-14 sm:py-16 lg:grid-cols-[1.25fr_0.75fr]">
        <div>
            <div class="prose-legal">
                {!! \App\Support\Markdown::render($practiceArea->description)['html'] !!}
            </div>

            @if ($practiceArea->services)
                <h2 class="mt-12 text-2xl sm:text-3xl">Layanan</h2>
                <ul class="mt-5 grid gap-3 sm:grid-cols-2">
                    @foreach ($practiceArea->services as $service)
                        <li class="card flex items-start gap-3 p-4 text-[0.9375rem]">
                            <x-ikon name="check" class="mt-0.5 size-5 flex-none text-pine-600" />
                            <span>{{ $service }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <aside class="space-y-6">
            @if ($practiceArea->legal_basis)
                <div class="card p-6">
                    <h2 class="flex items-center gap-2 text-xl"><x-ikon name="buku" class="size-5 text-brass-ink" /> Dasar hukum utama</h2>
                    <ul class="mt-4 space-y-3 text-[0.9375rem] text-ink-2">
                        @foreach ($practiceArea->legal_basis as $basis)
                            <li class="border-l-2 border-brass pl-3">{{ $basis }}</li>
                        @endforeach
                    </ul>
                    <p class="mt-4 text-xs text-muted">Daftar ini tidak lengkap dan bukan nasihat hukum. Penerapannya bergantung pada fakta tiap perkara.</p>
                </div>
            @endif
            <div class="card p-6">
                <h2 class="text-xl">Punya persoalan di bidang ini?</h2>
                <p class="mt-2 text-[0.9375rem] text-ink-2">Ceritakan secara singkat lewat form konsultasi.</p>
                <a href="{{ route('contact', ['bidang' => $practiceArea->slug]) }}#form-konsultasi" class="btn btn-primary mt-5 w-full">Minta konsultasi</a>
            </div>
            @if ($others->isNotEmpty())
                <nav class="card p-6" aria-labelledby="ns-bidang-lain">
                    <h2 id="ns-bidang-lain" class="text-xl">Bidang lain</h2>
                    <ul class="mt-3 divide-y divide-line text-[0.9375rem]">
                        @foreach ($others as $other)
                            <li><a href="{{ route('practice-areas.show', $other) }}" class="flex items-center justify-between gap-2 py-2.5 no-underline hover:underline">{{ $other->name }} <x-ikon name="chevron-right" class="size-4 text-muted" /></a></li>
                        @endforeach
                    </ul>
                </nav>
            @endif
        </aside>
    </section>
</x-layouts.app>
