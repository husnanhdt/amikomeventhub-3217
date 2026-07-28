@extends('layouts.organizer')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <div class="mb-8">
        <a href="{{ route('organizer.dashboard') }}" class="text-indigo-600 hover:underline flex items-center gap-2 mb-4">
            ← Kembali ke Dashboard
        </a>
        <h1 class="text-3xl font-bold text-slate-900">Buat Event Baru</h1>
        <p class="text-slate-500">Isi detail acara Anda di bawah ini.</p>
    </div>

<!-- Tampilkan Error Validation -->
@if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700 font-bold">Ada kesalahan dalam pengisian form:</p>
                <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

    <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 space-y-6">
        @csrf

        <!-- Judul Event -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Event</label>
            <input type="text" name="title" value="{{ old('title') }}" required 
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Kategori -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
            <select name="category_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Deskripsi -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Acara</label>
            <textarea name="description" rows="4" required 
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">{{ old('description') }}</textarea>
        </div>

        <!-- Tanggal & Lokasi (Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Mulai</label>
                <input type="datetime-local" name="date" value="{{ old('date') }}" required 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Selesai (Opsional)</label>
                <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi Acara</label>
            <input type="text" name="location" value="{{ old('location') }}" required placeholder="Contoh: Gedung Serbaguna Amikom"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
        </div>

        <!-- Harga & Stok (Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Harga Tiket (Rp)</label>
                <input type="number" name="price" value="{{ old('price') }}" required min="0" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kuota / Stok Tiket</label>
                <input type="number" name="stock" value="{{ old('stock') }}" required min="1" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
            </div>
        </div>

        <!-- Upload Poster -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Poster Event (Opsional)</label>
            <input type="file" name="poster" accept="image/*" 
                class="w-full px-4 py-3 rounded-xl border border-slate-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
            @error('poster') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Tombol Submit -->
        <div class="pt-4 flex gap-4">
            <a href="{{ route('organizer.dashboard') }}" class="flex-1 px-6 py-4 border-2 border-slate-200 text-slate-700 rounded-xl font-bold text-center hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="flex-1 px-6 py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                Simpan Event
            </button>
        </div>
    </form>
</div>
@endsection