@extends('layouts.admin')

@section('title', 'Tambah Organisasi')

@section('content')
<div class="space-y-6 max-w-lg mx-auto bg-white p-6 rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
    <div class="flex items-center space-x-2">
        <a href="{{ route('manajemen.konten.organisasi') }}" class="text-xs text-gray-400 hover:text-blue-600 transition">&larr; Kembali ke daftar</a>
    </div>

    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-tight">Tambah Organisasi Baru</h2>
        <p class="text-xs text-gray-500">Isi detail organisasi perangkat daerah penanggung jawab peta.</p>
    </div>

    <form action="{{ route('manajemen.konten.organisasi.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="nama" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Organisasi / OPD</label>
            <input type="text" name="nama" id="nama" required placeholder="Contoh: Dinas Komunikasi dan Informatika Provinsi Jawa Timur" value="{{ old('nama') }}"
                   class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
            @error('nama')
                <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="deskripsi" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
            <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Masukkan ringkasan tugas atau deskripsi organisasi..."
                      class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="alamat" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Alamat Kantor</label>
            <input type="text" name="alamat" id="alamat" placeholder="Contoh: Jl. Ahmad Yani No. 242-244, Surabaya" value="{{ old('alamat') }}"
                   class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
            @error('alamat')
                <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="telepon" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">No. Telepon / Fax</label>
                <input type="text" name="telepon" id="telepon" placeholder="Contoh: (031) 8294608" value="{{ old('telepon') }}"
                       class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                @error('telepon')
                    <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Email Resmi</label>
                <input type="email" name="email" id="email" placeholder="Contoh: info@diskominfo.jatimprov.go.id" value="{{ old('email') }}"
                       class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                @error('email')
                    <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <label for="website" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Website URL</label>
            <input type="url" name="website" id="website" placeholder="Contoh: https://diskominfo.jatimprov.go.id" value="{{ old('website') }}"
                   class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
            @error('website')
                <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-[#008cf8] hover:bg-[#007ee0] text-white py-2 rounded-lg text-xs font-bold shadow-sm transition">
                Simpan Organisasi
            </button>
        </div>
    </form>
</div>
@endsection
