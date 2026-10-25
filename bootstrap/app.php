<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Di balik Tailscale Funnel → Caddy (mode tunnel), PHP menerima REMOTE_ADDR 127.0.0.1 plus
        // X-Forwarded-For/Proto/Host. Hanya proxy lokal itu yang dipercaya, supaya IP pengunjung asli
        // dipakai untuk rate limit dan skema https terdeteksi (cookie Secure, URL absolut, redirect).
        // Host dan Port tidak dipercaya: Funnel sudah meneruskan header Host asli, sedangkan
        // X-Forwarded-Port kiriman pengunjung diteruskan Funnel apa adanya (tidak ditimpa).
        $middleware->trustProxies(
            at: ['127.0.0.1'],
            headers: Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_PROTO,
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
