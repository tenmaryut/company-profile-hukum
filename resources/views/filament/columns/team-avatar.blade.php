<div class="px-3 py-2">
    @if ($getRecord()->photoUrl())
        <img src="{{ $getRecord()->photoUrl() }}" alt="" class="h-10 w-10 rounded-full object-cover">
    @else
        <x-avatar :variant="$getRecord()->avatar_variant" class="h-10 w-10 overflow-hidden rounded-full" />
    @endif
</div>
