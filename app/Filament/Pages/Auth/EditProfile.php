<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Facades\Filament;

/**
 * Akun demo tidak boleh mengubah nama, email, atau kata sandinya sendiri,
 * supaya pengunjung berikutnya tetap bisa masuk dengan kredensial yang tertera.
 */
class EditProfile extends BaseEditProfile
{
    public static function canAccess(): bool
    {
        return ! (Filament::auth()->user()?->is_demo ?? true);
    }
}
