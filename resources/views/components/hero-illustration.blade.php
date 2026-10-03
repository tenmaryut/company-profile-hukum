{{-- Ilustrasi beranda buatan sendiri: memorandum hukum dengan segel firma. Dekoratif.
     Animasi (lihat app.css): lembar masuk, baris "ditulis" tinta, centang muncul, segel distempel. --}}
<svg {{ $attributes->merge(['class' => 'block h-auto w-full']) }} viewBox="0 0 480 500" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
    <defs>
        <path id="segel-lingkar" d="M0 0m-32 0a32 32 0 1 1 64 0a32 32 0 1 1-64 0"/>
    </defs>
    <circle cx="390" cy="96" r="78" fill="#ecd9ae" opacity=".55"/>
    <circle cx="70" cy="420" r="54" fill="#d9e9e3"/>
    <g class="memo-sheet">
        <g transform="rotate(-4 240 260)">
            <rect x="78" y="58" width="320" height="410" rx="16" fill="#efe8d8" stroke="#dacfba"/>
        </g>
        <rect x="62" y="42" width="330" height="420" rx="16" fill="#fffdf8" stroke="#dacfba"/>
        <text x="92" y="86" fill="#7a5518" font-family="ui-sans-serif, system-ui, sans-serif" font-size="11" font-weight="700" letter-spacing="2.4">MEMORANDUM HUKUM</text>
        <rect class="memo-line d1" x="92" y="104" width="210" height="14" rx="4" fill="#17202b"/>
        <rect class="memo-line d2" x="92" y="126" width="150" height="14" rx="4" fill="#17202b"/>
        <rect class="memo-line d3" x="92" y="164" width="268" height="7" rx="3.5" fill="#dacfba"/>
        <rect class="memo-line d4" x="92" y="180" width="250" height="7" rx="3.5" fill="#dacfba"/>
        <rect class="memo-line d5" x="92" y="196" width="262" height="7" rx="3.5" fill="#dacfba"/>
        <rect class="memo-line d6" x="92" y="212" width="180" height="7" rx="3.5" fill="#dacfba"/>
        <rect class="memo-line d7" x="88" y="232" width="232" height="34" rx="6" fill="#f1d687" opacity=".55"/>
        <rect class="memo-line d8" x="96" y="240" width="208" height="7" rx="3.5" fill="#c6b89c"/>
        <rect class="memo-line d8" x="96" y="253" width="150" height="7" rx="3.5" fill="#c6b89c"/>
        <g font-family="ui-sans-serif, system-ui, sans-serif" font-size="13" fill="#344050" font-weight="600">
            <g transform="translate(92 290)">
                <g class="memo-check c1">
                    <circle cx="9" cy="9" r="9" fill="#1d4d45"/>
                    <path d="M5 9.5l2.6 2.6L13 6.8" fill="none" stroke="#fffdf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </g>
                <text x="28" y="13.5">Fakta dan dokumen</text>
            </g>
            <g transform="translate(92 322)">
                <g class="memo-check c2">
                    <circle cx="9" cy="9" r="9" fill="#1d4d45"/>
                    <path d="M5 9.5l2.6 2.6L13 6.8" fill="none" stroke="#fffdf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </g>
                <text x="28" y="13.5">Dasar hukum yang berlaku</text>
            </g>
            <g transform="translate(92 354)">
                <g class="memo-check c3">
                    <circle cx="9" cy="9" r="9" fill="none" stroke="#1d4d45" stroke-width="2"/>
                </g>
                <text x="28" y="13.5">Pilihan langkah dan risikonya</text>
            </g>
        </g>
        <rect class="memo-line d9" x="92" y="400" width="120" height="7" rx="3.5" fill="#dacfba"/>
        <rect class="memo-line d9" x="92" y="416" width="86" height="7" rx="3.5" fill="#dacfba"/>
    </g>
    <g class="memo-seal">
        <g transform="translate(342 420) rotate(-12)">
            <circle r="44" fill="#fffdf8" stroke="#b8862f" stroke-width="2"/>
            <circle r="38" fill="none" stroke="#b8862f" stroke-width="1" stroke-dasharray="2 3"/>
            <text font-family="ui-sans-serif, system-ui, sans-serif" font-size="7.6" font-weight="700" letter-spacing="1.4" fill="#7a5518">
                <textPath href="#segel-lingkar">NALAR SAKSAMA · KANTOR HUKUM ·</textPath>
            </text>
            <g fill="none" stroke="#1d4d45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" transform="translate(-20.4 -20.4) scale(.85)">
                <path d="M24 13v19M18.5 32.5h11M13.5 16.5h21M13.5 16.5 10 25M13.5 16.5 17 25M34.5 16.5 31 25M34.5 16.5 38 25"/>
                <path d="M9 25h9a4.5 4.5 0 0 1-9 0zM30 25h9a4.5 4.5 0 0 1-9 0z"/>
            </g>
        </g>
    </g>
</svg>
