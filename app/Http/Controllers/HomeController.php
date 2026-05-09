<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Event;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua kategori untuk tombol filter
        $categories = Category::all();

        // 2. Buat query dasar:
        //    - Eager Loading 'category' (hindari N+1 Query Problem)
        //    - Hanya event yang belum lewat (>= hari ini)
        //    - Urutkan dari yang paling dekat
        $query = Event::with('category')
            ->where('date', '>=', now())
            ->orderBy('date', 'asc');

        // 3. Filter jika URL mengandung ?category=slug
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 4. Eksekusi query & kirim ke view
        $events = $query->get();

        return view('welcome', compact('events', 'categories'));
    }
}