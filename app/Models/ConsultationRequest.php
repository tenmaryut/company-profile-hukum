<?php

namespace App\Models;

use App\Enums\ConsultationStatus;
use Database\Factories\ConsultationRequestFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

#[Fillable(['practice_area_id', 'name', 'email', 'phone', 'message', 'status', 'admin_note', 'consented_at', 'submitter_token_hash', 'is_sample'])]
class ConsultationRequest extends Model
{
    /** @use HasFactory<ConsultationRequestFactory> */
    use HasFactory, Prunable;

    /** Lama penyimpanan data form (UU 27/2022: data tidak disimpan lebih lama dari yang diperlukan). */
    public const RETENTION_DAYS = 7;

    /** Cookie penanda browser pengirim, dipakai untuk membatasi apa yang dilihat akun demo. */
    public const SUBMITTER_COOKIE = 'ns_pengirim';

    protected function casts(): array
    {
        return [
            'status' => ConsultationStatus::class,
            'consented_at' => 'datetime',
            'is_sample' => 'boolean',
        ];
    }

    public function practiceArea(): BelongsTo
    {
        return $this->belongsTo(PracticeArea::class);
    }

    /** Dipanggil `model:prune` (dijadwalkan tiap jam): hapus data yang lebih tua dari 7 hari. */
    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subDays(self::RETENTION_DAYS));
    }

    /**
     * Akun demo hanya boleh melihat data contoh dan kiriman dari browsernya sendiri,
     * supaya data pengunjung lain tidak terbuka lewat kredensial demo yang publik.
     */
    #[Scope]
    protected function visibleTo(Builder $query, ?User $user, ?string $submitterToken): void
    {
        if ($user === null) {
            $query->whereRaw('1 = 0');

            return;
        }

        if (! $user->is_demo) {
            return;
        }

        $query->where(function (Builder $query) use ($submitterToken): void {
            $query->where('is_sample', true);

            if (filled($submitterToken)) {
                $query->orWhere('submitter_token_hash', self::hashToken($submitterToken));
            }
        });
    }

    public static function hashToken(string $token): string
    {
        return hash('sha256', $token);
    }

    public function deleteAt(): Carbon
    {
        return $this->created_at->copy()->addDays(self::RETENTION_DAYS);
    }
}
