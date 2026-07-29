<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class OrganizerController extends Controller
{
    // Tampilkan daftar organizer
    public function index(Request $request)
    {
        $query = User::where('role', 'organizer')
            ->with('partner');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $organizers = $query->latest()->paginate(15);
        
        return view('admin.organizers.index', compact('organizers'));
    }

    // Tambah organizer baru
    public function create()
    {
        return view('admin.organizers.create');
    }

    // Simpan organizer baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'organization_name' => 'required|string|max:255',
            'organization_description' => 'nullable|string',
        ]);

        // Buat user organizer
        $organizer = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'organizer',
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'],
        ]);

        // Buat partner/organisasi
        Partner::create([
            'name' => $validated['organization_name'],
            'description' => $validated['organization_description'] ?? null,
            'user_id' => $organizer->id,
            'status' => 'approved', // Auto approved untuk admin yang membuat
        ]);

        // Update partner_id di user
        $organizer->update(['partner_id' => $organizer->partner->id]);

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Organizer berhasil ditambahkan!');
    }

    // Edit organizer
    public function edit($id)
    {
        $organizer = User::where('role', 'organizer')->findOrFail($id);
        return view('admin.organizers.edit', compact('organizer'));
    }

    // Update organizer
    public function update(Request $request, $id)
    {
        $organizer = User::where('role', 'organizer')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|confirmed|min:8',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'organization_name' => 'required|string|max:255',
            'organization_description' => 'nullable|string',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'],
        ];

        // Update password jika diisi
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $organizer->update($updateData);

        // Update partner
        if ($organizer->partner) {
            $organizer->partner->update([
                'name' => $validated['organization_name'],
                'description' => $validated['organization_description'] ?? null,
            ]);
        }

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Organizer berhasil diperbarui!');
    }

    // Hapus organizer
    public function destroy($id)
    {
        $organizer = User::where('role', 'organizer')->findOrFail($id);
        
        // Hapus partner terlebih dahulu
        if ($organizer->partner) {
            $organizer->partner->delete();
        }
        
        $organizer->delete();
        
        return redirect()->route('admin.organizers.index')
            ->with('success', 'Organizer berhasil dihapus!');
    }
}