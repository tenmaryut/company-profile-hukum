<div class="bg-notice px-4 py-1.5 text-center text-xs font-medium leading-snug text-notice-ink sm:py-2 sm:text-sm" role="note">
    {{ config('firm.demo_notice') }}
    @auth
        @if (auth()->user()->is_demo)
            <span class="sm:ms-1">Akun demo: perubahan direset tiap malam (00.00 WIB).</span>
        @endif
    @endauth
</div>
