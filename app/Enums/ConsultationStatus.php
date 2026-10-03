<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ConsultationStatus: string implements HasColor, HasLabel
{
    case Baru = 'baru';
    case Ditinjau = 'ditinjau';
    case Dihubungi = 'dihubungi';
    case Selesai = 'selesai';

    public function getLabel(): string
    {
        return match ($this) {
            self::Baru => 'Baru',
            self::Ditinjau => 'Sedang ditinjau',
            self::Dihubungi => 'Sudah dihubungi',
            self::Selesai => 'Selesai',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Baru => 'warning',
            self::Ditinjau => 'info',
            self::Dihubungi => 'primary',
            self::Selesai => 'success',
        };
    }
}
