@extends('layouts.admin')

@section('title', 'Manajemen Konten')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-tight">Manajemen Konten Portal</h2>
        <p class="text-xs text-gray-500">Kelola berbagai data master dan konten berita untuk mendukung portal Smart Facility Map.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Kategori Card -->
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)] flex flex-col justify-between hover:shadow-md transition">
            <div class="space-y-3">
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center text-xl font-bold">
                    🏷️
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Kategori Dataset</h3>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                        Kelola klasifikasi atau kategori data peta seperti Batas Wilayah, Lingkungan, Kependudukan, dll.
                    </p>
                </div>
                <div class="inline-block px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-full">
                    {{ $totalKategori }} Kategori
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-50">
                <a href="{{ route('manajemen.konten.kategori') }}"
                   class="w-full bg-[#008cf8] hover:bg-[#007ee0] text-white py-2 rounded-lg text-xs font-bold text-center block transition shadow-sm">
                    Kelola Kategori &rarr;
                </a>
            </div>
        </div>

        <!-- Organisasi Card -->
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)] flex flex-col justify-between hover:shadow-md transition">
            <div class="space-y-3">
                <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-lg flex items-center justify-center text-xl font-bold">
                    🏛️
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Organisasi / OPD</h3>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                        Kelola data instansi Organisasi Perangkat Daerah penyuplai data spasial dan penanggung jawab mapset.
                    </p>
                </div>
                <div class="inline-block px-2.5 py-1 bg-orange-50 text-orange-700 text-xs font-bold rounded-full">
                    {{ $totalOrganisasi }} Organisasi
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-50">
                <a href="{{ route('manajemen.konten.organisasi') }}"
                   class="w-full bg-[#008cf8] hover:bg-[#007ee0] text-white py-2 rounded-lg text-xs font-bold text-center block transition shadow-sm">
                    Kelola Organisasi &rarr;
                </a>
            </div>
        </div>

        <!-- Berita Card -->
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)] flex flex-col justify-between hover:shadow-md transition">
            <div class="space-y-3">
                <div class="w-10 h-10 bg-green-50 text-green-600 rounded-lg flex items-center justify-center text-xl font-bold">
                    📰
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Berita & Pengumuman</h3>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                        Publikasikan artikel, rilis pers, serta pengumuman terbaru mengenai perkembangan data spasial.
                    </p>
                </div>
                <div class="inline-block px-2.5 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-full">
                    {{ $totalBerita }} Artikel
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-50">
                <a href="{{ route('manajemen.konten.berita') }}"
                   class="w-full bg-[#008cf8] hover:bg-[#007ee0] text-white py-2 rounded-lg text-xs font-bold text-center block transition shadow-sm">
                    Kelola Berita &rarr;
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
