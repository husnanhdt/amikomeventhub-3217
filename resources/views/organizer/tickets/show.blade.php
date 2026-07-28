@extends('layouts.organizer')

@section('page_title', 'Daftar Peserta - ' . $event->title)
@section('page_subtitle', 'Kelola peserta yang telah membeli tiket')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <div>
            <h3 class="text-xl font-bold text-slate-900">{{ $event->title }}</h3>
            <p class="text-sm text-slate-500">{{ $transactions->total() }} Peserta Terdaftar</p>
        </div>
        <a href="{{ route('organizer.tickets.index') }}" class="text-indigo-600 font-bold hover:underline text-sm">
            ← Kembali
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold">
                <tr>
                    <th class="px-6 py-4">Nama Peserta</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">No. WhatsApp</th>
                    <th class="px-6 py-4">Jumlah Tiket</th>
                    <th class="px-6 py-4">Tanggal Beli</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($transactions as $trx)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $trx->customer_name }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $trx->customer_email }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $trx->customer_phone ?? '-' }}</td>
                    <td class="px-6 py-4 font-bold text-indigo-600">{{ $trx->quantity ?? 1 }}</td>
                    <td class="px-6 py-4 text-sm text-slate-500">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                        Belum ada peserta yang membeli tiket.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transactions->hasPages())
    <div class="p-6 border-t border-slate-100">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection