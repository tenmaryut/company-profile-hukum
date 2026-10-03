{{-- Peta statis ilustratif buatan sendiri: tidak memuat iframe/peta pihak ketiga, dan bukan lokasi sebenarnya. --}}
<figure {{ $attributes->merge(['class' => 'card overflow-hidden']) }}>
    <svg viewBox="0 0 640 400" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="ns-peta-judul ns-peta-desk" class="block h-auto w-full">
        <title id="ns-peta-judul">Peta ilustrasi lokasi kantor</title>
        <desc id="ns-peta-desk">Gambar peta sederhana dengan sungai, taman, dan jalan utama. Penanda lokasi berada di Jalan Ilustrasi. Bukan lokasi sebenarnya.</desc>
        <rect width="640" height="400" fill="#efe8d8"/>
        <g fill="#e4dac4">
            <rect x="24" y="24" width="150" height="110" rx="10"/><rect x="196" y="24" width="120" height="110" rx="10"/>
            <rect x="24" y="158" width="150" height="96" rx="10"/><rect x="24" y="278" width="150" height="98" rx="10"/>
            <rect x="196" y="278" width="120" height="98" rx="10"/><rect x="452" y="24" width="164" height="78" rx="10"/>
            <rect x="452" y="126" width="164" height="108" rx="10"/><rect x="452" y="258" width="164" height="118" rx="10"/>
        </g>
        <rect x="196" y="158" width="120" height="96" rx="12" fill="#cfe1d8"/>
        <g fill="#b4d2c7"><circle cx="228" cy="190" r="10"/><circle cx="262" cy="214" r="13"/><circle cx="292" cy="184" r="9"/></g>
        <path d="M340 0c-12 70 24 120 6 200s-30 140-10 200h56c-18-60-6-120 12-200s-16-130-6-200z" fill="#bcd7dd"/>
        <g stroke="#fffdf8" stroke-linecap="round" fill="none">
            <path d="M0 146h640" stroke-width="20"/>
            <path d="M0 266h640" stroke-width="14"/>
            <path d="M185 0v400" stroke-width="14"/>
            <path d="M436 0v400" stroke-width="20"/>
        </g>
        <g stroke="#c6b89c" stroke-width="2" stroke-dasharray="10 10" fill="none"><path d="M0 146h640M436 0v400"/></g>
        <g font-family="ui-sans-serif, system-ui, sans-serif" font-size="13" fill="#555f6c" font-weight="600">
            <text x="40" y="141">JL. ILUSTRASI</text>
            <text x="448" y="200" transform="rotate(90 448 200)">JL. CONTOH RAYA</text>
            <text x="212" y="245">Taman</text>
            <text x="352" y="330" transform="rotate(-80 352 330)">Sungai</text>
        </g>
        <g transform="translate(470 112)">
            <ellipse cx="16" cy="40" rx="14" ry="4" fill="#17202b" opacity=".18"/>
            <path d="M16 0C7 0 0 7 0 16c0 12 16 24 16 24s16-12 16-24C32 7 25 0 16 0z" fill="#1d4d45"/>
            <circle cx="16" cy="15" r="6" fill="#f1d687"/>
        </g>
        <g transform="translate(486 62)">
            <rect x="-62" width="124" height="34" rx="8" fill="#17202b"/>
            <text x="0" y="22" text-anchor="middle" font-family="ui-sans-serif, system-ui, sans-serif" font-size="13" font-weight="600" fill="#f7f3ea">Nalar Saksama</text>
        </g>
    </svg>
    <figcaption class="flex items-center gap-2 border-t border-line px-4 py-3 text-sm text-muted">
        <x-ikon name="map-pin" class="size-4 flex-none" />
        Peta ilustrasi, bukan lokasi sebenarnya. Alamat firma ini fiktif.
    </figcaption>
</figure>
