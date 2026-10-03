<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');

        Model::preventLazyLoading(! $this->app->isProduction());

        Password::defaults(fn () => Password::min(12)->letters()->numbers());

        // Form konsultasi: maksimal 5 kiriman per 10 menit dan 20 per hari per pengunjung.
        // $request->ip() adalah IP pengunjung asli (lihat trustProxies di bootstrap/app.php);
        // IP hanya dipakai sebagai kunci hash di cache, tidak disimpan di database.
        RateLimiter::for('konsultasi', function (Request $request) {
            $key = hash('sha256', 'konsultasi|'.$request->ip());

            $tooMany = fn (Request $request, array $headers) => redirect()->to(route('contact').'#form-konsultasi')
                ->withInput($request->except(['website', 'form_started_at']))
                ->withErrors(['form' => 'Terlalu banyak kiriman dari perangkat ini. Silakan coba lagi beberapa saat lagi.'])
                ->withHeaders($headers);

            // Batas 10 menit sengaja terakhir: header X-RateLimit-* di respons memakai batas ini.
            return [
                Limit::perDay(20)->by($key.'|hari')->response($tooMany),
                Limit::perMinutes(10, 5)->by($key)->response($tooMany),
            ];
        });
    }
}
