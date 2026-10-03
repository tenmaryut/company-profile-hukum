<x-layouts.app
    title="Pemberitahuan Privasi"
    description="Pemberitahuan privasi form konsultasi situs demo Nalar Saksama: data yang dikumpulkan, tujuan, penghapusan otomatis setelah 7 hari, dan hak subjek data."
    :breadcrumbs="[['label' => 'Pemberitahuan Privasi', 'url' => route('privacy')]]"
>
    <x-page-header
        eyebrow="Privasi"
        title="Pemberitahuan privasi"
        lead="Berlaku untuk form permintaan konsultasi di situs demo ini."
        :breadcrumbs="[['label' => 'Pemberitahuan Privasi', 'url' => route('privacy')]]"
    />

    <section class="container-page py-14 sm:py-16">
        <div class="mx-auto max-w-3xl">
            <div class="mb-8 flex items-start gap-3 rounded-xl border border-brass bg-notice/40 p-4 text-[0.9375rem]">
                <x-ikon name="info" class="mt-0.5 size-5 flex-none" />
                <p>Ini situs demo portofolio. Jangan mengirim data pribadi asli lewat form konsultasi. Semua kiriman dihapus otomatis {{ \App\Models\ConsultationRequest::RETENTION_DAYS }} hari setelah dikirim.</p>
            </div>
            <div class="prose-legal">
                {!! \App\Support\Markdown::render($body)['html'] !!}
            </div>
            @if ($updatedAt)
                <p class="mt-10 text-sm text-muted">Terakhir diperbarui {{ \Illuminate\Support\Carbon::parse($updatedAt)->translatedFormat('j F Y') }}.</p>
            @endif
        </div>
    </section>
</x-layouts.app>
