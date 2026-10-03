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

        // Form konsultasi: maksimal 5 kiriman per 10 menit dan 20 per hari per alamat IP.
        // IP hanya dipakai sebagai kunci hash di cache, tidak disimpan di database.
        RateLimiter::for('konsultasi', function (Request $request) {
            $key = hash('sha256', 'konsultasi|'.$request->ip());

            $tooMany = fn () => redirect()->to(route('contact').'#form-konsultasi')
                ->withInput($request->except(['website', 'form_started_at']))
                ->withErrors(['form' => 'Terlalu banyak kiriman dari perangkat ini. Silakan coba lagi beberapa saat lagi.']);

            return [
                Limit::perMinutes(10, 5)->by($key)->response($tooMany),
                Limit::perDay(20)->by($key.'|hari')->response($tooMany),
            ];
        });
    }
}
