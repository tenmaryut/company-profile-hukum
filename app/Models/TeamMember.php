<?php

namespace App\Models;

use App\Observers\ImageAttributeObserver;
use Database\Factories\TeamMemberFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

#[ObservedBy(ImageAttributeObserver::class)]
#[Fillable(['name', 'slug', 'position', 'focus', 'bio', 'avatar_variant', 'photo_path', 'sort_order', 'is_published'])]
class TeamMember extends Model
{
    /** @use HasFactory<TeamMemberFactory> */
    use HasFactory;

    /** Varian avatar ilustrasi (SVG buatan sendiri) di components/avatar.blade.php. */
    public const AVATAR_VARIANTS = [
        1 => 'Rambut pendek, kacamata, jas biru tua',
        2 => 'Berhijab, blazer hijau tua',
        3 => 'Rambut sebahu, blazer cokelat',
        4 => 'Rambut ikal, kemeja dan rompi',
        5 => 'Berhijab, blazer abu-abu, kacamata',
        6 => 'Rambut cepak, jas abu-abu',
        7 => 'Rambut dikuncir, blazer biru',
        8 => 'Rambut beruban, jas cokelat tua',
    ];

    /** Kolom gambar => lebar maksimum setelah dioptimasi (lihat ImageAttributeObserver). */
    public array $imageAttributes = ['photo_path' => 512];

    protected function casts(): array
    {
        return [
            'avatar_variant' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('is_published', true)->orderBy('sort_order')->orderBy('name');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function photoUrl(): ?string
    {
        return $this->photo_path ? Storage::disk('public')->url($this->photo_path) : null;
    }
}
