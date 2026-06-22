<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satu Peta Jawa Timur - Beranda</title>
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
                    <a href="{{ url('homepage') }}" class="hover:opacity-80 transition-opacity">
                        <img src="{{ asset('asset/logo.svg') }}" alt="Logo Satu Peta Jawa Timur" class="h-10 w-auto object-contain">
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Katalog</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">OPD</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Berita</a>

                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                        MASUK
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-bg pt-32 pb-40 relative">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-blue-600 mb-4">Platform Data Geospasial Jawa Timur</h1>
            <p class="text-lg text-gray-600 mb-10">Satu peta untuk pembangunan berkelanjutan</p>

            <div class="bg-white p-2 rounded-full shadow-lg flex items-center max-w-3xl mx-auto">
                <div class="pl-4 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" placeholder="Eksplor data berdasarkan tema atau kata kunci" class="w-full px-4 py-2 outline-none text-gray-700">
                <button class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-full font-medium mr-2">Cari</button>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full font-medium">Buka peta</button>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative -mt-16 z-10">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-blue-600 text-white p-6 rounded-xl shadow-lg flex flex-col justify-between">
                <h3 class="text-3xl font-bold mb-1">296</h3>
                <p class="text-sm opacity-90 mb-2">Total Mapset</p>
                <a href="{{ route('katalog.peta') }}" class="text-xs underline">Lihat Semua</a>
            </div>
            <div class="bg-blue-600 text-white p-6 rounded-xl shadow-lg flex flex-col justify-between">
                <h3 class="text-3xl font-bold mb-1">30</h3>
                <p class="text-sm opacity-90 mb-2">Organisasi Perangkat Daerah</p>
                <a href="#" class="text-xs underline">Lihat Semua</a>
            </div>
            <div class="bg-blue-600 text-white p-6 rounded-xl shadow-lg flex flex-col justify-between">
                <h3 class="text-3xl font-bold mb-1">217</h3>
                <p class="text-sm opacity-90 mb-2">Metadata</p>
                <a href="#" class="text-xs underline">Lihat Semua</a>
            </div>
            <div class="bg-blue-600 text-white p-6 rounded-xl shadow-lg flex flex-col justify-between">
                <h3 class="text-3xl font-bold mb-1">3.719</h3>
                <p class="text-sm opacity-90 mb-2">Total Pengunjung</p>
                <p class="text-xs"><span class="font-bold">↗</span> Pengunjung dalam 1 Tahun</p>
            </div>
            <div class="bg-blue-600 text-white p-6 rounded-xl shadow-lg flex flex-col justify-between">
                <h3 class="text-3xl font-bold mb-1">623</h3>
                <p class="text-sm opacity-90 mb-2">Total Unduhan</p>
                <p class="text-xs"><span class="font-bold">↓</span> Unduhan dalam 1 Tahun</p>
            </div>
        </div>
    </div>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 mt-8">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 border-l-4 border-blue-600 pl-3">Topik</h2>
                <p class="text-gray-500 mt-2">Telusuri ragam topik yang tersedia!</p>
            </div>
            <a href="#" class="border border-pink-500 text-pink-500 px-6 py-2 rounded-full hover:bg-pink-50 transition">Lihat Semua</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-6 gap-6">
            <div class="bg-white border rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition cursor-pointer">
                <div class="w-16 h-16 bg-green-100 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">🗺️</div>
                <h3 class="font-semibold text-gray-800 mb-2">Batas Wilayah</h3>
                <p class="text-blue-600 text-sm font-medium">5 Dataset</p>
            </div>
            <div class="bg-white border rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition cursor-pointer">
                <div class="w-16 h-16 bg-orange-100 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">👥</div>
                <h3 class="font-semibold text-gray-800 mb-2">Kependudukan</h3>
                <p class="text-blue-600 text-sm font-medium">10 Dataset</p>
            </div>
            <div class="bg-white border rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition cursor-pointer">
                <div class="w-16 h-16 bg-green-100 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">🌱</div>
                <h3 class="font-semibold text-gray-800 mb-2">Lingkungan Hidup</h3>
                <p class="text-blue-600 text-sm font-medium">39 Dataset</p>
            </div>
            <div class="bg-white border-2 border-blue-400 rounded-2xl p-6 text-center shadow-md cursor-pointer">
                <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">🏛️</div>
                <h3 class="font-semibold text-gray-800 mb-2">Pemerintah & Desa</h3>
                <p class="text-blue-600 text-sm font-medium">29 Dataset</p>
            </div>
            <div class="bg-white border rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition cursor-pointer">
                <div class="w-16 h-16 bg-red-100 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">📚</div>
                <h3 class="font-semibold text-gray-800 mb-2">Pendidikan</h3>
                <p class="text-blue-600 text-sm font-medium">4 Dataset</p>
            </div>
            <div class="bg-white border rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition cursor-pointer">
                <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">🤝</div>
                <h3 class="font-semibold text-gray-800 mb-2">Sosial</h3>
                <p class="text-blue-600 text-sm font-medium">48 Dataset</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 border-l-4 border-blue-600 pl-3">Data Geospasial Lintas OPD</h2>
                <p class="text-gray-500 mt-2">Organisasi Perangkat Daerah yang berkontribusi dalam penyediaan data</p>
            </div>
            <a href="#" class="border border-pink-500 text-pink-500 px-6 py-2 rounded-full hover:bg-pink-50 transition">Lihat Semua</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white border rounded-xl p-6 relative shadow-sm hover:shadow-md transition">
                <div class="absolute top-6 right-6 text-gray-400">→</div>
                <div class="h-16 mb-4 flex items-center">
                    <div class="w-12 h-16 bg-blue-200 rounded"></div> </div>
                <h3 class="font-medium text-sm text-gray-800 h-10 mb-4">Dinas Kelautan dan Perikanan Provinsi Jawa Timur</h3>
                <p class="text-blue-600 text-sm font-bold">41 Dataset</p>
            </div>
            <div class="bg-white border rounded-xl p-6 relative shadow-sm hover:shadow-md transition">
                <div class="absolute top-6 right-6 text-gray-400">→</div>
                <div class="h-16 mb-4 flex items-center">
                    <div class="w-12 h-16 bg-blue-200 rounded"></div>
                </div>
                <h3 class="font-medium text-sm text-gray-800 h-10 mb-4">Dinas Kesehatan Provinsi Jawa Timur</h3>
                <p class="text-blue-600 text-sm font-bold">37 Dataset</p>
            </div>
             <div class="bg-white border rounded-xl p-6 relative shadow-sm hover:shadow-md transition">
                <div class="absolute top-6 right-6 text-gray-400">→</div>
                <div class="h-16 mb-4 flex items-center">
                    <div class="w-16 h-12 bg-red-200 rounded"></div>
                </div>
                <h3 class="font-medium text-sm text-gray-800 h-10 mb-4">Dinas Sosial Provinsi Jawa Timur</h3>
                <p class="text-blue-600 text-sm font-bold">34 Dataset</p>
            </div>
            <div class="bg-white border rounded-xl p-6 relative shadow-sm hover:shadow-md transition">
                <div class="absolute top-6 right-6 text-gray-400">→</div>
                <div class="h-16 mb-4 flex items-center">
                    <div class="w-12 h-16 bg-blue-200 rounded"></div>
                </div>
                <h3 class="font-medium text-sm text-gray-800 h-10 mb-4">Biro Pemerintahan dan Otonomi Daerah...</h3>
                <p class="text-blue-600 text-sm font-bold">32 Dataset</p>
            </div>
        </div>
    </section>

    <section class="bg-blue-600 py-16 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-8 text-white">
                <div>
                    <h2 class="text-2xl font-bold border-l-4 border-white pl-3">Berita & Pengumuman</h2>
                    <p class="text-blue-100 mt-2">Informasi terbaru seputar perkembangan data geospasial Jawa Timur</p>
                </div>
                <a href="#" class="border border-white text-white px-6 py-2 rounded-full hover:bg-blue-700 transition">Lihat Semua</a>
            </div>

            <div class="bg-white rounded-xl p-8 text-gray-500 shadow-lg">
                Belum ada berita untuk ditampilkan.
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-10 h-10 bg-blue-500 rounded-sm flex items-center justify-center font-bold">SP</div>
                        <div>
                            <span class="font-bold text-xl leading-tight">Satu Peta</span><br>
                            <span class="text-xs text-red-400">Jawa Timur</span>
                        </div>
                        <div class="ml-4 border border-gray-600 px-3 py-1 text-xs rounded flex items-center gap-2">
                            <span>TERDAFTAR</span>
                            <span class="font-bold">KOMDIGI</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm mb-6">Portal basis data spasial dan informasi Geospasial Provinsi Jawa Timur</p>
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
                            <span>info@satupeta.jatimprov.go.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-12 pt-8 text-sm text-gray-500 flex justify-between">
                <p>© 2026 Pemerintah Provinsi Jawa Timur. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
