<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua OPD - Smart Facility Map</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">

    <nav class="bg-white shadow-sm fixed w-full z-50 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="hover:opacity-80 transition-opacity">
                        <div class="flex items-center space-x-2">
                            <svg class="h-8 w-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            <span class="font-bold text-xl tracking-tight text-gray-800">Smart Facility Map</span>
                        </div>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('katalog.peta') }}" class="text-gray-700 hover:text-blue-600 font-medium">Katalog</a>
                    <a href="{{ route('home') }}#opd" class="text-gray-700 hover:text-blue-600 font-medium">Instansi</a>
                    <a href="{{ route('home') }}#berita" class="text-gray-700 hover:text-blue-600 font-medium">Berita</a>

                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                        MASUK
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="pt-28 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('home') }}" class="text-blue-600 hover:underline text-sm inline-flex items-center gap-1 mb-4">&larr; Kembali ke Beranda</a>
                <h1 class="text-3xl font-bold text-gray-900 border-l-4 border-blue-600 pl-3">Daftar Instansi Pengelola</h1>
                <p class="text-gray-500 mt-2">Daftar seluruh instansi yang berkontribusi dalam penyediaan data fasilitas</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($organisasis as $org)
                <div class="bg-white border rounded-xl p-6 relative shadow-sm hover:shadow-md transition">
                    <div class="absolute top-6 right-6 text-gray-400">→</div>
                    <div class="h-16 mb-4 flex items-center">
                        <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">{{ strtoupper(mb_substr($org->nama, 0, 2)) }}</div>
                    </div>
                    <h3 class="font-medium text-sm text-gray-800 h-10 mb-4">{{ $org->nama }}</h3>
                    <p class="text-xs text-gray-500 mb-3 line-clamp-2">{{ $org->deskripsi ?: 'Instansi Pengelola Data Fasilitas' }}</p>
                    <p class="text-blue-600 text-sm font-bold">{{ $org->maps_count }} Dataset</p>
                </div>
                @empty
                <div class="col-span-full bg-white border rounded-xl p-12 text-center text-gray-500">
                    Belum ada instansi untuk ditampilkan.
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex items-center space-x-2">
                            <svg class="h-8 w-8 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            <span class="font-bold text-xl leading-tight">Smart Facility Map</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm mb-6">Portal sistem informasi geografis untuk pemetaan dan analisis data fasilitas secara terpadu.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 border border-gray-600 rounded-full flex items-center justify-center hover:bg-gray-800">Ig</a>
                        <a href="#" class="w-10 h-10 border border-gray-600 rounded-full flex items-center justify-center hover:bg-gray-800">Yt</a>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-lg mb-6">Kontak</h4>
                    <ul class="space-y-4 text-sm text-gray-400">
                        <li class="flex items-start">
                            <span class="mr-3 mt-1">📍</span>
                            <span>Alamat: Jl. Ahmad Yani No.242-244, Gayungan, Kec. Gayungan,<br>Surabaya, Jawa Timur 60235</span>
                        </li>
                        <li class="flex items-center">
                            <span class="mr-3">📞</span>
                            <span>(031) 8294608</span>
                        </li>
                        <li class="flex items-center">
                            <span class="mr-3">✉️</span>
                            <span>info@smartfacilitymap.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-12 pt-8 text-sm text-gray-500 flex justify-between">
                <p>© 2026 Smart Facility Map. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
