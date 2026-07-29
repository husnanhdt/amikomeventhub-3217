<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Partner; // ✅ PENTING: Tambahkan ini agar bisa membuat data Partner
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // 1. Validasi input 
        // ✅ PERBAIKAN: account_type dan organization dibuat nullable agar form user biasa tidak ditolak
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'password' => 'required|string|min:8|confirmed',
            
            // ✅ UBAH DARI 'required' MENJADI 'nullable'
            'account_type' => 'nullable|in:user,organizer',
            'organization_name' => 'nullable|string|max:255',
            'organization_description' => 'nullable|string',
        ]);

        // 2. Tentukan role (default 'user' jika account_type kosong/null)
        $accountType = $request->input('account_type', 'user');

        // 3. Buat user baru (Logika asli kamu dipertahankan)
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'], 
            'password' => Hash::make($validated['password']),
            
            // ✅ Role ditentukan berdasarkan pilihan
            'role' => $accountType === 'organizer' ? 'organizer' : 'user',
        ]);

        // 4. Jika daftar sebagai organizer, buat data Partner (Organisasi) baru
        if ($accountType === 'organizer' && !empty($validated['organization_name'])) {
            $partner = Partner::create([
                'name' => $validated['organization_name'],
                'description' => $validated['organization_description'] ?? null,
                'user_id' => $user->id,
                'status' => 'pending', // Menunggu approval superadmin
            ]);

            // ✅ Assign partner_id ke user yang baru dibuat
            $user->update(['partner_id' => $partner->id]);
        }

        // 5. Login user secara otomatis setelah registrasi
        Auth::login($user);

        // 6. Redirect berdasarkan role
        if ($user->role === 'organizer') {
            return redirect('/organizer/dashboard')->with('success', 'Akun organizer berhasil dibuat! Menunggu approval superadmin.');
        }

        // Default untuk user biasa
        return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang di AmikomEventHub.');
    }
}