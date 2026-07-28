<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Menampilkan daftar semua ulasan
    public function index()
    {
        $reviews = Review::with(['user', 'event'])
            ->latest()
            ->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    // Menghapus ulasan (Moderasi)
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Ulasan berhasil dihapus.');
    }
}