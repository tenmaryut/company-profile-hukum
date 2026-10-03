<?php

namespace App\Filament\Resources\Articles\Tables;

use App\Models\Article;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                ImageColumn::make('cover_path')->label('Sampul')->disk('public')->imageHeight(40)->visibleFrom('md'),
                TextColumn::make('title')->label('Judul')->searchable()->sortable()->weight('medium')->wrap()
                    ->description(fn (Article $record): ?string => $record->category?->name),
                TextColumn::make('author.name')->label('Penulis')->toggleable()->visibleFrom('lg'),
                TextColumn::make('published_at')->label('Terbit')->date('j M Y')->sortable()
                    ->placeholder('Draf')
                    ->badge()
                    ->color(fn (Article $record): string => $record->isPublished() ? 'success' : 'gray'),
            ])
            ->filters([
                SelectFilter::make('article_category_id')->label('Kategori')->relationship('category', 'name'),
                TernaryFilter::make('published')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Terbit')
                    ->falseLabel('Draf / terjadwal')
                    ->queries(
                        true: fn (Builder $query) => $query->published(),
                        false: fn (Builder $query) => $query->where(fn (Builder $q) => $q->whereNull('published_at')->orWhere('published_at', '>', now())),
                    ),
            ])
            ->recordActions([
                Action::make('lihat')
                    ->label('Lihat')
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->color('gray')
                    ->url(fn (Article $record): string => route('articles.show', $record), shouldOpenInNewTab: true)
                    ->visible(fn (Article $record): bool => $record->isPublished()),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
