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
        // 1. Validasi input (termasuk field baru untuk organizer)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'password' => 'required|string|min:8|confirmed',
            
            // ✅ Validasi baru untuk fitur Multi-Tenant
            'account_type' => 'required|in:user,organizer',
            'organization_name' => 'required_if:account_type,organizer|string|max:255',
            'organization_description' => 'required_if:account_type,organizer|string',
        ]);

        // 2. Buat user baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'], // Sudah diformat YYYY-MM-DD oleh JavaScript di form
            'password' => Hash::make($validated['password']),
            
            // ✅ Role ditentukan berdasarkan pilihan di form
            'role' => $validated['account_type'] === 'organizer' ? 'organizer' : 'user',
        ]);

        // 3. Jika daftar sebagai organizer, buat data Partner (Organisasi) baru
        if ($validated['account_type'] === 'organizer') {
            $partner = Partner::create([
                'name' => $validated['organization_name'],
                'description' => $validated['organization_description'] ?? null,
                'status' => 'pending', // Menunggu approval superadmin
            ]);

            // ✅ Assign partner_id ke user yang baru dibuat
            $user->update(['partner_id' => $partner->id]);
        }

        // 4. Login user secara otomatis setelah registrasi
        Auth::login($user);

        // 5. Redirect berdasarkan role
        if ($user->role === 'organizer') {
            return redirect('/organizer/dashboard')->with('success', 'Akun organizer berhasil dibuat! Menunggu approval superadmin.');
        }

        // Default untuk user biasa
        return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang di AmikomEventHub.');
    }
}