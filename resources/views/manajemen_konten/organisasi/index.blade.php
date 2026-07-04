@extends('layouts.admin')

@section('title', 'Manajemen Organisasi / OPD')

@section('content')
<div class="space-y-4">
    <div class="flex items-center space-x-2">
        <a href="{{ route('manajemen.konten') }}" class="text-xs text-gray-400 hover:text-blue-600 transition">&larr; Kembali ke Manajemen Konten</a>
    </div>

    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-tight">Manajemen Organisasi / OPD</h2>
        <p class="text-xs text-gray-500">Kelola Organisasi Perangkat Daerah yang menyuplai data spasial.</p>
    </div>

    <div class="flex justify-between items-center bg-white p-3 rounded-xl border border-gray-100 shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
        <div class="relative w-64">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" placeholder="Cari organisasi..."
                class="w-full pl-9 pr-4 py-1.5 text-xs border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400">
        </div>

        <a href="{{ route('manajemen.konten.organisasi.create') }}"
           class="bg-[#008cf8] hover:bg-[#007ee0] text-white px-3.5 py-1.5 rounded-lg text-xs font-semibold inline-flex items-center space-x-1.5 transition shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Organisasi</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-[10px] font-bold uppercase tracking-wider text-gray-400 bg-white">
                        <th class="py-3 px-5">Nama Organisasi</th>
                        <th class="py-3 px-5">Email</th>
                        <th class="py-3 px-5">Telepon</th>
                        <th class="py-3 px-5">Website</th>
                        <th class="py-3 px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-gray-600 text-[11px] font-medium">
                    @forelse($organisasis as $org)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="py-3 px-5 text-gray-900 font-semibold max-w-xs truncate">
                            {{ $org->nama }}
                        </td>
                        <td class="py-3 px-5 text-gray-500">
                            {{ $org->email ?? '-' }}
                        </td>
                        <td class="py-3 px-5 text-gray-500">
                            {{ $org->telepon ?? '-' }}
                        </td>
                        <td class="py-3 px-5 text-blue-600">
                            @if($org->website)
                                <a href="{{ $org->website }}" target="_blank" class="hover:underline">{{ $org->website }}</a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="py-3 px-5 flex items-center justify-center space-x-2">
                            <a href="{{ route('manajemen.konten.organisasi.edit', $org->id) }}"
                               class="text-blue-600 hover:text-blue-800 text-xs font-semibold">Edit</a>
                            <span class="text-gray-300">|</span>
                            <form action="{{ route('manajemen.konten.organisasi.destroy', $org->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus organisasi ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-400 text-xs">
                            Belum ada organisasi yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-3 border-t border-gray-50 flex items-center justify-end space-x-6 text-[11px] text-gray-500 font-medium bg-white">
            <div>Halaman {{ $organisasis->currentPage() }} dari {{ $organisasis->lastPage() }}</div>
            <div class="flex space-x-1">
                <a href="{{ $organisasis->url(1) }}" class="p-1 border border-gray-200 rounded hover:bg-gray-50 text-gray-400 px-2 text-[9px]">&lt;&lt;</a>
                <a href="{{ $organisasis->previousPageUrl() ?? '#' }}" class="p-1 border border-gray-200 rounded hover:bg-gray-50 text-gray-400 px-2 text-[9px]">&lt;</a>
                <a href="{{ $organisasis->nextPageUrl() ?? '#' }}" class="p-1 border border-gray-200 rounded hover:bg-gray-50 text-gray-400 px-2 text-[9px]">&gt;</a>
                <a href="{{ $organisasis->url($organisasis->lastPage()) }}" class="p-1 border border-gray-200 rounded hover:bg-gray-50 text-gray-400 px-2 text-[9px]">&gt;&gt;</a>
            </div>
        </div>
    </div>
</div>
@endsection
