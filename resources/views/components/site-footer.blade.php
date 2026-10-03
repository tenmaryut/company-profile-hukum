<footer class="mt-20 bg-ink text-paper/85">
    <div class="container-page grid gap-10 py-14 md:grid-cols-[1.4fr_1fr_1fr] lg:grid-cols-[1.6fr_1fr_1fr_1fr]">
        <div class="max-w-sm">
            <x-logo tone="light" />
            <p class="mt-5 text-sm leading-relaxed text-paper/75">
                {{ config('firm.name') }} adalah firma fiktif yang dibuat untuk situs demo portofolio. Nama, tim, alamat, dan kontak di situs ini tidak nyata.
            </p>
        </div>

        <nav aria-label="Tautan footer">
            <h2 class="font-sans text-xs font-semibold uppercase tracking-[0.16em] text-brass-soft">Jelajahi</h2>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a href="{{ route('profile') }}" class="text-paper/85 no-underline hover:text-paper hover:underline">Profil firma</a></li>
                <li><a href="{{ route('practice-areas.index') }}" class="text-paper/85 no-underline hover:text-paper hover:underline">Bidang praktik</a></li>
                <li><a href="{{ route('team') }}" class="text-paper/85 no-underline hover:text-paper hover:underline">Tim</a></li>
                <li><a href="{{ route('articles.index') }}" class="text-paper/85 no-underline hover:text-paper hover:underline">Artikel hukum</a></li>
                <li><a href="{{ route('faq') }}" class="text-paper/85 no-underline hover:text-paper hover:underline">Pertanyaan umum</a></li>
            </ul>
        </nav>

        <div>
            <h2 class="font-sans text-xs font-semibold uppercase tracking-[0.16em] text-brass-soft">Kontak (placeholder)</h2>
            <ul class="mt-4 space-y-2.5 text-sm text-paper/85">
                <li>{{ config('firm.address.street') }}, {{ config('firm.address.locality') }}</li>
                <li>{{ config('firm.email') }}</li>
                <li>{{ config('firm.hours') }}</li>
                <li><a href="{{ route('contact') }}" class="text-paper/85 no-underline hover:text-paper hover:underline">Halaman kontak</a></li>
            </ul>
        </div>

        <div>
            <h2 class="font-sans text-xs font-semibold uppercase tracking-[0.16em] text-brass-soft">Informasi</h2>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a href="{{ route('privacy') }}" class="text-paper/85 no-underline hover:text-paper hover:underline">Pemberitahuan privasi</a></li>
                <li><a href="{{ url('/admin') }}" class="text-paper/85 no-underline hover:text-paper hover:underline" rel="nofollow">Panel admin (demo)</a></li>
                @if (config('firm.author_url'))
                    <li><a href="{{ config('firm.author_url') }}" class="text-paper/85 no-underline hover:text-paper hover:underline">Portofolio pembuat situs</a></li>
                @endif
            </ul>
        </div>
    </div>
    <div class="border-t border-paper/15">
        <div class="container-page flex flex-col gap-2 py-6 text-xs text-paper/70 sm:flex-row sm:items-center sm:justify-between">
            <p>{{ config('firm.demo_notice') }}</p>
            <p>&copy; {{ now()->year }} Situs demo portofolio Tenma.</p>
        </div>
    </div>
</footer>
