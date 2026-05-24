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
        
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        $events = $query->latest()->get();
        
        // ✅ Ambil semua partner untuk ditampilkan di homepage
        $partners = Partner::latest()->get();
        
        return view('welcome', compact('events', 'categories', 'partners'));
    }
}