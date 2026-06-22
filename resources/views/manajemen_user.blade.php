<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Satu Peta Jawa Timur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8fafc] font-sans antialiased text-gray-800">

    <div class="flex min-h-screen">

        <div class="w-60 bg-white border-r border-gray-100 flex flex-col justify-between fixed h-full z-10">
            <div>
                <div class="p-5 flex items-center space-x-2.5 border-b border-gray-50 relative">
                    <img src="{{ asset('asset/logo.svg') }}" alt="Logo Satu Peta Jawa Timur" class="h-10 w-auto object-contain">
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 hover:text-gray-500 cursor-pointer text-[10px]">
                        &lt;&lt;
                    </div>
                </div>

                <div class="px-3 py-4 space-y-0.5">
                    <span class="px-3 text-[10px] font-bold text-gray-400 tracking-wider uppercase block mb-2">Features</span>

                    <a href="{{ route('manajemen.peta') }}"
                       class="flex items-center space-x-3 px-3 py-2 rounded-lg text-[13px] font-medium transition {{ request()->routeIs('manajemen.peta*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" /></svg>
                        <span>Manajemen Peta</span>
                    </a>

                    <a href="{{ route('manajemen.open-layers') }}"
                       class="flex items-center space-x-3 px-3 py-2 rounded-lg text-[13px] font-medium transition {{ request()->routeIs('manajemen.open-layers*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        <span>Manajemen Open Layer</span>
                    </a>

                    <a href="{{ route('manajemen.user') }}"
                       class="flex items-center space-x-3 px-3 py-2 rounded-lg text-[13px] font-medium transition {{ request()->routeIs('manajemen.user*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        <span>Manajemen User</span>
                    </a>

                    <a href="{{ route('manajemen.konten') }}"
                       class="flex items-center space-x-3 px-3 py-2 rounded-lg text-[13px] font-medium transition {{ request()->routeIs('manajemen_konten') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15" /></svg>
                        <span>Manajemen Konten</span>
                    </a>
                </div>
            </div>

            <div class="p-3 border-t border-gray-50 space-y-1">
                <div class="flex items-center space-x-2.5 px-2 py-1.5 rounded-lg">
                    <div class="w-8 h-8 bg-gray-200 text-gray-500 font-bold rounded-full flex items-center justify-center text-xs">
                        W
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-gray-700 truncate leading-tight">Walidata Demo</p>
                        <span class="text-[10px] text-gray-400 block truncate">Walidata</span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-gray-500 hover:bg-red-50 hover:text-red-600 transition">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="flex-1 pl-60 flex flex-col min-h-screen">
            <main class="p-6 md:p-8 flex-1">
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
                            <input type="text" placeholder="Masukkan kata kunci"
                                class="w-full pl-9 pr-4 py-1.5 text-xs border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400">
                        </div>

                        <a href="{{ route('manajemen.user.create') }}"
                        class="bg-[#008cf8] hover:bg-[#007ee0] text-white px-3.5 py-1.5 rounded-lg text-xs font-semibold inline-flex items-center space-x-1.5 transition shadow-sm">
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
                                        <th class="py-3 px-5 cursor-pointer hover:text-gray-600">
                                            <span class="inline-flex items-center space-x-1">
                                                <span>Nama</span>
                                                <span class="text-[8px] text-gray-500">▲</span>
                                            </span>
                                        </th>
                                        <th class="py-3 px-5 cursor-pointer hover:text-gray-600">
                                            <span class="inline-flex items-center space-x-1">
                                                <span>Email</span>
                                                <span class="text-[8px] text-gray-300">▼</span>
                                            </span>
                                        </th>
                                        <th class="py-3 px-5">Jabatan</th>
                                        <th class="py-3 px-5">Organisasi</th>
                                        <th class="py-3 px-5">Role</th>
                                        <th class="py-3 px-5">Status</th>
                                        <th class="py-3 px-5 text-center"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 text-gray-600 text-[11px] font-medium">

                                    @foreach($users as $user)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-3 px-5 text-gray-900 font-semibold">
                                            {{ $user->nama }}
                                        </td>
                                        <td class="py-3 px-5 text-gray-400">
                                            {{ $user->email }}
                                        </td>
                                        <td class="py-3 px-5 text-gray-500">
                                            {{ $user->jabatan }}
                                        </td>
                                        <td class="py-3 px-5 text-gray-500">
                                            {{ $user->organisasi->nama ?? '-' }}
                                        </td>
                                        <td class="py-3 px-5">
                                            <span class="px-2 py-0.5 border border-gray-200 bg-gray-50 rounded text-gray-600 text-[10px]">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-5">
                                            <span class="px-2 py-0.5 rounded text-[9px] font-bold {{ strtolower($user->status) == 'aktif' ? 'bg-green-500 text-white' : 'bg-amber-500 text-white' }}">
                                                {{ $user->status }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-5 text-center text-gray-400 font-bold tracking-widest cursor-pointer hover:text-gray-700">•••</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        <div class="px-5 py-3 border-t border-gray-50 flex items-center justify-end space-x-6 text-[11px] text-gray-500 font-medium bg-white">
                            <div class="flex items-center space-x-2">
                                <span>Rows per page:</span>
                                <select class="border border-gray-200 rounded px-1 py-0.5 bg-white focus:outline-none cursor-pointer">
                                    <option>10</option>
                                    <option>25</option>
                                </select>
                            </div>

                            <div>Page {{ $users->currentPage() }} of {{ $users->lastPage() }}</div>

                            <div class="flex space-x-1">
                                <a href="{{ $users->url(1) }}" class="p-1 border border-gray-200 rounded hover:bg-gray-50 text-gray-400 px-2 text-[9px]">&lt;&lt;</a>
                                <a href="{{ $users->previousPageUrl() ?? '#' }}" class="p-1 border border-gray-200 rounded hover:bg-gray-50 text-gray-400 px-2 text-[9px]">&lt;</a>
                                <a href="{{ $users->nextPageUrl() ?? '#' }}" class="p-1 border border-gray-200 rounded hover:bg-gray-50 text-gray-400 px-2 text-[9px]">&gt;</a>
                                <a href="{{ $users->url($users->lastPage()) }}" class="p-1 border border-gray-200 rounded hover:bg-gray-50 text-gray-400 px-2 text-[9px]">&gt;&gt;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
