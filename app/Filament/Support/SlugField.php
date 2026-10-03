<?php

namespace App\Filament\Support;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

/**
 * Pasangan field judul + slug: slug terisi otomatis dari judul saat membuat data baru.
 */
class SlugField
{
    /**
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $model
     * @return array<TextInput>
     */
    public static function make(string $source, string $label, string $model): array
    {
        return [
            TextInput::make($source)
                ->label($label)
                ->required()
                ->maxLength(150)
                ->live(onBlur: true)
                ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state, string $operation): void {
                    if ($operation !== 'create' && filled($get('slug'))) {
                        return;
                    }

                    if (blank($get('slug')) || $get('slug') === Str::slug((string) $old)) {
                        $set('slug', Str::slug((string) $state));
                    }
                }),
            TextInput::make('slug')
                ->label('Slug (alamat URL)')
                ->helperText('Huruf kecil, angka, dan tanda hubung.')
                ->required()
                ->maxLength(160)
                ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                ->unique($model, 'slug', ignoreRecord: true),
        ];
    }
}
