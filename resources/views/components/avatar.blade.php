@props(['variant' => 1, 'label' => null])
{{-- Avatar ilustrasi buatan sendiri (bukan foto orang nyata). 8 varian, lihat TeamMember::AVATAR_VARIANTS. --}}
@php
    $skin = ['#f1c9a5', '#e0ac83', '#c68a5e', '#a86f4c', '#8d5a3b'];
    $v = [
        1 => ['bg' => '#e7dcc4', 'skin' => $skin[1], 'hair' => 'side', 'hairColor' => '#2a1e17', 'outfit' => '#1f2e45', 'glasses' => true],
        2 => ['bg' => '#d9e9e3', 'skin' => $skin[0], 'hair' => 'hijab', 'hairColor' => '#8c5a4a', 'outfit' => '#1d4d45', 'glasses' => false],
        3 => ['bg' => '#eadbc8', 'skin' => $skin[2], 'hair' => 'long', 'hairColor' => '#1e1611', 'outfit' => '#6b4a2e', 'glasses' => false],
        4 => ['bg' => '#dde3ee', 'skin' => $skin[3], 'hair' => 'curly', 'hairColor' => '#1a1410', 'outfit' => '#4a5260', 'glasses' => false],
        5 => ['bg' => '#ede0d0', 'skin' => $skin[1], 'hair' => 'hijab', 'hairColor' => '#3d4a63', 'outfit' => '#5a616d', 'glasses' => true],
        6 => ['bg' => '#e7dcc4', 'skin' => $skin[4], 'hair' => 'buzz', 'hairColor' => '#15100c', 'outfit' => '#545b66', 'glasses' => false],
        7 => ['bg' => '#d9e9e3', 'skin' => $skin[0], 'hair' => 'bun', 'hairColor' => '#2a1e17', 'outfit' => '#2e4a7a', 'glasses' => false],
        8 => ['bg' => '#dde3ee', 'skin' => $skin[2], 'hair' => 'side', 'hairColor' => '#b9b4ac', 'outfit' => '#4a3424', 'glasses' => true],
    ][(int) $variant] ?? null;
    $v ??= ['bg' => '#e7dcc4', 'skin' => $skin[1], 'hair' => 'side', 'hairColor' => '#2a1e17', 'outfit' => '#1f2e45', 'glasses' => false];
    $hijab = $v['hair'] === 'hijab';
@endphp
<svg {{ $attributes->merge(['class' => 'block']) }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120"
    @if ($label) role="img" aria-label="{{ $label }}" @else aria-hidden="true" focusable="false" @endif>
    <rect width="120" height="120" fill="{{ $v['bg'] }}"/>
    @if ($v['hair'] === 'long')
        <path d="M37 54c-2-21 9-30 23-30s25 9 23 30l2 28c-6 5-13 4-16-1V52H50v29c-3 5-10 6-16 1z" fill="{{ $v['hairColor'] }}"/>
    @endif
    @if ($v['hair'] === 'bun')
        <circle cx="60" cy="22" r="9" fill="{{ $v['hairColor'] }}"/>
    @endif
    {{-- badan dan pakaian --}}
    <path d="M16 120c0-27 19-40 44-40s44 13 44 40z" fill="{{ $v['outfit'] }}"/>
    @if ($hijab)
        <path d="M30 120c2-24 14-37 30-37s28 13 30 37z" fill="{{ $v['hairColor'] }}" opacity=".92"/>
    @else
        <path d="M48 81l12 22 12-22z" fill="#f4efe6"/>
        <path d="M47 81l9 31-12-17zM73 81l-9 31 12-17z" fill="#000" opacity=".22"/>
        <rect x="52" y="64" width="16" height="20" rx="7" fill="{{ $v['skin'] }}"/>
        <rect x="52" y="64" width="16" height="9" rx="4" fill="#000" opacity=".08"/>
    @endif
    @if ($hijab)
        <path d="M35 58c0-21 11-33 25-33s25 12 25 33v14c0 14-11 22-25 22S35 86 35 72z" fill="{{ $v['hairColor'] }}"/>
        <ellipse cx="60" cy="55" rx="16" ry="19" fill="{{ $v['skin'] }}"/>
        <path d="M44 47c3-9 9-13 16-13s13 4 16 13c-5-4-10-6-16-6s-11 2-16 6z" fill="#000" opacity=".12"/>
    @else
        <ellipse cx="41.5" cy="55" rx="3.5" ry="5" fill="{{ $v['skin'] }}"/>
        <ellipse cx="78.5" cy="55" rx="3.5" ry="5" fill="{{ $v['skin'] }}"/>
        <ellipse cx="60" cy="52" rx="19" ry="22" fill="{{ $v['skin'] }}"/>
    @endif
    {{-- rambut --}}
    @switch($v['hair'])
        @case('side')
            <path d="M41 51c-2-17 7-25 20-25 13 0 21 8 19 24-3-8-8-12-15-13-8-1-12 1-18 5-2 2-4 5-6 9z" fill="{{ $v['hairColor'] }}"/>
            @break
        @case('long')
            <path d="M41 50c-1-16 8-24 19-24s20 8 19 24c-5-7-11-11-19-11s-14 4-19 11z" fill="{{ $v['hairColor'] }}"/>
            @break
        @case('curly')
            <g fill="{{ $v['hairColor'] }}">
                <circle cx="46" cy="37" r="7"/><circle cx="55" cy="31" r="7.5"/><circle cx="65" cy="31" r="7.5"/><circle cx="74" cy="37" r="7"/><circle cx="42" cy="46" r="5.5"/><circle cx="78" cy="46" r="5.5"/>
            </g>
            @break
        @case('buzz')
            <path d="M42 46c0-13 8-19 18-19s18 6 18 19c-4-5-10-8-18-8s-14 3-18 8z" fill="{{ $v['hairColor'] }}"/>
            @break
        @case('bun')
            <path d="M41 50c-1-15 8-23 19-23s20 8 19 23c-4-7-10-11-19-11s-15 4-19 11z" fill="{{ $v['hairColor'] }}"/>
            @break
    @endswitch
    {{-- wajah --}}
    <g fill="#1b1410">
        <ellipse cx="52.5" cy="55" rx="2" ry="2.4"/>
        <ellipse cx="67.5" cy="55" rx="2" ry="2.4"/>
    </g>
    <path d="M54 65c3.5 3 8.5 3 12 0" fill="none" stroke="#5a3424" stroke-width="2" stroke-linecap="round"/>
    @if ($v['glasses'])
        <g fill="none" stroke="#1b1410" stroke-width="1.8">
            <rect x="45" y="49.5" width="13" height="10" rx="4"/>
            <rect x="62" y="49.5" width="13" height="10" rx="4"/>
            <path d="M58 54h4"/>
        </g>
    @endif
</svg>
