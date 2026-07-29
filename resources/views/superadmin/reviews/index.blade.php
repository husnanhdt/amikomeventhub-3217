@extends('layouts.superadmin')

@section('title', 'Kelola Review')
@section('page_title', 'Moderasi Review & Ulasan')
@section('page_subtitle', 'Pantau dan moderasi semua ulasan dari pengguna')

@section('content')

<!-- Alert Messages -->
@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl mb-6 flex items-center shadow-sm">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
    <span class="font-medium">{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 flex items-center shadow-sm">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
    </svg>
    <span class="font-medium">{{ session('error') }}</span>
</div>
@endif

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium mb-1">Total Review</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $stats['total'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium mb-1">Menunggu Moderasi</p>
                <h3 class="text-3xl font-bold text-orange-600">{{ $stats['pending'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium mb-1">Rating Rata-rata</p>
                <h3 class="text-3xl font-bold text-indigo-600">{{ number_format($stats['average_rating'], 1) }}</h3>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium mb-1">Disetujui</p>
                <h3 class="text-3xl font-bold text-green-600">{{ $stats['approved'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Action Form -->
<form action="{{ route('superadmin.reviews.bulk-action') }}" method="POST" id="bulkActionForm">
    @csrf

    <!-- Table Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

        <!-- Search & Filter -->
        <div class="px-6 py-4 border-b border-slate-100 flex flex-wrap gap-4 items-center justify-between">
            <form method="GET" action="{{ route('superadmin.reviews.index') }}" class="flex-1 min-w-[300px] flex gap-2">
                <input type="text" name="search" placeholder="Cari review, nama pengguna, event..."
                    value="{{ request('search') }}"
                    class="flex-1 px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700">
                    Cari
                </button>
            </form>

            <div class="flex gap-2">
                <select name="rating_filter"
                    data-base="{{ route('superadmin.reviews.index') }}"
                    onchange="if(this.value) window.location.href=this.dataset.base+'?rating='+this.value"
                    class="px-4 py-2 rounded-xl border border-slate-200 text-sm font-medium">
                    <option value="">Semua Rating</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5)</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4)</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ (3)</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>⭐⭐ (2)</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>⭐ (1)</option>
                </select>

                <select data-base="{{ route('superadmin.reviews.index') }}"
                    onchange="if(this.value) window.location.href=this.dataset.base+'?status='+this.value"
                    class="px-4 py-2 rounded-xl border border-slate-200 text-sm font-medium">
                    <option value="">Semua Status</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                </select>
            </div>
        </div>

        <!-- Bulk Action Bar -->
        <div class="px-6 py-3 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <input type="checkbox" id="selectAll" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <label for="selectAll" class="text-sm font-medium text-slate-700">Pilih Semua</label>
                <span id="selectedCount" class="text-sm text-slate-500 hidden">(0 dipilih)</span>
            </div>

            <div class="flex gap-2" id="bulkActions" style="display: none;">
                <select name="action" class="px-3 py-1.5 rounded-lg border border-slate-300 text-sm">
                    <option value="approve">Setujui</option>
                    <option value="reject">Tolak</option>
                    <option value="delete">Hapus</option>
                </select>
                <button type="submit" class="px-4 py-1.5 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700">
                    Terapkan
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4 w-10"></th>
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4">Rating</th>
                        <th class="px-6 py-4">Ulasan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <input type="checkbox" name="review_ids[]" value="{{ $review->id }}" class="review-checkbox w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <span class="text-indigo-600 font-bold">{{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}</span>
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-800">{{ $review->user->name ?? 'Unknown' }}</div>
                                    <div class="text-xs text-slate-500">{{ $review->user->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-800">{{ Str::limit($review->event->title ?? '-', 30) }}</div>
                            <div class="text-xs text-slate-500">{{ $review->event->partner->name ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-slate-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                    </svg>
                                    @endfor
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-700 line-clamp-2">{{ Str::limit($review->comment, 80) }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($review->is_approved)
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Disetujui</span>
                            @else
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold">Menunggu</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $review->created_at->format('d M Y') }}<br>
                            <span class="text-xs">{{ $review->created_at->format('H:i') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('superadmin.reviews.show', $review->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>

                                @if(!$review->is_approved)
                                <form action="{{ route('superadmin.reviews.approve', $review->id) }}" method="POST" onsubmit="return confirm('Setujui review ini?')">
                                    @csrf
                                    <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition" title="Setujui">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('superadmin.reviews.reject', $review->id) }}" method="POST" onsubmit="return confirm('Tolak review ini?')">
                                    @csrf
                                    <button type="submit" class="p-2 text-orange-600 hover:bg-orange-50 rounded-lg transition" title="Tolak">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('superadmin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus review ini secara permanen?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-slate-500">
                            Belum ada review
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $reviews->links() }}
        </div>
    </div>
</form>

<!-- JavaScript untuk Bulk Selection -->
<script>
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.review-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateSelectedCount();
    });

    document.querySelectorAll('.review-checkbox').forEach(cb => {
        cb.addEventListener('change', updateSelectedCount);
    });

    function updateSelectedCount() {
        const checked = document.querySelectorAll('.review-checkbox:checked').length;
        const countSpan = document.getElementById('selectedCount');
        const bulkActions = document.getElementById('bulkActions');

        if (checked > 0) {
            countSpan.textContent = `(${checked} dipilih)`;
            countSpan.classList.remove('hidden');
            bulkActions.style.display = 'flex';
        } else {
            countSpan.classList.add('hidden');
            bulkActions.style.display = 'none';
        }
    }
</script>

@endsection