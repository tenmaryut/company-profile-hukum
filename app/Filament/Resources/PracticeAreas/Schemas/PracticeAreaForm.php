<?php

namespace App\Filament\Resources\PracticeAreas\Schemas;

use App\Filament\Support\SlugField;
use App\Models\PracticeArea;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PracticeAreaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Isi')
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        ...SlugField::make('name', 'Nama bidang', PracticeArea::class),
                        Textarea::make('summary')
                            ->label('Ringkasan')
                            ->helperText('Satu kalimat, tampil di kartu dan sebagai meta description.')
                            ->required()
                            ->maxLength(160)
                            ->rows(2),
                        MarkdownEditor::make('description')
                            ->label('Deskripsi')
                            ->required()
                            ->toolbarButtons([['bold', 'italic', 'link'], ['heading', 'bulletList', 'orderedList'], ['undo', 'redo']]),
                        Repeater::make('services')
                            ->label('Layanan')
                            ->simple(TextInput::make('item')->required()->maxLength(160))
                            ->addActionLabel('Tambah layanan')
                            ->reorderable()
                            ->maxItems(10),
                        Repeater::make('legal_basis')
                            ->label('Dasar hukum utama')
                            ->helperText('Tulis nama peraturan lengkap, mis. "Undang-Undang Nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi".')
                            ->simple(TextInput::make('item')->required()->maxLength(250))
                            ->addActionLabel('Tambah dasar hukum')
                            ->reorderable()
                            ->maxItems(8),
                    ]),
                Section::make('Tampilan')
                    ->columnSpan(['lg' => 1])
                    ->schema([
                        Select::make('icon')
                            ->label('Ikon')
                            ->options(PracticeArea::ICONS)
                            ->required()
                            ->default('timbangan'),
                        TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(999)
                            ->default(0)
                            ->required(),
                        Toggle::make('is_published')
                            ->label('Tampil di situs')
                            ->default(true),
                    ]),
            ]);
    }
}
