<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Daftarkan View Composer untuk admin layout
        View::composer('layouts.admin', \App\Http\View\Composers\AdminMenuComposer::class);
    }
}