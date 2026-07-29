<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Ditambahkan untuk hapus file poster nanti

class EventController extends Controller
{
    // 1. Menampilkan daftar event (DITAMBAH: Search, Filter, Pagination)
    public function index(Request $request)
{
    $user = Auth::user();
    $partner = $user->partner; // ✅ Ambil relasi partner
    
    // ✅ CEK: Apakah organizer sudah approved?
    if (!$partner || $partner->status !== 'approved') {
        return redirect()->route('home')
            ->with('error', 'Akun organizer Anda belum disetujui. Tunggu persetujuan dari superadmin.');
    }
    
    $partnerId = $user->partner_id;

    // Query dasar: hanya event milik organizer yang login
    $query = Event::where('partner_id', $partnerId);

    // ✅ Fitur Search
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // ✅ Fitur Filter Kategori
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    // Load relasi & pagination (menggantikan ->get() agar bisa pakai pagination)
    $events = $query->with('category')
        ->latest()
        ->paginate(10);

    // Ambil semua kategori untuk dropdown filter
    $categories = Category::all();
    
    return view('organizer.events.index', compact('events', 'categories'));
}

    // 2. Menampilkan form buat event baru
    public function create()
    {
        $categories = Category::all();
        return view('organizer.events.create', compact('categories'));
    }

    // 3. Menyimpan event baru ke database (LOGIKA ASLI ANDA DIPERTAHANKAN 100%)
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // Handle upload poster jika ada
        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        // Buat event baru (PENTING: partner_id diambil dari user yang login)
        Event::create([
            'partner_id' => $user->partner_id, 
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'end_date' => $validated['end_date'] ?? $validated['date'], // Fallback ke tanggal mulai jika kosong
            'location' => $validated['location'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'poster_path' => $posterPath,
        ]);

        // ✅ Diubah redirect ke events.index agar user langsung melihat event barunya di daftar
        return redirect()->route('organizer.events.index')->with('success', 'Event berhasil dibuat dan siap dijual!');
    }

    // 4. Menampilkan form edit event (BARU)
    public function edit($id)
    {
        $user = Auth::user();
        // Pastikan event yang diedit adalah milik organizer yang login (Keamanan)
        $event = Event::where('partner_id', $user->partner_id)->findOrFail($id);
        $categories = Category::all();
        
        return view('organizer.events.edit', compact('event', 'categories'));
    }

    // 5. Mengupdate event (BARU)
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $event = Event::where('partner_id', $user->partner_id)->findOrFail($id);

        // Validasi input (sama seperti store)
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle upload poster baru jika ada (pakai yang lama jika tidak diupload)
        $posterPath = $event->poster_path;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        // Update data event
        $event->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'end_date' => $validated['end_date'] ?? $validated['date'],
            'location' => $validated['location'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'poster_path' => $posterPath,
        ]);

        return redirect()->route('organizer.events.index')->with('success', 'Event berhasil diperbarui!');
    }

    // 6. Menghapus event (BARU)
    public function destroy($id)
    {
        $user = Auth::user();
        // Pastikan event yang dihapus adalah milik organizer yang login (Keamanan)
        $event = Event::where('partner_id', $user->partner_id)->findOrFail($id);
        
        // Opsional: Hapus file poster dari storage agar tidak menumpuk
        if ($event->poster_path) {
            Storage::disk('public')->delete($event->poster_path);
        }

        $event->delete();

        return redirect()->route('organizer.events.index')->with('success', 'Event berhasil dihapus.');
    }
}