<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Review;

class OrganizerController extends Controller
{
    public function show(Partner $partner)
    {
        // Debug: Cek partner yang diterima
        // dd($partner);
        
        $events = $partner->events()->latest()->get();
        
        $allReviews = Review::whereIn('event_id', $events->pluck('id'))
            ->with('user', 'event')
            ->whereNotNull('review_date')
            ->latest()
            ->get();

        $averageRating = $allReviews->avg('rating') ?? 0;
        $totalReviews = $allReviews->count();

        return view('organizer.show', compact(
            'partner', 
            'events', 
            'allReviews', 
            'averageRating', 
            'totalReviews'
        ));
    }
}