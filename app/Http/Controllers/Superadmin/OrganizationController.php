<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    // Tampilkan daftar semua organisasi
    public function index(Request $request)
    {
        $query = Partner::with(['user', 'events']);

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
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

        $organizations = $query->latest()->paginate(15);
        
        // Statistik
        $stats = [
            'total' => Partner::count(),
            'pending' => Partner::where('status', 'pending')->count(),
            'approved' => Partner::where('status', 'approved')->count(),
            'rejected' => Partner::where('status', 'rejected')->count(),
            'total_events' => Event::count(),
        ];
        
        return view('superadmin.organizations.index', compact('organizations', 'stats'));
    }

    // Setujui organisasi
    public function approve($id)
    {
        $partner = Partner::findOrFail($id);
        
        if ($partner->status === 'approved') {
            return back()->with('info', 'Organisasi sudah disetujui sebelumnya.');
        }
        
        $partner->update(['status' => 'approved']);
        
        return back()->with('success', "Organisasi '{$partner->name}' berhasil disetujui dan dapat membuat event!");
    }

    // Tolak organisasi
    public function reject(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);
        
        if ($partner->status === 'rejected') {
            return back()->with('info', 'Organisasi sudah ditolak sebelumnya.');
        }
        
        // Opsional: simpan alasan penolakan
        $rejectionReason = $request->input('rejection_reason');
        
        $partner->update([
            'status' => 'rejected',
            // 'rejection_reason' => $rejectionReason, // jika ada kolom ini
        ]);
        
        return back()->with('success', "Organisasi '{$partner->name}' ditolak.");
    }

    // Lihat detail organisasi
    public function show($id)
    {
        $partner = Partner::with(['user', 'events.category', 'events.transactions'])->findOrFail($id);
        
        // Statistik organisasi
        $stats = [
            'total_events' => $partner->events()->count(),
            'total_tickets_sold' => $partner->events()->withCount('transactions')->get()->sum('transactions_count'),
            'total_revenue' => $partner->events()->with('transactions')->get()->sum(function($event) {
                return $event->transactions()->whereIn('status', ['success', 'paid', 'settlement'])->sum('total_price');
            }),
        ];
        
        return view('superadmin.organizations.show', compact('partner', 'stats'));
    }

    // Edit organisasi
    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        return view('superadmin.organizations.edit', compact('partner'));
    }

    // Update organisasi
    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $partner->update($validated);
        
        return redirect()->route('superadmin.organizations.show', $partner->id)
            ->with('success', 'Data organisasi berhasil diperbarui!');
    }

    // Hapus organisasi
    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        
        // Cek apakah ada event
        if ($partner->events()->count() > 0) {
            return back()->with('error', 'Tidak bisa menghapus organisasi yang masih memiliki event!');
        }
        
        // Hapus user yang terkait
        if ($partner->user) {
            $partner->user->delete();
        }
        
        $partner->delete();
        
        return redirect()->route('superadmin.organizations.index')
            ->with('success', 'Organisasi berhasil dihapus!');
    }

    // Export laporan organisasi
    public function export()
    {
        // Implementasi export nanti
        return back()->with('info', 'Fitur export akan segera hadir');
    }
}