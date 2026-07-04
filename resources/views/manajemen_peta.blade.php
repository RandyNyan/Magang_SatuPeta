@extends('layouts.admin')

@section('title', 'Manajemen Peta')

@section('content')
<div class="space-y-4">
    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-tight">Manajemen Peta</h2>
        <p class="text-xs text-gray-500">Kelola katalog mapset yang tersedia pada portal Smart Facility Map.</p>
    </div>

    <div class="flex justify-between items-center bg-white p-3 rounded-xl border border-gray-100 shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
        <div class="relative w-64">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" placeholder="Cari mapset..."
                class="w-full pl-9 pr-4 py-1.5 text-xs border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400">
        </div>

        <a href="{{ route('manajemen.peta.create') }}"
           class="bg-[#008cf8] hover:bg-[#007ee0] text-white px-3.5 py-1.5 rounded-lg text-xs font-semibold inline-flex items-center space-x-1.5 transition shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Mapset</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-[10px] font-bold uppercase tracking-wider text-gray-400 bg-white">
                        <th class="py-3 px-5">Judul Mapset</th>
                        <th class="py-3 px-5">Kategori</th>
                        <th class="py-3 px-5">Organisasi / OPD</th>
                        <th class="py-3 px-5">Tipe Geometri</th>
                        <th class="py-3 px-5">Sumber Layer</th>
                        <th class="py-3 px-5">Tahun Data</th>
                        <th class="py-3 px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-gray-600 text-[11px] font-medium">
                    @forelse($maps as $map)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="py-3 px-5 text-gray-900 font-semibold">
                             {{ $map->judul_mapset }}
                        </td>
                        <td class="py-3 px-5 text-gray-500">
                             {{ $map->kategori->nama_kategori ?? '-' }}
                        </td>
                        <td class="py-3 px-5 text-gray-500">
                             {{ $map->organisasi->nama ?? '-' }}
                        </td>
                        <td class="py-3 px-5">
                            <span class="px-2 py-0.5 border border-gray-200 bg-gray-50 rounded text-gray-600 text-[10px]">
                                {{ $map->tipe_layer }}
                            </span>
                        </td>
                        <td class="py-3 px-5">
                            @if($map->sumber_peta === 'pgsql')
                                @if($map->open_layer_id && $map->openLayer)
                                    <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-green-100 text-green-700">
                                        OL: {{ $map->openLayer->nama_layer }}
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-purple-100 text-purple-700">
                                        PGSQL: {{ $map->pgsql_table }}
                                    </span>
                                @endif
                            @else
                                <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-blue-100 text-blue-700">
                                    WMS Link
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-5 text-gray-400">
                            {{ $map->tahun_data }}
                        </td>
                        <td class="py-3 px-5 flex items-center justify-center space-x-2">
                            <a href="{{ route('manajemen.peta.edit', $map->id) }}"
                               class="text-blue-600 hover:text-blue-800 text-xs font-semibold">Edit</a>
                            <span class="text-gray-300">|</span>
                            <form action="{{ route('manajemen.peta.destroy', $map->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mapset ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-400 text-xs">
                            Belum ada mapset yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-3 border-t border-gray-50 flex items-center justify-end space-x-6 text-[11px] text-gray-500 font-medium bg-white">
            <div>Halaman {{ $maps->currentPage() }} dari {{ $maps->lastPage() }}</div>
            <div class="flex space-x-1">
                <a href="{{ $maps->url(1) }}" class="p-1 border border-gray-200 rounded hover:bg-gray-50 text-gray-400 px-2 text-[9px]">&lt;&lt;</a>
                <a href="{{ $maps->previousPageUrl() ?? '#' }}" class="p-1 border border-gray-200 rounded hover:bg-gray-50 text-gray-400 px-2 text-[9px]">&lt;</a>
                <a href="{{ $maps->nextPageUrl() ?? '#' }}" class="p-1 border border-gray-200 rounded hover:bg-gray-50 text-gray-400 px-2 text-[9px]">&gt;</a>
                <a href="{{ $maps->url($maps->lastPage()) }}" class="p-1 border border-gray-200 rounded hover:bg-gray-50 text-gray-400 px-2 text-[9px]">&gt;&gt;</a>
            </div>
        </div>
    </div>
</div>
@endsection
