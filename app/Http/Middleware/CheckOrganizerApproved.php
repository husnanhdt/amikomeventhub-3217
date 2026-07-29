<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOrganizerApproved
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $partner = $user->partner;
        
        if (!$partner || $partner->status !== 'approved') {
            return redirect()->route('home')
                ->with('error', 'Akun organizer Anda belum disetujui. Tunggu persetujuan superadmin.');
        }
        
        return $next($request);
    }
}