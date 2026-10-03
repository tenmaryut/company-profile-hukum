<x-layouts.app
    :description="config('firm.description')"
    :schema="[\App\Support\StructuredData::legalService($practiceAreas->pluck('name')->all())]"
>
    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="container-page grid items-center gap-10 py-12 sm:py-16 lg:grid-cols-[1.12fr_0.88fr] lg:gap-14 lg:py-20">
            <div class="hero-reveal">
                <p class="eyebrow">Kantor hukum fiktif · Jakarta</p>
                <h1 class="mt-4 text-[2.375rem] leading-[1.08] sm:text-6xl">
                    Penjelasan hukum yang runtut,
                    <span class="font-display italic font-medium text-pine-700">langkah yang terukur.</span>
                </h1>
                <span class="ink-line mt-6" aria-hidden="true"></span>
                <p class="mt-6 max-w-xl text-lg text-ink-2">
                    Kami membantu perorangan dan usaha kecil-menengah memahami posisi hukumnya: hak dan kewajiban, pilihan yang tersedia, serta risiko dan biayanya, sebelum memutuskan langkah.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('contact') }}#form-konsultasi" class="btn btn-primary">
                        Minta konsultasi
                        <x-ikon name="arrow-right" class="size-4" />
                    </a>
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">Baca artikel hukum</a>
                </div>
                <p class="mt-8 flex max-w-xl items-start gap-2.5 text-sm text-muted">
                    <x-ikon name="perisai" class="mt-0.5 size-5 flex-none text-pine-700" />
                    <span>Kami tidak menjanjikan hasil perkara. Peluang, risiko, dan perkiraan biaya kami jelaskan secara tertulis sejak awal.</span>
                </p>
            </div>
            <div class="mx-auto w-full max-w-md lg:max-w-none">
                <x-hero-illustration />
            </div>
        </div>
    </section>

    {{-- Cara kerja --}}
    <section class="border-y border-line bg-card" aria-labelledby="ns-cara-kerja">
        <div class="container-page grid gap-10 py-14 sm:py-16 lg:grid-cols-[0.8fr_1.2fr]">
            <div>
                <p class="eyebrow">Cara kerja</p>
                <h2 id="ns-cara-kerja" class="mt-3 text-3xl sm:text-4xl">Tiga langkah sebelum Anda memutuskan</h2>
                <p class="mt-4 text-ink-2">Konsultasi awal bertujuan memetakan masalah, bukan langsung menempuh jalur sengketa. Banyak persoalan bisa selesai lewat surat, negosiasi, atau mediasi.</p>
            </div>
            <ol class="grid gap-6 sm:grid-cols-3 lg:gap-8">
                @foreach ([
                    ['Ceritakan duduk perkaranya', 'Isi form atau hubungi kami. Cukup uraian singkat dan dokumen yang Anda miliki.'],
                    ['Kami telaah fakta dan aturannya', 'Advokat memeriksa dokumen, peraturan yang berlaku, dan putusan yang relevan.'],
                    ['Rencana langkah tertulis', 'Anda menerima pilihan langkah, risikonya, dan perkiraan biaya sebelum memutuskan.'],
                ] as $i => [$heading, $text])
                    <li class="reveal border-t-2 border-ink pt-4">
                        <span class="font-display text-3xl text-brass-ink">0{{ $i + 1 }}</span>
                        <h3 class="mt-2 text-xl">{{ $heading }}</h3>
                        <p class="mt-2 text-[0.9375rem] text-ink-2">{{ $text }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- Bidang praktik --}}
    <section class="container-page py-16 sm:py-20" aria-labelledby="ns-bidang-praktik">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="eyebrow">Bidang praktik</p>
                <h2 id="ns-bidang-praktik" class="mt-3 text-3xl sm:text-4xl">Persoalan yang kami dampingi</h2>
            </div>
            <a href="{{ route('practice-areas.index') }}" class="link-arrow">Semua bidang praktik <x-ikon name="arrow-right" class="size-4" /></a>
        </div>
        <ul class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($practiceAreas as $area)
                <li class="card reveal lift flex flex-col p-6">
                    <span class="grid size-12 place-items-center rounded-full bg-pine-50 text-pine-700">
                        <x-ikon :name="$area->icon" class="size-6" />
                    </span>
                    <h3 class="mt-5 text-[1.375rem]">{{ $area->name }}</h3>
                    <p class="mt-2 flex-1 text-[0.9375rem] text-ink-2">{{ $area->summary }}</p>
                    <a href="{{ route('practice-areas.show', $area) }}" class="link-arrow mt-5 text-sm">
                        Pelajari {{ Str::lower($area->name) }}
                        <x-ikon name="arrow-right" class="size-4" />
                    </a>
                </li>
            @endforeach
        </ul>
    </section>

    {{-- Etika --}}
    <section class="container-page" aria-labelledby="ns-komitmen">
        <div class="grid gap-8 rounded-[1.25rem] bg-pine-800 p-8 text-paper sm:p-12 lg:grid-cols-[1fr_1.2fr] lg:items-center">
            <div>
                <p class="eyebrow text-brass-soft">Komitmen</p>
                <h2 id="ns-komitmen" class="mt-3 text-3xl text-paper sm:text-4xl">Jujur soal peluang, terbuka soal biaya</h2>
            </div>
            <ul class="grid gap-5 text-paper/90 sm:grid-cols-2">
                @foreach ([
                    ['Tanpa janji menang', 'Hasil perkara bergantung pada fakta, bukti, dan pertimbangan hakim. Kami menjelaskan peluang apa adanya.'],
                    ['Biaya tertulis di awal', 'Lingkup kerja dan perkiraan biaya disepakati tertulis sebelum pekerjaan dimulai.'],
                    ['Kerahasiaan klien', 'Informasi yang Anda sampaikan dijaga kerahasiaannya sesuai kewajiban advokat.'],
                    ['Bahasa yang mudah dipahami', 'Istilah hukum kami terjemahkan menjadi pilihan langkah yang jelas.'],
                ] as [$heading, $text])
                    <li>
                        <h3 class="flex items-center gap-2 font-sans text-base font-semibold text-paper">
                            <x-ikon name="check" class="size-4 text-brass-soft" /> {{ $heading }}
                        </h3>
                        <p class="mt-1.5 text-sm text-paper/80">{{ $text }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- Artikel terbaru --}}
    @if ($articles->isNotEmpty())
        <section class="container-page py-16 sm:py-20" aria-labelledby="ns-artikel-terbaru">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="eyebrow">Artikel hukum</p>
                    <h2 id="ns-artikel-terbaru" class="mt-3 text-3xl sm:text-4xl">Tulisan terbaru</h2>
                </div>
                <a href="{{ route('articles.index') }}" class="link-arrow">Semua artikel <x-ikon name="arrow-right" class="size-4" /></a>
            </div>
            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($articles as $article)
                    <x-article-card :article="$article" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- Tim --}}
    @if ($team->isNotEmpty())
        <section class="border-y border-line bg-paper-2/60" aria-labelledby="ns-tim">
            <div class="container-page grid gap-10 py-16 sm:py-20 lg:grid-cols-[0.8fr_1.2fr] lg:items-center">
                <div>
                    <p class="eyebrow">Tim</p>
                    <h2 id="ns-tim" class="mt-3 text-3xl sm:text-4xl">Advokat dan staf kami</h2>
                    <p class="mt-4 text-ink-2">Setiap perkara ditangani advokat yang bidangnya sesuai, didampingi staf yang menyiapkan dokumen. Semua nama dan profil di situs ini fiktif.</p>
                    <a href="{{ route('team') }}" class="link-arrow mt-6">Kenali tim <x-ikon name="arrow-right" class="size-4" /></a>
                </div>
                <ul class="grid grid-cols-2 gap-5 sm:grid-cols-3">
                    @foreach ($team as $member)
                        <li class="reveal text-center">
                            <x-avatar :variant="$member->avatar_variant" class="mx-auto size-24 rounded-full sm:size-28" />
                            <p class="mt-3 font-semibold leading-snug">{{ $member->name }}</p>
                            <p class="text-sm text-muted">{{ $member->position }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    {{-- FAQ singkat --}}
    @if ($faqs->isNotEmpty())
        <section class="container-page grid gap-10 py-16 sm:py-20 lg:grid-cols-[0.8fr_1.2fr]" aria-labelledby="ns-faq-ringkas">
            <div>
                <p class="eyebrow">Pertanyaan umum</p>
                <h2 id="ns-faq-ringkas" class="mt-3 text-3xl sm:text-4xl">Sebelum Anda menghubungi kami</h2>
                <a href="{{ route('faq') }}" class="link-arrow mt-6">Semua pertanyaan <x-ikon name="arrow-right" class="size-4" /></a>
            </div>
            <div class="divide-y divide-line border-y border-line">
                @foreach ($faqs as $faq)
                    <details class="faq-item">
                        <summary>
                            <span>{{ $faq->question }}</span>
                            <span class="faq-sign"><x-ikon name="plus" class="size-4" /></span>
                        </summary>
                        <div class="prose-legal pb-5 text-base">{!! \App\Support\Markdown::render($faq->answer)['html'] !!}</div>
                    </details>
                @endforeach
            </div>
        </section>
    @endif

    <x-cta-band />
</x-layouts.app>
