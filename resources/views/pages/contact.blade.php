@php
    $requestedArea = filled(request('bidang')) ? $practiceAreas->firstWhere('slug', (string) request('bidang'))?->id : null;
    $selectedArea = old('practice_area_id', $requestedArea);
    $field = fn (string $name) => $errors->has($name) ? ['aria-invalid' => 'true', 'aria-describedby' => $name.'-error'] : [];
@endphp
<x-layouts.app
    title="Kontak dan Permintaan Konsultasi"
    description="Kirim permintaan konsultasi ke Kantor Hukum Nalar Saksama (firma fiktif, situs demo). Data form dihapus otomatis setelah 7 hari."
    :breadcrumbs="[['label' => 'Kontak', 'url' => route('contact')]]"
>
    <x-page-header
        eyebrow="Kontak"
        title="Minta konsultasi"
        lead="Ceritakan persoalan Anda secara singkat. Kami membalas pada jam kerja. Semua kontak di halaman ini adalah placeholder karena firmanya fiktif."
        :breadcrumbs="[['label' => 'Kontak', 'url' => route('contact')]]"
    />

    <section class="container-page grid gap-12 py-14 sm:py-16 lg:grid-cols-[1.15fr_0.85fr]">
        <div id="form-konsultasi" class="scroll-mt-6">
            <h2 class="text-3xl">Form permintaan konsultasi</h2>

            <div class="mt-5 flex items-start gap-3 rounded-xl border border-brass bg-notice/40 p-4 text-[0.9375rem]">
                <x-ikon name="info" class="mt-0.5 size-5 flex-none" />
                <p><strong>Situs demo, jangan kirim data pribadi asli.</strong> Gunakan nama dan email contoh. Kiriman bisa dilihat di panel admin demo dan dihapus otomatis {{ \App\Models\ConsultationRequest::RETENTION_DAYS }} hari setelah dikirim.</p>
            </div>

            @if (session('consultation_sent'))
                <div class="mt-6 rounded-xl border border-pine-200 bg-pine-50 p-5" role="status">
                    <p class="flex items-center gap-2 font-semibold text-pine-800"><x-ikon name="check" class="size-5" /> Permintaan konsultasi terkirim.</p>
                    <p class="mt-2 text-[0.9375rem] text-ink-2">
                        Terima kasih. Data Anda tersimpan dan akan dihapus otomatis pada {{ \Illuminate\Support\Carbon::parse(session('consultation_sent'))->translatedFormat('j F Y, H.i') }} WIB.
                        Untuk melihatnya, masuk ke <a href="{{ url('/admin') }}" class="font-semibold text-pine-700 underline">panel admin demo</a> dari browser ini (akun demo tercantum di halaman login).
                    </p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-6 rounded-xl border border-[#a3291f]/40 bg-[#fbeeec] p-5" role="alert" aria-labelledby="ns-ringkasan-error">
                    <p id="ns-ringkasan-error" class="font-semibold text-[#7d1f17]">Periksa kembali isian berikut:</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5 text-[0.9375rem] text-[#7d1f17]">
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('consultation.store') }}" class="mt-8 grid gap-6" novalidate>
                @csrf
                <input type="hidden" name="form_started_at" value="{{ $formStartedAt }}">
                <div class="absolute -left-[9999px] h-px w-px overflow-hidden" aria-hidden="true">
                    <label for="website">Situs web (biarkan kosong)</label>
                    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="name" class="field-label">Nama <span class="text-muted">(wajib)</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="field-input" required maxlength="100" autocomplete="name" {{ new \Illuminate\View\ComponentAttributeBag($field('name')) }}>
                        @error('name') <p id="name-error" class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="field-label">Email <span class="text-muted">(wajib)</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="field-input" required maxlength="150" autocomplete="email" {{ new \Illuminate\View\ComponentAttributeBag($field('email')) }}>
                        @error('email') <p id="email-error" class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="phone" class="field-label">Nomor telepon <span class="text-muted">(opsional)</span></label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="field-input" maxlength="30" autocomplete="tel" {{ new \Illuminate\View\ComponentAttributeBag($field('phone')) }}>
                        @error('phone') <p id="phone-error" class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="practice_area_id" class="field-label">Bidang hukum <span class="text-muted">(opsional)</span></label>
                        <select id="practice_area_id" name="practice_area_id" class="field-input" {{ new \Illuminate\View\ComponentAttributeBag($field('practice_area_id')) }}>
                            <option value="">Belum tahu / lainnya</option>
                            @foreach ($practiceAreas as $area)
                                <option value="{{ $area->id }}" @selected((string) $selectedArea === (string) $area->id)>{{ $area->name }}</option>
                            @endforeach
                        </select>
                        @error('practice_area_id') <p id="practice_area_id-error" class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="message" class="field-label">Uraian singkat <span class="text-muted">(wajib, 20–2.000 karakter)</span></label>
                    <textarea id="message" name="message" rows="6" class="field-input" required minlength="20" maxlength="2000" aria-describedby="message-hint{{ $errors->has('message') ? ' message-error' : '' }}" @error('message') aria-invalid="true" @enderror>{{ old('message') }}</textarea>
                    <p id="message-hint" class="field-hint">Ceritakan kronologi singkat dan apa yang ingin Anda ketahui. Tidak perlu menyertakan nomor identitas atau data sensitif.</p>
                    @error('message') <p id="message-error" class="field-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <div class="flex items-start gap-3">
                        <input type="checkbox" id="consent" name="consent" value="1" class="mt-1 size-5 flex-none accent-pine-700" @checked(old('consent')) required {{ new \Illuminate\View\ComponentAttributeBag($field('consent')) }}>
                        <label for="consent" class="text-[0.9375rem] text-ink-2">
                            Saya telah membaca <a href="{{ route('privacy') }}" class="font-semibold text-pine-700 underline">pemberitahuan privasi</a> dan setuju data di form ini diproses untuk menanggapi permintaan konsultasi, lalu dihapus otomatis setelah {{ \App\Models\ConsultationRequest::RETENTION_DAYS }} hari.
                        </label>
                    </div>
                    @error('consent') <p id="consent-error" class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <button type="submit" class="btn btn-primary">
                        Kirim permintaan
                        <x-ikon name="arrow-right" class="size-4" />
                    </button>
                    <span class="text-sm text-muted">atau</span>
                    <x-whatsapp-button label="Hubungi lewat WhatsApp" />
                </div>
                <p class="text-sm text-muted">Nomor WhatsApp {{ config('firm.whatsapp_display') }} adalah placeholder dan tidak aktif.</p>
            </form>
        </div>

        <aside class="space-y-6" aria-labelledby="ns-info-kontak">
            <div class="card p-6 sm:p-8">
                <h2 id="ns-info-kontak" class="text-2xl">Informasi kontak</h2>
                <ul class="mt-5 space-y-4 text-[0.9375rem]">
                    <li class="flex items-start gap-3"><x-ikon name="map-pin" class="mt-0.5 size-5 flex-none text-pine-700" /><span>{{ config('firm.address.street') }}, {{ config('firm.address.locality') }}, {{ config('firm.address.region') }} {{ config('firm.address.postal_code') }} <span class="text-muted">(fiktif)</span></span></li>
                    <li class="flex items-start gap-3"><x-ikon name="mail" class="mt-0.5 size-5 flex-none text-pine-700" /><span>{{ config('firm.email') }} <span class="text-muted">(placeholder)</span></span></li>
                    <li class="flex items-start gap-3"><x-ikon name="phone" class="mt-0.5 size-5 flex-none text-pine-700" /><span>{{ config('firm.phone') }} <span class="text-muted">(placeholder)</span></span></li>
                    <li class="flex items-start gap-3"><x-ikon name="clock" class="mt-0.5 size-5 flex-none text-pine-700" /><span>{{ config('firm.hours') }}</span></li>
                </ul>
            </div>
            <x-map-illustration />
        </aside>
    </section>
</x-layouts.app>
