<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Isi demo + akun demo publik. Akun admin asli dibuat terpisah dengan `php artisan app:create-admin`.
     */
    public function run(): void
    {
        $this->call(DemoContentSeeder::class);

        User::updateOrCreate(
            ['email' => config('firm.demo_account.email')],
            ['name' => config('firm.demo_account.name'), 'password' => config('firm.demo_account.password'), 'is_demo' => true],
        );
    }
}
