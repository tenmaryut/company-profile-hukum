@props(['size' => 'size-10', 'tone' => 'dark'])
{{-- Logo firma fiktif: timbangan di dalam segel. --}}
<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-3']) }}>
    <svg class="{{ $size }} flex-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" aria-hidden="true" focusable="false">
        <circle cx="24" cy="24" r="23" fill="#1d4d45"/>
        <circle cx="24" cy="24" r="19.5" fill="none" stroke="#b8862f" stroke-width="1"/>
        <g fill="none" stroke="#f7f3ea" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M24 14v19M18.5 33.5h11M13.5 17.5h21M13.5 17.5 10 26M13.5 17.5 17 26M34.5 17.5 31 26M34.5 17.5 38 26"/>
            <path d="M9 26h9a4.5 4.5 0 0 1-9 0zM30 26h9a4.5 4.5 0 0 1-9 0z"/>
        </g>
        <circle cx="24" cy="13.5" r="1.7" fill="#b8862f"/>
    </svg>
    <span class="leading-none">
        <span @class(['block text-[0.625rem] font-semibold uppercase tracking-[0.2em]', 'text-brass-ink' => $tone === 'dark', 'text-brass-soft' => $tone === 'light'])>Kantor Hukum</span>
        <span @class(['font-display block text-xl', 'text-ink' => $tone === 'dark', 'text-paper' => $tone === 'light'])>Nalar Saksama</span>
    </span>
</span>
