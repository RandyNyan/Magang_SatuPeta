@extends('layouts.admin')

@section('title', 'Tambah Kategori Peta')

@section('content')
<div class="space-y-6 max-w-md mx-auto bg-white p-6 rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
    <div class="flex items-center space-x-2">
        <a href="{{ route('manajemen.konten.kategori') }}" class="text-xs text-gray-400 hover:text-blue-600 transition">&larr; Kembali ke daftar</a>
    </div>

    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-tight">Tambah Kategori Baru</h2>
        <p class="text-xs text-gray-500">Tuliskan nama kategori baru yang akan didaftarkan.</p>
    </div>

    <form action="{{ route('manajemen.konten.kategori.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="nama_kategori" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" required placeholder="Contoh: Kependudukan, Batas Wilayah, Kebencanaan" value="{{ old('nama_kategori') }}"
                   class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
            @error('nama_kategori')
                <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-[#008cf8] hover:bg-[#007ee0] text-white py-2 rounded-lg text-xs font-bold shadow-sm transition">
                Simpan Kategori
            </button>
        </div>
    </form>
</div>
@endsection
