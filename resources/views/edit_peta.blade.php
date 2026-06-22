@extends('layouts.admin')

@section('title', 'Edit Mapset')

@section('content')
<div class="space-y-6 max-w-2xl mx-auto bg-white p-6 rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
    <div class="flex items-center space-x-2">
        <a href="{{ route('manajemen.peta') }}" class="text-xs text-gray-400 hover:text-blue-600 transition">&larr; Kembali ke daftar</a>
    </div>

    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-tight">Edit Mapset: {{ $map->judul_mapset }}</h2>
        <p class="text-xs text-gray-500">Sesuaikan informasi berikut untuk memperbarui data peta di MySQL.</p>
    </div>

    <form action="{{ route('manajemen.peta.update', $map->id) }}" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="judul_mapset" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Judul Mapset</label>
                <input type="text" name="judul_mapset" id="judul_mapset" required value="{{ old('judul_mapset', $map->judul_mapset) }}"
                       class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                @error('judul_mapset')
                    <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="skala" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Skala</label>
                <input type="text" name="skala" id="skala" required value="{{ old('skala', $map->skala) }}"
                       class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                @error('skala')
                    <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <label for="deskripsi" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="3" required
                      class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">{{ old('deskripsi', $map->deskripsi) }}</textarea>
            @error('deskripsi')
                <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="sistem_proyeksi" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Sistem Proyeksi</label>
                <select name="sistem_proyeksi" id="sistem_proyeksi" required
                        class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                    <option value="UTM" {{ old('sistem_proyeksi', $map->sistem_proyeksi) === 'UTM' ? 'selected' : '' }}>UTM</option>
                    <option value="WGS 84" {{ old('sistem_proyeksi', $map->sistem_proyeksi) === 'WGS 84' ? 'selected' : '' }}>WGS 84</option>
                </select>
                @error('sistem_proyeksi')
                    <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="tipe_layer" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tipe Geometri</label>
                <select name="tipe_layer" id="tipe_layer" required
                        class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                    <option value="Polygon" {{ old('tipe_layer', $map->tipe_layer) === 'Polygon' ? 'selected' : '' }}>Polygon</option>
                    <option value="Point" {{ old('tipe_layer', $map->tipe_layer) === 'Point' ? 'selected' : '' }}>Point</option>
                    <option value="Line" {{ old('tipe_layer', $map->tipe_layer) === 'Line' ? 'selected' : '' }}>Line</option>
                </select>
                @error('tipe_layer')
                    <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="tahun_data" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tahun Data</label>
                <input type="number" name="tahun_data" id="tahun_data" required value="{{ old('tahun_data', $map->tahun_data) }}"
                       class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                @error('tahun_data')
                    <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="kategori_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Kategori</label>
                <select name="kategori_id" id="kategori_id" required
                        class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id', $map->kategori_id) == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="organisasi_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Organisasi / OPD</label>
                <select name="organisasi_id" id="organisasi_id" required
                        class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                    @foreach($organisasis as $org)
                        <option value="{{ $org->id }}" {{ old('organisasi_id', $map->organisasi_id) == $org->id ? 'selected' : '' }}>{{ $org->nama }}</option>
                    @endforeach
                </select>
                @error('organisasi_id')
                    <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="tingkat_penyajian" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tingkat Penyajian</label>
                <select name="tingkat_penyajian" id="tingkat_penyajian" required
                        class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                    <option value="Desa/Kelurahan" {{ old('tingkat_penyajian', $map->tingkat_penyajian) === 'Desa/Kelurahan' ? 'selected' : '' }}>Desa/Kelurahan</option>
                    <option value="Kecamatan" {{ old('tingkat_penyajian', $map->tingkat_penyajian) === 'Kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                    <option value="Kabupaten/Kota" {{ old('tingkat_penyajian', $map->tingkat_penyajian) === 'Kabupaten/Kota' ? 'selected' : '' }}>Kabupaten/Kota</option>
                    <option value="Provinsi" {{ old('tingkat_penyajian', $map->tingkat_penyajian) === 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                </select>
            </div>

            <div>
                <label for="cakupan_wilayah" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Cakupan Wilayah</label>
                <select name="cakupan_wilayah" id="cakupan_wilayah" required
                        class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                    <option value="Desa/Kelurahan" {{ old('cakupan_wilayah', $map->cakupan_wilayah) === 'Desa/Kelurahan' ? 'selected' : '' }}>Desa/Kelurahan</option>
                    <option value="Kecamatan" {{ old('cakupan_wilayah', $map->cakupan_wilayah) === 'Kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                    <option value="Kabupaten/Kota" {{ old('cakupan_wilayah', $map->cakupan_wilayah) === 'Kabupaten/Kota' ? 'selected' : '' }}>Kabupaten/Kota</option>
                    <option value="Provinsi" {{ old('cakupan_wilayah', $map->cakupan_wilayah) === 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                </select>
            </div>
        </div>

        <!-- Layer Data Source Options -->
        <div class="p-4 bg-gray-50 border border-gray-100 rounded-lg space-y-3">
            <span class="block text-xs font-bold text-gray-600 uppercase tracking-wider">Sumber Peta / Layer</span>
            
            @php
                $isPgsql = $map->open_layer_id !== null;
            @endphp
            <div class="flex items-center space-x-6">
                <label class="inline-flex items-center text-xs font-medium text-gray-700 cursor-pointer">
                    <input type="radio" name="layer_source" value="wms" class="mr-2 cursor-pointer" {{ old('layer_source', $isPgsql ? 'pgsql' : 'wms') === 'wms' ? 'checked' : '' }} onchange="toggleSourceFields()">
                    GeoServer (WMS URL)
                </label>
                
                <label class="inline-flex items-center text-xs font-medium text-gray-700 cursor-pointer">
                    <input type="radio" name="layer_source" value="pgsql" class="mr-2 cursor-pointer" {{ old('layer_source', $isPgsql ? 'pgsql' : 'wms') === 'pgsql' ? 'checked' : '' }} onchange="toggleSourceFields()">
                    PostgreSQL Open Layer (Dibuat Sebelumnya)
                </label>
            </div>

            <!-- WMS Input Field -->
            <div id="wms_field" class="space-y-1">
                <label for="link_openlayer" class="block text-[11px] font-semibold text-gray-500 uppercase">WMS Map Link URL</label>
                <input type="url" name="link_openlayer" id="link_openlayer" placeholder="https://geoserver.example.com/geoserver/wms?layers=..." value="{{ old('link_openlayer', $isPgsql ? '' : $map->link_openlayer) }}"
                       class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                @error('link_openlayer')
                    <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- PostgreSQL Dropdown Field -->
            <div id="pgsql_field" class="space-y-1 hidden">
                <label for="open_layer_id" class="block text-[11px] font-semibold text-gray-500 uppercase">Pilih PostgreSQL Open Layer</label>
                <select name="open_layer_id" id="open_layer_id"
                        class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                    <option value="">-- Pilih Layer --</option>
                    @foreach($openLayers as $layer)
                        <option value="{{ $layer->id }}" {{ old('open_layer_id', $map->open_layer_id) == $layer->id ? 'selected' : '' }}>
                            {{ $layer->nama_layer }} ({{ $layer->tipe_layer }} - {{ count($layer->geojson['features'] ?? []) }} features)
                        </option>
                    @endforeach
                </select>
                @error('open_layer_id')
                    <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-[#008cf8] hover:bg-[#007ee0] text-white py-2 rounded-lg text-xs font-bold shadow-sm transition">
                Perbarui Mapset
            </button>
        </div>
    </form>
</div>

<script>
    function toggleSourceFields() {
        var source = document.querySelector('input[name="layer_source"]:checked').value;
        var wmsField = document.getElementById('wms_field');
        var pgsqlField = document.getElementById('pgsql_field');
        var linkInput = document.getElementById('link_openlayer');
        var pgsqlSelect = document.getElementById('open_layer_id');

        if (source === 'wms') {
            wmsField.classList.remove('hidden');
            pgsqlField.classList.add('hidden');
            linkInput.setAttribute('required', 'required');
            pgsqlSelect.removeAttribute('required');
        } else {
            wmsField.classList.add('hidden');
            pgsqlField.classList.remove('hidden');
            linkInput.removeAttribute('required');
            pgsqlSelect.setAttribute('required', 'required');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleSourceFields();
    });
</script>
@endsection
