<x-layouts.app
    title="Pertanyaan Umum (FAQ)"
    description="Jawaban atas pertanyaan umum seputar konsultasi di Kantor Hukum Nalar Saksama (firma fiktif): alur, biaya, kerahasiaan, dan penyimpanan data."
    :breadcrumbs="[['label' => 'FAQ', 'url' => route('faq')]]"
    :schema="[\App\Support\StructuredData::faqPage($faqs)]"
>
    <x-page-header
        eyebrow="Pertanyaan umum"
        title="Pertanyaan yang sering diajukan"
        lead="Belum menemukan jawabannya? Kirim pertanyaan Anda lewat form konsultasi."
        :breadcrumbs="[['label' => 'FAQ', 'url' => route('faq')]]"
    />

    <section class="container-page py-14 sm:py-16">
        <div class="mx-auto max-w-3xl divide-y divide-line border-y border-line">
            @foreach ($faqs as $faq)
                <details class="faq-item" @if ($loop->first) open @endif>
                    <summary>
                        <h2 class="font-sans text-[1.0625rem] font-semibold leading-snug tracking-normal">{{ $faq->question }}</h2>
                        <span class="faq-sign"><x-ikon name="plus" class="size-4" /></span>
                    </summary>
                    <div class="prose-legal pb-6 text-base">{!! \App\Support\Markdown::render($faq->answer)['html'] !!}</div>
                </details>
            @endforeach
        </div>
    </section>

    <x-cta-band />
</x-layouts.app>
