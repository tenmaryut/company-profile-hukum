<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * Blok teks halaman yang bisa diubah dari panel admin (Markdown).
 */
#[Fillable(['key', 'title', 'body'])]
class PageContent extends Model
{
    public const KEYS = [
        'profil' => 'Profil firma',
        'etika' => 'Etika profesi',
        'privasi' => 'Pemberitahuan privasi',
    ];

    public static function body(string $key): string
    {
        return (string) static::query()->where('key', $key)->value('body');
    }
}
