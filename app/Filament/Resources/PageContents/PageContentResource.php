<?php

namespace App\Filament\Resources\PageContents;

use App\Filament\Resources\PageContents\Pages\EditPageContent;
use App\Filament\Resources\PageContents\Pages\ListPageContents;
use App\Models\PageContent;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

/**
 * Teks halaman profil, etika, dan pemberitahuan privasi. Kuncinya tetap,
 * jadi hanya bisa diubah, tidak ditambah atau dihapus.
 */
class PageContentResource extends Resource
{
    protected static ?string $model = PageContent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Konten situs';

    protected static ?int $navigationSort = 6;

    protected static ?string $modelLabel = 'teks halaman';

    protected static ?string $pluralModelLabel = 'teks halaman';

    protected static ?string $slug = 'teks-halaman';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->label('Judul blok')->required()->maxLength(150),
                MarkdownEditor::make('body')
                    ->label('Isi (Markdown)')
                    ->required()
                    ->toolbarButtons([['bold', 'italic', 'link'], ['heading'], ['blockquote', 'bulletList', 'orderedList'], ['undo', 'redo']])
                    ->minHeight('24rem'),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Blok')->weight('medium')
                    ->description(fn (PageContent $record): string => match ($record->key) {
                        'profil' => 'Halaman Profil, bagian atas',
                        'etika' => 'Halaman Profil, bagian etika profesi',
                        'privasi' => 'Halaman Pemberitahuan Privasi',
                        default => $record->key,
                    }),
                TextColumn::make('updated_at')->label('Diperbarui')->since(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPageContents::route('/'),
            'edit' => EditPageContent::route('/{record}/edit'),
        ];
    }
}
