<?php

namespace App\Filament\Resources\ConsultationRequests\Schemas;

use App\Models\ConsultationRequest;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConsultationRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Kiriman pengunjung')
                    ->columnSpan(['lg' => 2])
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')->label('Nama'),
                        TextEntry::make('email')->label('Email')->copyable(),
                        TextEntry::make('phone')->label('Telepon')->placeholder('Tidak diisi'),
                        TextEntry::make('practiceArea.name')->label('Bidang hukum')->placeholder('Belum dipilih'),
                        TextEntry::make('message')->label('Uraian')->columnSpanFull()->prose(),
                    ]),
                Section::make('Status dan retensi')
                    ->columnSpan(['lg' => 1])
                    ->schema([
                        TextEntry::make('status')->label('Status')->badge(),
                        TextEntry::make('admin_note')->label('Catatan internal')->placeholder('Belum ada catatan'),
                        TextEntry::make('created_at')->label('Dikirim')->dateTime('j M Y, H.i'),
                        TextEntry::make('consented_at')->label('Persetujuan privasi')->dateTime('j M Y, H.i'),
                        TextEntry::make('delete_at')
                            ->label('Dihapus otomatis')
                            ->state(fn (ConsultationRequest $record) => $record->deleteAt())
                            ->dateTime('j M Y, H.i')
                            ->helperText('Retensi '.ConsultationRequest::RETENTION_DAYS.' hari sesuai pemberitahuan privasi.'),
                        IconEntry::make('is_sample')->label('Data contoh')->boolean(),
                    ]),
            ]);
    }
}
