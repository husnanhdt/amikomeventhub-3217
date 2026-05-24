@extends('layouts.admin')

@section('title', 'Edit Partner - Admin')
@section('page_title', 'Edit Partner')
@section('page_subtitle', 'Ubah informasi partner.')

@section('content')
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-8 max-w-3xl mx-auto">
        <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama Partner</label>
                <input type="text" name="name" value="{{ old('name', $partner->name) }}"
                    placeholder="Contoh: Gojek, Tokopedia, Dicoding"
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                    required>
                @error('name')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Upload Logo Partner</label>

                <!-- Preview Logo Lama -->
                @if($partner->logo)
                <div class="mb-4">
                    <p class="text-xs text-slate-500 mb-2">Logo saat ini:</p>
                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}"
                        class="w-32 h-32 object-cover rounded-xl border-2 border-slate-100">
                </div>
                @endif

                <input type="file" name="logo" accept="image/*"
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium">
                @error('logo')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
                <p class="text-xs text-slate-400 mt-2">Kosongkan jika tidak ingin mengubah logo. Format: PNG, JPG, JPEG (Max 2MB)</p>
            </div>

            <div class="pt-6 flex justify-end gap-4 border-t border-slate-100">
                <a href="{{ route('admin.partners.index') }}"
                    class="px-6 py-3 text-slate-500 font-bold hover:text-slate-800 transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-8 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection