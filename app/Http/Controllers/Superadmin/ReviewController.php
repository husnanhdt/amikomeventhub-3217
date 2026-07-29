<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Tampilkan daftar semua review
    public function index(Request $request)
    {
        $query = Review::with(['user', 'event']);

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('event', function($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%");
                  });
            });
        }

        // Filter rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter status moderasi
        if ($request->filled('status')) {
            $query->where('is_approved', $request->status === 'approved');
        }

        $reviews = $query->latest()->paginate(15);
        
        // Statistik
        $stats = [
            'total' => Review::count(),
            'approved' => Review::where('is_approved', true)->count(),
            'pending' => Review::where('is_approved', false)->count(),
            'average_rating' => Review::avg('rating'),
            'five_star' => Review::where('rating', 5)->count(),
            'one_star' => Review::where('rating', 1)->count(),
        ];
        
        return view('superadmin.reviews.index', compact('reviews', 'stats'));
    }

    // Setujui review
    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => true]);
        
        return back()->with('success', 'Review berhasil disetujui dan ditampilkan!');
    }

    // Tolak review (hapus dari tampilan publik)
    public function reject($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => false]);
        
        return back()->with('success', 'Review ditolak dan disembunyikan dari publik.');
    }

    // Hapus review permanen
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        
        return back()->with('success', 'Review berhasil dihapus permanen!');
    }

    // Lihat detail review
    public function show($id)
    {
        $review = Review::with(['user', 'event.partner', 'event.category'])->findOrFail($id);
        return view('superadmin.reviews.show', compact('review'));
    }

    // Bulk action (setujui/tolak banyak review sekaligus)
    public function bulkAction(Request $request)
    {
        $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id',
            'action' => 'required|in:approve,reject,delete'
        ]);

        $reviewIds = $request->review_ids;
        $action = $request->action;

        if ($action === 'approve') {
            Review::whereIn('id', $reviewIds)->update(['is_approved' => true]);
            $message = count($reviewIds) . ' review berhasil disetujui!';
        } elseif ($action === 'reject') {
            Review::whereIn('id', $reviewIds)->update(['is_approved' => false]);
            $message = count($reviewIds) . ' review ditolak!';
        } elseif ($action === 'delete') {
            Review::whereIn('id', $reviewIds)->delete();
            $message = count($reviewIds) . ' review berhasil dihapus!';
        }

        return back()->with('success', $message);
    }

    // Export review
    public function export()
    {
        $reviews = Review::with(['user', 'event'])->latest()->get();
        
        // Implementasi export ke Excel/CSV nanti
        return back()->with('info', 'Fitur export akan segera hadir');
    }
}