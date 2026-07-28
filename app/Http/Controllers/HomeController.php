<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Partner; // ← Import model Partner
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kategori untuk filter
        $categories = Category::all();

        // Ambil events dengan filter kategori jika ada
        $query = Event::with('category')->where('date', '>=', now());

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $events = $query->orderBy('date', 'asc')->take(100)->get(); // Atau paginate

        // ✅ PASTIKAN INI ADA
        $categories = Category::all();
        $partners = Partner::orderBy('created_at', 'desc')->get();

        return view('welcome', compact('events', 'categories', 'partners'));
    }
}
