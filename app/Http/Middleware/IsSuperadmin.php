<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsSuperadmin
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login dan role-nya adalah superadmin
        if (!Auth::check() || Auth::user()->role !== 'superadmin') {
            return redirect('/')->with('error', 'Akses ditolak. Halaman ini khusus untuk Superadmin.');
        }

        return $next($request);
    }
}