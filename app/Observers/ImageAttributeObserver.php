<?php

namespace App\Observers;

use App\Jobs\OptimizeImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Untuk model dengan kolom gambar ($imageAttributes): optimasi gambar baru lewat
 * queue, dan hapus file lama saat gambar diganti atau datanya dihapus.
 */
class ImageAttributeObserver
{
    public function saved(Model $model): void
    {
        foreach ($model->imageAttributes ?? [] as $attribute => $maxWidth) {
            if (! $model->wasChanged($attribute) && ! $model->wasRecentlyCreated) {
                continue;
            }

            $old = $model->getOriginal($attribute);

            if ($model->wasChanged($attribute) && is_string($old) && $old !== '') {
                Storage::disk('public')->delete($old);
            }

            $new = $model->getAttribute($attribute);

            if (is_string($new) && $new !== '') {
                OptimizeImage::dispatch($model, $attribute, $maxWidth);
            }
        }
    }

    public function deleted(Model $model): void
    {
        foreach (array_keys($model->imageAttributes ?? []) as $attribute) {
            $path = $model->getAttribute($attribute);

            if (is_string($path) && $path !== '') {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
