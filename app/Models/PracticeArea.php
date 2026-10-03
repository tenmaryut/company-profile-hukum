<?php

namespace App\Models;

use Database\Factories\PracticeAreaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'summary', 'description', 'services', 'legal_basis', 'icon', 'sort_order', 'is_published'])]
class PracticeArea extends Model
{
    /** @use HasFactory<PracticeAreaFactory> */
    use HasFactory;

    /** Ikon garis yang tersedia di resources/views/components/icon.blade.php. */
    public const ICONS = [
        'timbangan' => 'Timbangan',
        'palu' => 'Palu sidang',
        'dokumen' => 'Dokumen',
        'gembok' => 'Gembok',
        'keluarga' => 'Keluarga',
        'gedung' => 'Gedung',
        'tangan' => 'Jabat tangan',
        'perisai' => 'Perisai',
    ];

    protected function casts(): array
    {
        return [
            'services' => 'array',
            'legal_basis' => 'array',
            'is_published' => 'boolean',
        ];
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('is_published', true)->orderBy('sort_order')->orderBy('name');
    }

    public function consultationRequests(): HasMany
    {
        return $this->hasMany(ConsultationRequest::class);
    }
}
