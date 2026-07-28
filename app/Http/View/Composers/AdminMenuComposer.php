<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Review;

class AdminMenuComposer
{
    public function compose(View $view)
    {
        // Hitung jumlah ulasan baru (bisa disesuaikan dengan logika kamu)
        // Contoh: ulasan yang dibuat dalam 7 hari terakhir
        $newReviews = Review::where('created_at', '>=', now()->subDays(7))->count();
        
        // Atau jika mau hitung semua ulasan:
        // $newReviews = Review::count();
        
        $view->with('newReviewsCount', $newReviews);
    }
}