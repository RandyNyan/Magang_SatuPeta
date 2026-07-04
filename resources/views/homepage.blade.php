<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Facility Map - Beranda</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Placeholder untuk background hero jika kamu punya gambar aslinya */
        .hero-bg {
            background: linear-gradient(to bottom, #e0f2fe, #bae6fd);
            /* background-image: url('path/to/your/hero-image.png'); */
            background-size: cover;
            background-position: center;
        }
    </style>
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

    <section class="hero-bg pt-32 pb-40 relative">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-blue-600 mb-4">Sistem Informasi Geografis Cerdas</h1>
            <p class="text-lg text-gray-600 mb-10">Pemetaan dan analisis fasilitas terpadu untuk kemudahan perencanaan.</p>

            <form action="{{ route('katalog.peta') }}" method="GET" class="bg-white p-2 rounded-full shadow-lg flex items-center max-w-3xl mx-auto">
                <div class="pl-4 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="q" placeholder="Eksplor data berdasarkan tema atau kata kunci" class="w-full px-4 py-2 outline-none text-gray-700">
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-full font-medium mr-2">Cari</button>
                <a href="{{ route('katalog.peta') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full font-medium flex-shrink-0">Buka peta</a>
            </form>
        </div>
    </section>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative -mt-16 z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-blue-600 text-white p-6 rounded-xl shadow-lg flex flex-col justify-between hover:scale-[1.02] transition duration-300">
                <div>
                    <span class="text-xs font-semibold tracking-wider opacity-85 uppercase block mb-1">Total Katalog</span>
                    <h3 class="text-4xl font-black mb-2">{{ $totalMaps }}</h3>
                    <p class="text-xs opacity-90">Mapset / Peta Aktif</p>
                </div>
                <div class="mt-4 pt-4 border-t border-white/20">
                    <a href="{{ route('katalog.peta') }}" class="text-xs font-semibold hover:underline inline-flex items-center gap-1">
                        Buka Katalog Peta &rarr;
                    </a>
                </div>
            </div>
            <div class="bg-blue-600 text-white p-6 rounded-xl shadow-lg flex flex-col justify-between hover:scale-[1.02] transition duration-300">
                <div>
                    <span class="text-xs font-semibold tracking-wider opacity-85 uppercase block mb-1">Kontributor</span>
                    <h3 class="text-4xl font-black mb-2">{{ $totalOrganisasi }}</h3>
                    <p class="text-xs opacity-90">Instansi Pengelola Fasilitas</p>
                </div>
                <div class="mt-4 pt-4 border-t border-white/20">
                    <a href="{{ route('semua.opd') }}" class="text-xs font-semibold hover:underline inline-flex items-center gap-1">
                        Lihat Daftar Instansi &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section id="topik" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 mt-8">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 border-l-4 border-blue-600 pl-3">Topik</h2>
                <p class="text-gray-500 mt-2">Telusuri ragam topik yang tersedia!</p>
            </div>
            <a href="{{ route('semua.topik') }}" class="border border-pink-500 text-pink-500 px-6 py-2 rounded-full hover:bg-pink-50 transition">Lihat Semua</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-6 gap-6">
            @forelse($kategoris as $kategori)
            <a href="{{ route('katalog.peta') }}" class="bg-white border rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition cursor-pointer block">
                <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">📁</div>
                <h3 class="font-semibold text-gray-800 mb-2">{{ $kategori->nama_kategori }}</h3>
                <p class="text-blue-600 text-sm font-medium">{{ $kategori->maps_count }} Dataset</p>
            </a>
            @empty
            <div class="col-span-full bg-white border rounded-2xl p-8 text-center text-gray-500">
                Belum ada topik untuk ditampilkan.
            </div>
            @endforelse
        </div>
    </section>

    <section id="opd" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 border-l-4 border-blue-600 pl-3">Daftar Instansi Pengelola</h2>
                <p class="text-gray-500 mt-2">Instansi yang berkontribusi dalam penyediaan data fasilitas</p>
            </div>
            <a href="{{ route('semua.opd') }}" class="border border-pink-500 text-pink-500 px-6 py-2 rounded-full hover:bg-pink-50 transition">Lihat Semua</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
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
            <div class="col-span-full bg-white border rounded-xl p-8 text-center text-gray-500">
                Belum ada organisasi untuk ditampilkan.
            </div>
            @endforelse
        </div>
    </section>

    <section id="berita" class="bg-blue-600 py-16 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-8 text-white">
                <div>
                    <h2 class="text-2xl font-bold border-l-4 border-white pl-3">Berita & Pengumuman</h2>
                    <p class="text-blue-100 mt-2">Informasi terbaru seputar perkembangan data geospasial Jawa Timur</p>
                </div>
                <a href="{{ route('semua.berita') }}" class="border border-white text-white px-6 py-2 rounded-full hover:bg-blue-700 transition">Lihat Semua</a>
            </div>

            @forelse($beritas as $berita)
                @if($loop->first)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @endif
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="h-32 bg-gradient-to-br from-blue-400 to-indigo-500"></div>
                    <div class="p-6">
                        <p class="text-xs text-gray-400 mb-2">{{ $berita->created_at->format('d M Y') }}</p>
                        <h3 class="font-bold text-gray-800 mb-2">{{ $berita->judul }}</h3>
                        <p class="text-sm text-gray-500">{{ Str::limit($berita->konten, 120) }}</p>
                    </div>
                </div>
                @if($loop->last)
                </div>
                @endif
            @empty
            <div class="bg-white rounded-xl p-8 text-gray-500 shadow-lg">
                Belum ada berita untuk ditampilkan.
            </div>
            @endforelse
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
