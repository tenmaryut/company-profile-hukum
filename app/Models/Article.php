<?php

namespace App\Models;

use App\Observers\ImageAttributeObserver;
use App\Support\Markdown;
use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[ObservedBy(ImageAttributeObserver::class)]
#[Fillable(['article_category_id', 'team_member_id', 'title', 'slug', 'excerpt', 'body', 'cover_path', 'cover_alt', 'published_at'])]
class Article extends Model
{
    /** @use HasFactory<ArticleFactory> */
    use HasFactory;

    /** Kolom gambar => lebar maksimum setelah dioptimasi (lihat ImageAttributeObserver). */
    public array $imageAttributes = ['cover_path' => 1600];

    /** @var array{html: string, toc: list<array{id: string, text: string, level: int}>}|null */
    protected ?array $renderedBody = null;

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'team_member_id');
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    /** Pencarian sederhana di judul, ringkasan, dan isi (query terparameter). */
    #[Scope]
    protected function search(Builder $query, ?string $term): void
    {
        $term = Str::of((string) $term)->squish()->limit(100, '')->toString();

        if ($term === '') {
            return;
        }

        $query->where(function (Builder $query) use ($term): void {
            $query->whereLike('title', "%{$term}%")
                ->orWhereLike('excerpt', "%{$term}%")
                ->orWhereLike('body', "%{$term}%");
        });
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at->isPast();
    }

    /** @return array{html: string, toc: list<array{id: string, text: string, level: int}>} */
    public function rendered(): array
    {
        return $this->renderedBody ??= Markdown::render($this->body);
    }

    public function readingMinutes(): int
    {
        return max(1, (int) ceil(str_word_count(Markdown::plainText($this->body)) / 200));
    }

    public function coverUrl(): ?string
    {
        return $this->cover_path ? Storage::disk('public')->url($this->cover_path) : null;
    }
}
