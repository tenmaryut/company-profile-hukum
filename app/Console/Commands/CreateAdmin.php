<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

/**
 * Membuat atau memperbarui akun admin asli (bukan demo). Kata sandi dibaca dari
 * STDIN (--password-stdin) atau dibuat acak lalu dicetak sekali.
 */
#[Signature('app:create-admin {email} {--name=Admin Nalar Saksama} {--password-stdin : Baca kata sandi dari STDIN}')]
#[Description('Buat atau perbarui akun admin asli panel /admin')]
class CreateAdmin extends Command
{
    public function handle(): int
    {
        $email = (string) $this->argument('email');
        $generated = ! $this->option('password-stdin');
        $password = $generated ? Str::password(24, symbols: false) : trim((string) stream_get_contents(STDIN));

        $validator = Validator::make(
            ['email' => $email, 'password' => $password],
            ['email' => ['required', 'email:rfc'], 'password' => ['required', Password::min(12)->letters()->numbers()]],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                $this->error($message);
            }

            return self::FAILURE;
        }

        if ($email === config('firm.demo_account.email')) {
            $this->error('Email ini dipakai akun demo.');

            return self::FAILURE;
        }

        User::updateOrCreate(
            ['email' => $email],
            ['name' => (string) $this->option('name'), 'password' => $password, 'is_demo' => false, 'email_verified_at' => now()],
        );

        $this->info("Akun admin {$email} siap.");

        if ($generated) {
            $this->line("Kata sandi: {$password}");
        }

        return self::SUCCESS;
    }
}
