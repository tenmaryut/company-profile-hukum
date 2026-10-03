<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Mengecilkan gambar unggahan dan mengubahnya ke WebP dengan GD.
 * Encode ulang sekaligus membuang metadata EXIF (mis. lokasi GPS).
 */
class OptimizeImage implements ShouldQueue
{
    use Queueable;

    public int $tries = 2;

    public bool $deleteWhenMissingModels = true;

    public function __construct(
        public Model $model,
        public string $attribute,
        public int $maxWidth = 1600,
    ) {
    }

    public function handle(): void
    {
        $disk = Storage::disk('public');
        $path = $this->model->getAttribute($this->attribute);

        if (! is_string($path) || ! $disk->exists($path)) {
            return;
        }

        $image = @imagecreatefromstring($disk->get($path));

        if ($image === false) {
            Log::warning('Gambar tidak bisa dibaca untuk dioptimasi.', ['path' => $path]);

            return;
        }

        $width = imagesx($image);

        if ($width > $this->maxWidth) {
            $resized = imagescale($image, $this->maxWidth, -1, IMG_BICUBIC);
            imagedestroy($image);
            $image = $resized;
        }

        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        ob_start();
        imagewebp($image, null, 80);
        $webp = (string) ob_get_clean();
        imagedestroy($image);

        $newPath = trim(dirname($path), '/.').'/'.Str::uuid().'.webp';
        $disk->put($newPath, $webp, 'public');

        // Bandingkan dengan nilai terbaru: abaikan kalau gambar sudah diganti lagi sementara job menunggu.
        $fresh = $this->model->fresh();

        if ($fresh?->getAttribute($this->attribute) !== $path) {
            $disk->delete($newPath);

            return;
        }

        $fresh->forceFill([$this->attribute => $newPath])->saveQuietly();
        $disk->delete($path);
    }
}
