<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use App\Filament\Support\ImageUpload;
use App\Filament\Support\SlugField;
use App\Models\TeamMember;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeamMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Profil')
                    ->columnSpan(['lg' => 2])
                    ->columns(2)
                    ->schema([
                        ...SlugField::make('name', 'Nama', TeamMember::class),
                        TextInput::make('position')
                            ->label('Jabatan')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('focus')
                            ->label('Fokus praktik')
                            ->maxLength(150),
                        Textarea::make('bio')
                            ->label('Bio singkat')
                            ->required()
                            ->rows(4)
                            ->maxLength(800)
                            ->columnSpanFull(),
                    ]),
                Section::make('Avatar dan tampilan')
                    ->columnSpan(['lg' => 1])
                    ->schema([
                        Select::make('avatar_variant')
                            ->label('Avatar ilustrasi')
                            ->options(TeamMember::AVATAR_VARIANTS)
                            ->required()
                            ->default(1),
                        ImageUpload::make('photo_path', 'team')
                            ->label('Foto (opsional)')
                            ->helperText('Menggantikan avatar ilustrasi. JPG, PNG, atau WebP, maks. 2 MB. Untuk demo, gunakan gambar ilustrasi, bukan foto orang sungguhan.')
                            ->avatar()
                            ->imageEditor(),
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
