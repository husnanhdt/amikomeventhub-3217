<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Tampilkan halaman profil
    public function index()
    {
        $user = Auth::user();
        $partner = $user->partner; // Mengambil data organisasi yang terhubung

        return view('organizer.profile', compact('user', 'partner'));
    }

    // Update data profil
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'partner_name' => 'nullable|string|max:255',
            'partner_description' => 'nullable|string',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        // Update data User
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update data Partner/Organisasi (jika ada)
        if ($user->partner) {
            $user->partner->update([
                'name' => $request->partner_name,
                'description' => $request->partner_description,
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}