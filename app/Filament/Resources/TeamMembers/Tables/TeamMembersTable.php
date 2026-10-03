<?php

namespace App\Filament\Resources\TeamMembers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class TeamMembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                ViewColumn::make('avatar_variant')->label('')->view('filament.columns.team-avatar'),
                TextColumn::make('name')->label('Nama')->searchable()->sortable()->weight('medium')
                    ->description(fn ($record) => $record->position),
                TextColumn::make('focus')->label('Fokus')->limit(40)->toggleable()->visibleFrom('md'),
                ToggleColumn::make('is_published')->label('Tampil'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
