<x-layouts.app
    title="Bidang Praktik"
    description="Bidang praktik Kantor Hukum Nalar Saksama (firma fiktif): hukum perdata, pidana, ketenagakerjaan, pelindungan data pribadi, dan lainnya."
    :breadcrumbs="[['label' => 'Bidang Praktik', 'url' => route('practice-areas.index')]]"
>
    <x-page-header
        eyebrow="Bidang praktik"
        title="Persoalan hukum yang kami dampingi"
        lead="Setiap bidang ditangani advokat yang menekuninya. Pilih bidang untuk melihat layanan dan dasar hukum utamanya."
        :breadcrumbs="[['label' => 'Bidang Praktik', 'url' => route('practice-areas.index')]]"
    />

    <section class="container-page py-14 sm:py-16">
        <ul class="grid gap-5 md:grid-cols-2">
            @foreach ($practiceAreas as $area)
                <li class="card reveal lift flex flex-col gap-5 p-6 sm:flex-row sm:p-8">
                    <span class="grid size-14 flex-none place-items-center rounded-full bg-pine-50 text-pine-700">
                        <x-ikon :name="$area->icon" class="size-7" />
                    </span>
                    <div class="flex flex-1 flex-col">
                        <h2 class="text-2xl">{{ $area->name }}</h2>
                        <p class="mt-2 flex-1 text-ink-2">{{ $area->summary }}</p>
                        @if ($area->services)
                            <ul class="mt-4 space-y-1.5 text-[0.9375rem] text-ink-2">
                                @foreach (array_slice($area->services, 0, 3) as $service)
                                    <li class="flex items-start gap-2"><x-ikon name="check" class="mt-1 size-4 flex-none text-pine-600" /> {{ $service }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <a href="{{ route('practice-areas.show', $area) }}" class="link-arrow mt-5 text-sm">
                            Detail {{ Str::lower($area->name) }}
                            <x-ikon name="arrow-right" class="size-4" />
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    </section>

    <x-cta-band />
</x-layouts.app>
