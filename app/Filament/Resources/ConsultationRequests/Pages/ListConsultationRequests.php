<?php

namespace App\Filament\Resources\ConsultationRequests\Pages;

use App\Filament\Resources\ConsultationRequests\ConsultationRequestResource;
use App\Models\ConsultationRequest;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;

class ListConsultationRequests extends ListRecords
{
    protected static string $resource = ConsultationRequestResource::class;

    public function getSubheading(): ?string
    {
        $text = 'Kiriman dihapus otomatis '.ConsultationRequest::RETENTION_DAYS.' hari setelah masuk.';

        if (Filament::auth()->user()?->is_demo) {
            $text .= ' Akun demo hanya menampilkan data contoh dan kiriman dari browser Anda sendiri.';
        }

        return $text;
    }
}
