<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Satu Peta Jawa Timur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-[#f8fafc] font-sans antialiased text-gray-800">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-60 bg-white border-r border-gray-100 flex flex-col justify-between fixed h-full z-10">
            <div>
                <div class="p-5 flex items-center space-x-2.5 border-b border-gray-50 relative">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <span class="text-xl">🗺️</span>
                        <div class="font-bold text-sm leading-tight text-blue-600">Satu Peta<br><span class="text-[10px] text-gray-500 font-normal">Jawa Timur</span></div>
                    </a>
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
                       class="flex items-center space-x-3 px-3 py-2 rounded-lg text-[13px] font-medium transition {{ request()->routeIs('manajemen.konten*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15" /></svg>
                        <span>Manajemen Konten</span>
                    </a>
                </div>
            </div>

            <div class="p-3 border-t border-gray-50 space-y-1">
                <div class="flex items-center space-x-2.5 px-2 py-1.5 rounded-lg">
                    <div class="w-8 h-8 bg-blue-100 text-blue-600 font-bold rounded-full flex items-center justify-center text-xs">
                        {{ strtoupper(substr(auth()->user()->nama ?? 'A', 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-gray-700 truncate leading-tight">{{ auth()->user()->nama ?? 'Admin' }}</p>
                        <span class="text-[10px] text-gray-400 block truncate">{{ auth()->user()->role ?? 'User' }}</span>
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

        <!-- Content -->
        <div class="flex-1 pl-60 flex flex-col min-h-screen">
            <main class="p-6 md:p-8 flex-1">
                @if(session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center justify-between" role="alert">
                        <span class="font-medium">{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700 font-bold">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm flex items-center justify-between" role="alert">
                        <span class="font-medium">{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 font-bold">&times;</button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
