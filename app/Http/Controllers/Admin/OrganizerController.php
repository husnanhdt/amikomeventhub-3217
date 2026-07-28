<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    // Menampilkan daftar organizer
    public function index()
    {
        $organizers = User::where('role', 'organizer')
            ->with('partner') 
            ->latest()
            ->paginate(10);

        return view('admin.organizers.index', compact('organizers'));
    }

    // Menampilkan form tambah organizer
    public function create()
    {
        return view('admin.organizers.create');
    }

    // Menyimpan organizer baru
    public function store(Request $request)
    {
        // Logic store nanti
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $organizer = User::where('role', 'organizer')->findOrFail($id);
        return view('admin.organizers.edit', compact('organizer'));
    }

    // Mengupdate organizer
    public function update(Request $request, $id)
    {
        // Logic update nanti
    }

    // Menghapus organizer
    public function destroy($id)
    {
        $organizer = User::where('role', 'organizer')->findOrFail($id);
        $organizer->delete();

        return redirect()->route('admin.organizers.index')->with('success', 'Organizer berhasil dihapus.');
    }
}