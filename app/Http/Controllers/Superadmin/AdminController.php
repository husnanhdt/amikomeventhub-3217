<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Tampilkan daftar semua pengurus (admin & manager)
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'superadmin']);

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $admins = $query->latest()->paginate(15);
        
        // Statistik
        $stats = [
            'total' => User::whereIn('role', ['admin', 'superadmin'])->count(),
            'superadmin' => User::where('role', 'superadmin')->count(),
            'admin' => User::where('role', 'admin')->count(),
        ];
        
        return view('superadmin.admins.index', compact('admins', 'stats'));
    }

    // Tambah pengurus baru
    public function create()
    {
        return view('superadmin.admins.create');
    }

    // Simpan pengurus baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:admin,superadmin',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'],
        ]);

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Pengurus berhasil ditambahkan!');
    }

    // Edit pengurus
    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('superadmin.admins.edit', compact('admin'));
    }

    // Update pengurus
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|confirmed|min:8',
            'role' => 'required|in:admin,superadmin',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'],
        ];

        // Update password jika diisi
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $admin->update($updateData);
        
        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Data pengurus berhasil diperbarui!');
    }

    // Hapus pengurus
    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        
        // Jangan izinkan hapus diri sendiri
        if ($admin->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }
        
        $admin->delete();
        
        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Pengurus berhasil dihapus!');
    }

    // Lihat detail pengurus
    public function show($id)
    {
        $admin = User::findOrFail($id);
        
        // Statistik aktivitas
        $stats = [
            'total_logins' => 0, // Bisa ditambahkan tracking login
            'last_login' => $admin->last_login_at ?? null,
        ];
        
        return view('superadmin.admins.show', compact('admin', 'stats'));
    }

    // Reset password pengurus
    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $admin = User::findOrFail($id);
        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil direset!');
    }
}