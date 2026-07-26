<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SetLocale;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // 1. TAMBAHKAN ALIAS MIDDLEWARE ADMIN (Untuk Pertemuan 8)
        $middleware->alias([
            'locale' => SetLocale::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // 2. PERTAHANKAN PENGECUALIAN CSRF MIDTRANS (Punya kamu yang sudah benar)
        $middleware->validateCsrfTokens(except: [
            '/midtrans/callback', // Mengecualikan route webhook Midtrans dari blokir CSRF
        ]);

        $middleware->web(append: [
            SetLocale::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();