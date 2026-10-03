<?php

namespace App\Notifications;

use App\Filament\Resources\ConsultationRequests\ConsultationRequestResource;
use App\Models\ConsultationRequest;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * Pemberitahuan di panel admin saat ada permintaan konsultasi baru. Diproses
 * lewat queue. Isinya sengaja tanpa data pribadi pengirim, karena akun demo
 * yang kredensialnya publik juga menerima pemberitahuan ini.
 */
class NewConsultationRequest extends Notification implements ShouldQueue
{
    use Queueable;

    /** Data bisa sudah terhapus (reset demo/retensi 7 hari) sebelum job diproses. */
    public bool $deleteWhenMissingModels = true;

    public function __construct(public ConsultationRequest $consultation)
    {
    }

    /** @return list<string> */
    public function via(User $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(User $notifiable): array
    {
        $area = $this->consultation->practiceArea?->name ?? 'belum dipilih';

        return FilamentNotification::make()
            ->title('Permintaan konsultasi baru')
            ->body("Bidang: {$area}. Data akan terhapus otomatis setelah ".ConsultationRequest::RETENTION_DAYS.' hari.')
            ->icon('heroicon-o-inbox-arrow-down')
            ->actions([
                Action::make('lihat')
                    ->label('Lihat daftar')
                    ->url(ConsultationRequestResource::getUrl('index'))
                    ->markAsRead(),
            ])
            ->getDatabaseMessage();
    }
}
