<?php

namespace App\Filament\Resources\ArticleCategories;

use App\Filament\Resources\ArticleCategories\Pages\ManageArticleCategories;
use App\Filament\Support\SlugField;
use App\Models\ArticleCategory;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ArticleCategoryResource extends Resource
{
    protected static ?string $model = ArticleCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static string|UnitEnum|null $navigationGroup = 'Konten situs';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'kategori artikel';

    protected static ?string $pluralModelLabel = 'kategori artikel';

    protected static ?string $slug = 'kategori-artikel';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                ...SlugField::make('name', 'Nama', ArticleCategory::class),
                Textarea::make('description')->label('Deskripsi')->maxLength(200)->rows(2),
                TextInput::make('sort_order')->label('Urutan')->numeric()->minValue(0)->maxValue(999)->default(0)->required(),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable()->weight('medium'),
                TextColumn::make('articles_count')->label('Artikel')->counts('articles')->badge(),
                TextColumn::make('description')->label('Deskripsi')->limit(60)->visibleFrom('md'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->disabled(fn (ArticleCategory $record): bool => $record->articles()->exists())
                    ->tooltip(fn (ArticleCategory $record): ?string => $record->articles()->exists() ? 'Pindahkan artikelnya dulu ke kategori lain.' : null),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageArticleCategories::route('/'),
        ];
    }
}
