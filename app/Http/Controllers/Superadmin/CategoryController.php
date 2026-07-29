<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // 1. Tampilkan daftar kategori
    public function index(Request $request)
    {
        $query = Category::withCount('events');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->latest()->paginate(15);
        
        return view('superadmin.categories.index', compact('categories'));
    }

    // 2. Tampilkan form tambah kategori
    public function create()
    {
        return view('superadmin.categories.create');
    }

    // 3. Simpan kategori baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('superadmin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    // 4. Tampilkan form edit kategori
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('superadmin.categories.edit', compact('category'));
    }

    // 5. Update kategori
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('superadmin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    // 6. Hapus kategori
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Cek apakah ada event yang menggunakan kategori ini
        if ($category->events()->count() > 0) {
            return back()->with('error', 'Tidak bisa menghapus kategori yang masih digunakan oleh event!');
        }

        $category->delete();
        
        return redirect()->route('superadmin.categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}