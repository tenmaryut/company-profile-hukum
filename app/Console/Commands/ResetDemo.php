<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Support\ContentLibrary;
use Database\Seeders\DemoContentSeeder;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

/**
 * Mengembalikan seluruh data situs demo ke kondisi awal. Dijalankan tiap malam
 * oleh systemd timer (company-profile-hukum-demo-reset.timer).
 *
 * Yang dipertahankan hanya akun admin asli (users.is_demo = false).
 */
#[Signature('demo:reset {--force : Jalankan tanpa konfirmasi di production}')]
#[Description('Reset konten, unggahan, permintaan konsultasi, dan akun demo ke kondisi awal')]
class ResetDemo extends Command
{
    use ConfirmableTrait;

    /** Tabel konten yang dikosongkan lalu diisi ulang dari database/content. */
    public const TABLES = ['consultation_requests', 'articles', 'article_categories', 'team_members', 'practice_areas', 'faqs', 'page_contents', 'notifications'];

    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return self::FAILURE;
        }

        // Pastikan konten awal lengkap dan terbaca SEBELUM menghapus apa pun.
        try {
            $content = new ContentLibrary;
            $content->articles();
            $content->practiceAreas();
            $content->team();
            $content->faqs();
            $content->profile();
            $content->ethics();
            $content->privacy();
        } catch (Throwable $e) {
            Log::error('Reset demo dibatalkan: konten awal tidak lengkap.', ['pesan' => $e->getMessage()]);
            $this->error('Reset dibatalkan, data tidak diubah: '.$e->getMessage());

            return self::FAILURE;
        }

        $lock = Cache::lock('demo-reset', 300);

        if (! $lock->get()) {
            $this->error('Reset demo lain sedang berjalan.');

            return self::FAILURE;
        }

        try {
            DB::transaction(function (): void {
                foreach (self::TABLES as $table) {
                    DB::table($table)->delete();
                }

                $demo = User::updateOrCreate(
                    ['email' => config('firm.demo_account.email')],
                    ['name' => config('firm.demo_account.name'), 'password' => config('firm.demo_account.password'), 'is_demo' => true],
                );

                User::query()->where('is_demo', true)->whereKeyNot($demo->getKey())->delete();

                // Keluarkan semua sesi akun demo supaya pengunjung mulai dari kondisi bersih.
                DB::table('sessions')->whereIn('user_id', User::query()->where('is_demo', true)->select('id'))->delete();
                $demo->forceFill(['remember_token' => null])->saveQuietly();
            });

            $disk = Storage::disk('public');
            $disk->deleteDirectory('articles');
            $disk->deleteDirectory('team');

            $this->callSilently('db:seed', ['--class' => DemoContentSeeder::class, '--force' => true]);
        } finally {
            $lock->release();
        }

        Log::info('Data situs demo direset.');
        $this->info('Data situs demo sudah direset ke kondisi awal.');

        return self::SUCCESS;
    }
}
