<x-layouts.app
    title="Tim"
    description="Advokat dan staf Kantor Hukum Nalar Saksama. Firma, nama, dan profil di halaman ini fiktif untuk keperluan situs demo portofolio."
    :breadcrumbs="[['label' => 'Tim', 'url' => route('team')]]"
>
    <x-page-header
        eyebrow="Tim"
        title="Advokat dan staf"
        lead="Semua nama, profil, dan avatar di halaman ini fiktif. Avatar berupa ilustrasi, bukan foto orang sungguhan."
        :breadcrumbs="[['label' => 'Tim', 'url' => route('team')]]"
    />

    <section class="container-page py-14 sm:py-16">
        <ul class="grid gap-6 md:grid-cols-2">
            @foreach ($team as $member)
                <li id="{{ $member->slug }}" class="card reveal lift flex flex-col gap-5 p-6 sm:flex-row sm:p-8">
                    @if ($member->photoUrl())
                        <img src="{{ $member->photoUrl() }}" alt="" width="112" height="112" loading="lazy" class="size-28 flex-none rounded-full object-cover">
                    @else
                        <x-avatar :variant="$member->avatar_variant" class="size-28 flex-none overflow-hidden rounded-full" />
                    @endif
                    <div>
                        <h2 class="text-2xl">{{ $member->name }}</h2>
                        <p class="mt-1 text-sm font-semibold uppercase tracking-[0.12em] text-brass-ink">{{ $member->position }}</p>
                        @if ($member->focus)
                            <p class="mt-3 text-[0.9375rem]"><span class="font-semibold">Fokus:</span> <span class="text-ink-2">{{ $member->focus }}</span></p>
                        @endif
                        <p class="mt-3 text-[0.9375rem] text-ink-2">{{ $member->bio }}</p>
                        @if ($member->articles_count)
                            <p class="mt-3 text-sm text-muted">{{ $member->articles_count }} artikel ditulis</p>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </section>

    <x-cta-band />
</x-layouts.app>
