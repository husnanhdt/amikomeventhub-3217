<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsOrganizer
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login dan role-nya adalah organizer
        if (!Auth::check() || Auth::user()->role !== 'organizer') {
            // Jika bukan organizer, lempar ke home atau tampilkan error
            return redirect('/')->with('error', 'Akses ditolak. Halaman ini khusus untuk Organizer.');
        }

        return $next($request);
    }
}