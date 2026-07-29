<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    // Tampilkan daftar semua partner
    public function index(Request $request)
    {
        $query = Partner::with('user');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $partners = $query->latest()->paginate(15);
        
        // Statistik
        $stats = [
            'total' => Partner::count(),
            'pending' => Partner::where('status', 'pending')->count(),
            'approved' => Partner::where('status', 'approved')->count(),
            'rejected' => Partner::where('status', 'rejected')->count(),
        ];
        
        return view('superadmin.partners.index', compact('partners', 'stats'));
    }

    // Setujui partner
    public function approve($id)
    {
        $partner = Partner::findOrFail($id);
        
        if ($partner->status === 'approved') {
            return back()->with('info', 'Partner sudah disetujui sebelumnya.');
        }
        
        $partner->update(['status' => 'approved']);
        
        return back()->with('success', "Partner '{$partner->name}' berhasil disetujui dan dapat membuat event!");
    }

    // Tolak partner
    public function reject($id)
    {
        $partner = Partner::findOrFail($id);
        
        if ($partner->status === 'rejected') {
            return back()->with('info', 'Partner sudah ditolak sebelumnya.');
        }
        
        $partner->update(['status' => 'rejected']);
        
        return back()->with('success', "Partner '{$partner->name}' ditolak.");
    }

    // Hapus partner
    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        
        // Cek apakah partner punya event
        if ($partner->events()->count() > 0) {
            return back()->with('error', 'Tidak bisa menghapus partner yang masih memiliki event!');
        }
        
        // Hapus user yang terkait (opsional, hati-hati)
        // $partner->user->delete(); 
        
        $partner->delete();
        
        return redirect()->route('superadmin.partners.index')
            ->with('success', 'Partner berhasil dihapus!');
    }

    // Lihat detail partner
    public function show($id)
    {
        $partner = Partner::with(['user', 'events.category'])->findOrFail($id);
        return view('superadmin.partners.show', compact('partner'));
    }
}