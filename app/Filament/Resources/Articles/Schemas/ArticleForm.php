<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Filament\Support\ImageUpload;
use App\Filament\Support\SlugField;
use App\Models\Article;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Tulisan')
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        ...SlugField::make('title', 'Judul', Article::class),
                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->helperText('120–160 karakter. Tampil di daftar artikel dan sebagai meta description.')
                            ->required()
                            ->maxLength(160)
                            ->rows(2),
                        MarkdownEditor::make('body')
                            ->label('Isi (Markdown)')
                            ->helperText('Gunakan ## untuk subjudul dan [^1] untuk catatan kaki. HTML mentah tidak ditampilkan.')
                            ->required()
                            ->toolbarButtons([
                                ['bold', 'italic', 'link'],
                                ['heading'],
                                ['blockquote', 'bulletList', 'orderedList'],
                                ['undo', 'redo'],
                            ])
                            ->minHeight('28rem'),
                    ]),
                Section::make('Publikasi')
                    ->columnSpan(['lg' => 1])
                    ->schema([
                        Select::make('article_category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->required()
                            ->preload(),
                        Select::make('team_member_id')
                            ->label('Penulis')
                            ->relationship('author', 'name')
                            ->preload()
                            ->placeholder('Tim Nalar Saksama'),
                        DateTimePicker::make('published_at')
                            ->label('Tanggal terbit')
                            ->helperText('Kosongkan untuk menyimpan sebagai draf.')
                            ->seconds(false)
                            ->native(false),
                        ImageUpload::make('cover_path', 'articles')
                            ->label('Gambar sampul')
                            ->helperText('JPG, PNG, atau WebP, maks. 2 MB. Rasio ideal 1200×630. Otomatis dikonversi ke WebP.')
                            ->imageEditor()
                            ->imageAspectRatio('40:21'),
                        TextInput::make('cover_alt')
                            ->label('Teks alternatif sampul')
                            ->helperText('Deskripsi gambar untuk pembaca layar.')
                            ->maxLength(200)
                            ->requiredWith('cover_path'),
                    ]),
            ]);
    }
}
