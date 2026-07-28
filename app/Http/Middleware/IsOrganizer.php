<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsOrganizer
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Izinkan jika role-nya organizer, admin, atau superadmin
        if ($user && in_array($user->role, ['organizer', 'admin', 'superadmin'])) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Akses ditolak. Anda bukan penyelenggara acara.');
    }
}
