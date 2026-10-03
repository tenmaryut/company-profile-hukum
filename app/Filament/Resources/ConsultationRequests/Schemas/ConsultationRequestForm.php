<?php

namespace App\Filament\Resources\ConsultationRequests\Schemas;

use App\Enums\ConsultationStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/** Admin hanya mengubah status dan catatan internal; isi kiriman pengunjung tidak bisa diedit. */
class ConsultationRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tindak lanjut')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options(ConsultationStatus::class)
                            ->required(),
                        Textarea::make('admin_note')
                            ->label('Catatan internal')
                            ->rows(4)
                            ->maxLength(2000),
                    ]),
            ])
            ->columns(1);
    }
}
