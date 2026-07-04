@extends('layouts.admin')

@section('title', 'Manajemen Kategori Peta')

@section('content')
<div class="space-y-4">
    <div class="flex items-center space-x-2">
        <a href="{{ route('manajemen.konten') }}" class="text-xs text-gray-400 hover:text-blue-600 transition">&larr; Kembali ke Manajemen Konten</a>
    </div>

    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-tight">Manajemen Kategori Peta</h2>
        <p class="text-xs text-gray-500">Kelola kategori dataset spasial yang tersedia pada portal.</p>
    </div>

    <div class="flex justify-between items-center bg-white p-3 rounded-xl border border-gray-100 shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
        <div class="relative w-64">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" placeholder="Cari kategori..."
                class="w-full pl-9 pr-4 py-1.5 text-xs border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400">
        </div>

        <a href="{{ route('manajemen.konten.kategori.create') }}"
           class="bg-[#008cf8] hover:bg-[#007ee0] text-white px-3.5 py-1.5 rounded-lg text-xs font-semibold inline-flex items-center space-x-1.5 transition shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Kategori</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-[10px] font-bold uppercase tracking-wider text-gray-400 bg-white">
                        <th class="py-3 px-5">Nama Kategori</th>
                        <th class="py-3 px-5">Jumlah Mapset Terkait</th>
                        <th class="py-3 px-5">Tanggal Dibuat</th>
                        <th class="py-3 px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-gray-600 text-[11px] font-medium">
                    @forelse($kategoris as $kategori)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="py-3 px-5 text-gray-900 font-semibold">
                            {{ $kategori->nama_kategori }}
                        </td>
                        <td class="py-3 px-5 text-gray-500 font-mono">
                            {{ $kategori->maps_count }} dataset
                        </td>
                        <td class="py-3 px-5 text-gray-400">
                            {{ $kategori->created_at ? $kategori->created_at->format('d M Y H:i') : '-' }}
                        </td>
                        <td class="py-3 px-5 flex items-center justify-center space-x-2">
                            <a href="{{ route('manajemen.konten.kategori.edit', $kategori->id) }}"
                               class="text-blue-600 hover:text-blue-800 text-xs font-semibold">Edit</a>
                            <span class="text-gray-300">|</span>
                            <form action="{{ route('manajemen.konten.kategori.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-400 text-xs">
                            Belum ada kategori yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-3 border-t border-gray-50 flex items-center justify-end space-x-6 text-[11px] text-gray-500 font-medium bg-white">
            <div>Halaman {{ $kategoris->currentPage() }} dari {{ $kategoris->lastPage() }}</div>
            <div class="flex space-x-1">
                <a href="{{ $kategoris->url(1) }}" class="p-1 border border-gray-200 rounded hover:bg-gray-50 text-gray-400 px-2 text-[9px]">&lt;&lt;</a>
                <a href="{{ $kategoris->previousPageUrl() ?? '#' }}" class="p-1 border border-gray-200 rounded hover:bg-gray-50 text-gray-400 px-2 text-[9px]">&lt;</a>
                <a href="{{ $kategoris->nextPageUrl() ?? '#' }}" class="p-1 border border-gray-200 rounded hover:bg-gray-50 text-gray-400 px-2 text-[9px]">&gt;</a>
                <a href="{{ $kategoris->url($kategoris->lastPage()) }}" class="p-1 border border-gray-200 rounded hover:bg-gray-50 text-gray-400 px-2 text-[9px]">&gt;&gt;</a>
            </div>
        </div>
    </div>
</div>
@endsection
