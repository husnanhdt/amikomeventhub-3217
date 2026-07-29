<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function create(Event $event)
    {
        if (!Auth::check()) {
            return redirect()->route('user.login')
                ->with('error', 'Silakan login untuk memberikan review');
        }

        if (!$event->canBeReviewed()) {
            return redirect()->route('events.show', $event->id)
                ->with('error', 'Review baru dapat diberikan 1 hari setelah acara selesai.');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasReviewedEvent($event->id)) {
            return redirect()->route('events.show', $event->id)
                ->with('error', 'Anda sudah memberikan review untuk acara ini.');
        }

        return view('reviews.create', compact('event'));
    }



    public function store(Request $request, Event $event)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'rating' => $request->rating,
            'review' => $request->review,
            'review_date' => Carbon::now(),
        ]);

        return redirect()->route('events.show', $event->id)
            ->with('success', 'Terima kasih! Review Anda telah tersimpan.');
    }

    public function index(Event $event)
    {
        $reviews = $event->reviews()
            ->with('user')
            ->whereNotNull('review_date')
            ->orderBy('review_date', 'desc')
            ->paginate(10);

        return view('reviews.index', compact('event', 'reviews'));
    }
}
