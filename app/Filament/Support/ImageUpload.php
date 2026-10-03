<?php

namespace App\Filament\Support;

use Filament\Forms\Components\FileUpload;

/**
 * Field unggah gambar yang aman: hanya JPG/PNG/WebP (SVG ditolak karena bisa
 * berisi skrip), maks. 2 MB, nama file acak, disimpan di disk public.
 * Setelah tersimpan, gambar dioptimasi ke WebP lewat queue (App\Jobs\OptimizeImage).
 */
class ImageUpload
{
    public const ACCEPTED_TYPES = ['image/jpeg', 'image/png', 'image/webp'];

    public const MAX_KB = 2048;

    public static function make(string $field, string $directory): FileUpload
    {
        return FileUpload::make($field)
            ->disk('public')
            ->directory($directory)
            ->visibility('public')
            ->acceptedFileTypes(self::ACCEPTED_TYPES)
            ->maxSize(self::MAX_KB)
            ->imagePreviewHeight('160');
    }
}
