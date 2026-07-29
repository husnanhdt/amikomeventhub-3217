<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ReviewController extends Controller
{
    public function index()
    {
        $partnerId = Auth::user()->partner_id;

        // 1. Ambil semua ID event milik partner (organizer) ini
        $eventIds = Event::where('partner_id', $partnerId)->pluck('id');

        // 2. Ambil review yang event_id-nya ada di dalam daftar event milik organizer ini
        $reviews = Review::whereIn('event_id', $eventIds)
            ->with(['user', 'event']) // Load relasi agar tidak terjadi N+1 query problem
            ->latest()
            ->paginate(15);

        // 3. Hitung statistik untuk ditampilkan di UI
        $averageRating = $reviews->count() > 0 ? $reviews->avg('rating') : 0;
        $totalReviews = $reviews->total(); // Menggunakan total() karena ini hasil paginate

        return view('organizer.reviews.index', compact('reviews', 'averageRating', 'totalReviews'));
    }
}