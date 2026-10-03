<section class="container-page pt-4" aria-labelledby="ns-cta-konsultasi">
    <div class="grid gap-8 rounded-[1.25rem] border border-line bg-card p-8 sm:p-12 lg:grid-cols-[1.3fr_1fr] lg:items-center">
        <div>
            <h2 id="ns-cta-konsultasi" class="text-3xl sm:text-4xl">Ceritakan duduk perkaranya</h2>
            <p class="mt-3 max-w-xl text-ink-2">Kirim uraian singkat lewat form, atau hubungi kami lewat WhatsApp. Ini situs demo: jangan mengirim data pribadi asli.</p>
        </div>
        <div class="flex flex-wrap gap-3 lg:justify-end">
            <a href="{{ route('contact') }}#form-konsultasi" class="btn btn-primary">Isi form konsultasi</a>
            <x-whatsapp-button />
        </div>
    </div>
</section>
