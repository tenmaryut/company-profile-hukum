<x-layouts.app
    title="Profil Firma"
    description="Profil Kantor Hukum Nalar Saksama (firma fiktif untuk situs demo): cara kerja, nilai, dan komitmen etika advokat dalam mendampingi klien."
    :breadcrumbs="[['label' => 'Profil', 'url' => route('profile')]]"
>
    <x-page-header
        eyebrow="Profil firma"
        title="Kantor hukum yang mengutamakan penjelasan"
        lead="Nalar Saksama adalah firma fiktif untuk situs demo portofolio. Profil di bawah ini menggambarkan cara kerja kantor hukum yang informatif dan beretika."
        :breadcrumbs="[['label' => 'Profil', 'url' => route('profile')]]"
    />

    <section class="container-page grid gap-12 py-14 sm:py-16 lg:grid-cols-[1.2fr_0.8fr]">
        <div class="prose-legal">
            {!! \App\Support\Markdown::render($about)['html'] !!}
        </div>
        <aside class="card h-fit p-6 sm:p-8" aria-labelledby="ns-sekilas">
            <h2 id="ns-sekilas" class="text-2xl">Sekilas</h2>
            <dl class="mt-5 space-y-4 text-[0.9375rem]">
                <div>
                    <dt class="font-semibold">Bentuk</dt>
                    <dd class="text-ink-2">Kantor advokat (fiktif)</dd>
                </div>
                <div>
                    <dt class="font-semibold">Bidang praktik</dt>
                    <dd class="text-ink-2">{{ $practiceAreas->pluck('name')->join(', ', ', dan ') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold">Jam layanan</dt>
                    <dd class="text-ink-2">{{ config('firm.hours') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold">Alamat</dt>
                    <dd class="text-ink-2">{{ config('firm.address.street') }}, {{ config('firm.address.locality') }} (fiktif)</dd>
                </div>
            </dl>
            <a href="{{ route('contact') }}" class="btn btn-primary mt-6 w-full">Hubungi kami</a>
        </aside>
    </section>

    <section class="border-y border-line bg-card" aria-labelledby="ns-nilai">
        <div class="container-page py-14 sm:py-16">
            <p class="eyebrow">Nilai kerja</p>
            <h2 id="ns-nilai" class="mt-3 text-3xl sm:text-4xl">Yang kami pegang dalam setiap perkara</h2>
            <ul class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($values as $value)
                    <li class="reveal border-t-2 border-ink pt-4">
                        <h3 class="text-xl">{{ $value['title'] }}</h3>
                        <p class="mt-2 text-[0.9375rem] text-ink-2">{{ $value['text'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <section class="container-page py-14 sm:py-16" aria-labelledby="ns-etika">
        <div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr]">
            <div>
                <p class="eyebrow">Etika profesi</p>
                <h2 id="ns-etika" class="mt-3 text-3xl sm:text-4xl">Mengapa kami tidak menjanjikan hasil</h2>
            </div>
            <div class="prose-legal">
                {!! \App\Support\Markdown::render($ethics)['html'] !!}
            </div>
        </div>
    </section>

    <x-cta-band />
</x-layouts.app>
