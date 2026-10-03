<?php

namespace App\Filament\Resources\ConsultationRequests\Tables;

use App\Enums\ConsultationStatus;
use App\Models\ConsultationRequest;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ConsultationRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Belum ada permintaan konsultasi')
            ->emptyStateDescription('Kiriman dari form kontak akan muncul di sini dan terhapus otomatis setelah '.ConsultationRequest::RETENTION_DAYS.' hari.')
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable()->weight('medium')
                    ->description(fn (ConsultationRequest $record): string => $record->email),
                TextColumn::make('practiceArea.name')->label('Bidang')->placeholder('—')->visibleFrom('md'),
                TextColumn::make('status')->label('Status')->badge(),
                TextColumn::make('created_at')->label('Dikirim')->since()->sortable()
                    ->tooltip(fn (ConsultationRequest $record): string => $record->created_at->translatedFormat('j F Y, H.i')),
                TextColumn::make('delete_at')
                    ->label('Dihapus pada')
                    ->state(fn (ConsultationRequest $record) => $record->deleteAt())
                    ->date('j M Y')
                    ->color('gray')
                    ->visibleFrom('lg'),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options(ConsultationStatus::class),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('dihubungi')
                    ->label('Tandai dihubungi')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (ConsultationRequest $record): bool => in_array($record->status, [ConsultationStatus::Baru, ConsultationStatus::Ditinjau], true))
                    ->action(fn (ConsultationRequest $record) => $record->update(['status' => ConsultationStatus::Dihubungi])),
                EditAction::make()->label('Tindak lanjut'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
