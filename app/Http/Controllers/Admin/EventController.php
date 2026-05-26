<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // READ: Tampilkan daftar event dengan pagination
    public function index()
    {
        $events = Event::with('category')
            ->latest()
            ->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    // CREATE: Tampilkan form tambah event
    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    // STORE: Simpan event baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster_path'] = $request->file('poster')->store('posters', 'cloud');
        }

        Event::create($validated);
        return redirect()->route('admin.events.index')->with('success', '✅ Event berhasil ditambahkan!');
    }


    // SHOW: Tampilkan detail event (opsional untuk admin)
    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    // EDIT: Tampilkan form edit event
    public function edit(Event $event)
    {
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    // UPDATE: Perbarui data event
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            if ($event->poster_path) {
                Storage::disk('cloud')->delete($event->poster_path);
            }
            $validated['poster_path'] = $request->file('poster')->store('posters', 'cloud');
        }

        $event->update($validated);
        return redirect()->route('admin.events.index')->with('success', '✅ Event berhasil diperbarui!');
    }

    // DELETE: Hapus event
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', '🗑️ Event berhasil dihapus!');
    }
}
