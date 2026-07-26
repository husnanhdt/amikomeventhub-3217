<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }
        // Jika bukan admin, lempar kembali ke login dengan pesan error
        return redirect()->route('admin.login')->with('error', 'Anda tidak memiliki akses sebagai Admin.');
    }
}