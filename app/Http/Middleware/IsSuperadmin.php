<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSuperadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan memiliki role superadmin
        if (!auth()->check() || auth()->user()->role !== 'superadmin') {
            abort(403, 'Akses ditolak. Hanya Superadmin yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}