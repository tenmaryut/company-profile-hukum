@props(['text' => 'Halo, saya ingin bertanya tentang layanan konsultasi.', 'label' => 'Chat WhatsApp'])
{{-- Nomor placeholder yang sengaja tidak valid (lihat config/firm.php). --}}
<a href="https://wa.me/{{ config('firm.whatsapp') }}?text={{ rawurlencode($text) }}" {{ $attributes->merge(['class' => 'btn btn-whatsapp']) }} rel="noopener noreferrer">
    <x-ikon name="chat" class="size-5" />
    <span>{{ $label }}</span>
</a>
