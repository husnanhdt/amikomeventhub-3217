<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // 1. Menampilkan daftar event milik organizer ini
    public function index()
    {
        $user = Auth::user();
        $events = Event::where('partner_id', $user->partner_id)->latest()->get();
        
        return view('organizer.events.index', compact('events'));
    }

    // 2. Menampilkan form buat event baru
    public function create()
    {
        $categories = Category::all();
        return view('organizer.events.create', compact('categories'));
    }

    // 3. Menyimpan event baru ke database
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

        return redirect()->route('organizer.dashboard')->with('success', 'Event berhasil dibuat dan siap dijual!');
    }
}