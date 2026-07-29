<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User; // ← TAMBAHKAN INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Jika ada file avatar baru yang diupload
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama JIKA itu adalah file lokal (bukan URL Google)
            if ($user->avatar && !str_starts_with($user->avatar, 'http')) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan avatar baru ke folder storage/app/public/avatars
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // Update nama
        $user->name = $request->name;
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui! 🎉');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi lama salah!']);
        }

        /** @var User $user */
        $user = Auth::user();

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Kata sandi berhasil diubah!');
    }
}
