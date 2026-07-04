@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="space-y-4">
    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-tight">Manajemen User</h2>
    </div>

    <div class="flex justify-between items-center bg-white p-3 rounded-xl border border-gray-100 shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
        <div class="relative w-64">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" placeholder="Masukkan kata kunci" class="w-full pl-9 pr-4 py-1.5 text-xs border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400">
        </div>

        <a href="{{ route('manajemen.user.create') }}" class="bg-[#008cf8] hover:bg-[#007ee0] text-white px-3.5 py-1.5 rounded-lg text-xs font-semibold inline-flex items-center space-x-1.5 transition shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah User</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-[10px] font-bold uppercase tracking-wider text-gray-400 bg-white">
                        <th class="py-3 px-5">Nama</th>
                        <th class="py-3 px-5">Email</th>
                        <th class="py-3 px-5">Jabatan</th>
                        <th class="py-3 px-5">Organisasi</th>
                        <th class="py-3 px-5">Role</th>
                        <th class="py-3 px-5">Status</th>
                        <th class="py-3 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-gray-600 text-[11px] font-medium">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="py-3 px-5 text-gray-900 font-semibold">{{ $user->nama }}</td>
                        <td class="py-3 px-5 text-gray-400">{{ $user->email }}</td>
                        <td class="py-3 px-5 text-gray-500">{{ $user->jabatan ?? '-' }}</td>
                        <td class="py-3 px-5 text-gray-500">{{ $user->organisasi->nama ?? '-' }}</td>
                        <td class="py-3 px-5">
                            <span class="px-2 py-0.5 border border-gray-200 bg-gray-50 rounded text-gray-600 text-[10px]">{{ $user->role }}</span>
                        </td>
                        <td class="py-3 px-5">
                            <span class="px-2 py-0.5 rounded text-[9px] font-bold {{ strtolower($user->status) == 'aktif' ? 'bg-green-500 text-white' : 'bg-amber-500 text-white' }}">
                                {{ $user->status ?? 'Aktif' }}
                            </span>
                        </td>
                        <td class="py-3 px-5 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('manajemen.user.edit', $user->id) }}" class="p-1.5 text-blue-500 hover:bg-blue-50 rounded transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('manajemen.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-500 hover:bg-red-50 rounded transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-5 py-3 border-t border-gray-50 flex items-center justify-between text-[11px] text-gray-500 font-medium bg-white">
            <div>Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} user</div>
            <div>
                {{ $users->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection
