@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<div class="space-y-6 max-w-2xl mx-auto bg-white p-6 rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
    <div class="flex items-center space-x-2">
        <a href="{{ route('manajemen.konten.berita') }}" class="text-xs text-gray-400 hover:text-blue-600 transition">&larr; Kembali ke daftar</a>
    </div>

    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-tight">Edit Berita: {{ $berita->judul }}</h2>
        <p class="text-xs text-gray-500">Sesuaikan artikel berita atau detail publikasi.</p>
    </div>

    <form action="{{ route('manajemen.konten.berita.update', $berita->id) }}" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <label for="judul" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Judul Berita</label>
                <input type="text" name="judul" id="judul" required value="{{ old('judul', $berita->judul) }}"
                       class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                @error('judul')
                    <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="penulis" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Penulis</label>
                <input type="text" name="penulis" id="penulis" value="{{ old('penulis', $berita->penulis) }}"
                       class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                @error('penulis')
                    <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <label for="ringkasan" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Ringkasan / Abstrak</label>
            <textarea name="ringkasan" id="ringkasan" rows="2"
                      class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
            @error('ringkasan')
                <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="konten" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Konten Berita</label>
            <textarea name="konten" id="konten" rows="8" required
                      class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">{{ old('konten', $berita->konten) }}</textarea>
            @error('konten')
                <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-[#008cf8] hover:bg-[#007ee0] text-white py-2 rounded-lg text-xs font-bold shadow-sm transition">
                Perbarui Berita
            </button>
        </div>
    </form>
</div>
@endsection
