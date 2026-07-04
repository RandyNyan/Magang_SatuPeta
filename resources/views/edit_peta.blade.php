@extends('layouts.admin')

@section('title', 'Edit Peta')

@section('content')
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v8.2.0/ol.css">
<style>
    .rule-row input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 1px #3b82f6;
    }
</style>
@endpush

<div class="space-y-6 max-w-7xl mx-auto">
    <div class="flex items-center space-x-2">
        <a href="{{ route('manajemen.peta') }}" class="text-xs text-gray-400 hover:text-blue-600 transition">&larr; Kembali ke daftar</a>
    </div>

    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-tight">Edit Peta: {{ $map->judul_mapset }}</h2>
        <p class="text-xs text-gray-500">Sesuaikan data spasial dari PostgreSQL/PostGIS atau WMS Server berikut.</p>
    </div>

    <form action="{{ route('manajemen.peta.update', $map->id) }}" method="POST" id="peta-form">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Form Card -->
            <div class="lg:col-span-6 bg-white p-6 rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)] space-y-4">
                <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-50 pb-2">Informasi Metadata</span>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="judul_mapset" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Judul Mapset</label>
                        <input type="text" name="judul_mapset" id="judul_mapset" required placeholder="Contoh: Kepadatan Penduduk Sidoarjo" value="{{ old('judul_mapset', $map->judul_mapset) }}"
                               class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                        @error('judul_mapset')
                            <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="skala" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Skala</label>
                        <input type="text" name="skala" id="skala" required placeholder="Contoh: 1:50.000" value="{{ old('skala', $map->skala) }}"
                               class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                        @error('skala')
                            <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="deskripsi" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" required placeholder="Deskripsikan isi peta..."
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
                    </div>

                    <div>
                        <label for="tipe_layer" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tipe Geometri</label>
                        <select name="tipe_layer" id="tipe_layer" required
                                class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                            <option value="Polygon" {{ old('tipe_layer', $map->tipe_layer) === 'Polygon' ? 'selected' : '' }}>Polygon</option>
                            <option value="Point" {{ old('tipe_layer', $map->tipe_layer) === 'Point' ? 'selected' : '' }}>Point</option>
                            <option value="Line" {{ old('tipe_layer', $map->tipe_layer) === 'Line' ? 'selected' : '' }}>Line</option>
                        </select>
                    </div>

                    <div>
                        <label for="tahun_data" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tahun Data</label>
                        <input type="number" name="tahun_data" id="tahun_data" required placeholder="2026" value="{{ old('tahun_data', $map->tahun_data) }}"
                               class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
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
                    </div>

                    <div>
                        <label for="organisasi_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Organisasi / OPD</label>
                        <select name="organisasi_id" id="organisasi_id" required
                                class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                            @foreach($organisasis as $org)
                                <option value="{{ $org->id }}" {{ old('organisasi_id', $map->organisasi_id) == $org->id ? 'selected' : '' }}>{{ $org->nama }}</option>
                            @endforeach
                        </select>
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

                <div class="space-y-3 pt-3 border-t border-gray-50">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Sumber Peta / Layer</label>
                    <div class="flex space-x-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="sumber_peta" value="wms" class="form-radio text-blue-600 focus:ring-blue-400" {{ old('sumber_peta', $map->sumber_peta) === 'wms' ? 'checked' : '' }}>
                            <span class="ml-2 text-xs font-semibold text-gray-600">WMS (GeoServer URL)</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="sumber_peta" value="pgsql" class="form-radio text-blue-600 focus:ring-blue-400" {{ old('sumber_peta', $map->sumber_peta) === 'pgsql' ? 'checked' : '' }}>
                            <span class="ml-2 text-xs font-semibold text-gray-600">PostgreSQL (PostGIS Table)</span>
                        </label>
                    </div>
                </div>

                <!-- WMS Input -->
                <div id="wms-group" class="p-4 bg-gray-50 border border-gray-100 rounded-xl space-y-3">
                    <div>
                        <label for="link_openlayer" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">WMS Map Link URL (GeoServer)</label>
                        <input type="url" name="link_openlayer" id="link_openlayer" placeholder="https://geoserver.example.com/geoserver/wms?layers=..." value="{{ old('link_openlayer', $map->link_openlayer) }}"
                               class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                    </div>
                </div>

                <!-- PostgreSQL Inputs -->
                <div id="pgsql-group" class="p-4 bg-gray-50 border border-gray-100 rounded-xl space-y-4 hidden">
                    <div class="mb-4">
                        <label for="open_layer_id" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Pilih dari Open Layer (Opsional)</label>
                        <select name="open_layer_id" id="open_layer_id"
                                class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                            <option value="">-- Konfigurasi Manual --</option>
                            @foreach($openLayers as $ol)
                                <option value="{{ $ol->id }}" data-table="{{ $ol->pgsql_table }}" {{ old('open_layer_id', $map->open_layer_id) == $ol->id ? 'selected' : '' }}>
                                    {{ $ol->nama_layer }} ({{ $ol->pgsql_table }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[9px] text-gray-400 mt-1">Jika dipilih, pengaturan tabel dan styling akan otomatis mengikuti Open Layer ini.</p>
                    </div>

                    <div id="manual-pgsql-config">
                        <div>
                            <label for="pgsql_table" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Pilih Tabel PostgreSQL (Manual)</label>
                            <select name="pgsql_table" id="pgsql_table"
                                    class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                                <option value="">-- Pilih Tabel --</option>
                                @foreach($pgsqlTables as $table)
                                    <option value="{{ $table }}" {{ old('pgsql_table', $map->pgsql_table) === $table ? 'selected' : '' }}>{{ $table }}</option>
                                @endforeach
                            </select>
                        </div>

                    <div id="column-group" class="hidden">
                        <label for="pgsql_column" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Kolom untuk Klasifikasi</label>
                        <select id="pgsql_column"
                                class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                            <option value="">-- Pilih Kolom --</option>
                        </select>
                    </div>

                    <!-- Rule Builder -->
                    <div id="rule-builder-group" class="space-y-3 hidden">
                        <div class="flex justify-between items-center">
                            <span class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider">Rentang Klasifikasi (Choropleth)</span>
                            <button type="button" id="btn-add-rule" class="px-2.5 py-1 bg-blue-50 text-blue-600 border border-blue-100 rounded-md text-[10px] font-bold hover:bg-blue-100 transition">
                                + Rentang Baru
                            </button>
                        </div>

                        <div id="rules-container" class="space-y-2 max-h-56 overflow-y-auto pr-1">
                            <!-- Dynamic rows -->
                        </div>

                        <input type="hidden" name="style_rules" id="style_rules" value="{{ is_array($map->style_rules) ? json_encode($map->style_rules) : $map->style_rules }}">
                    </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-[#008cf8] hover:bg-[#007ee0] text-white py-2.5 rounded-lg text-xs font-bold shadow-sm transition">
                        Perbarui Peta
                    </button>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="lg:col-span-6 space-y-4">
                <!-- Map Card -->
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)] space-y-3">
                    <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-50 pb-2">Preview Peta</span>
                    <div id="preview-map-container" class="relative w-full h-80 rounded-lg border border-gray-200 overflow-hidden bg-gray-50">
                        <div id="preview-map" class="w-full h-full"></div>
                        <div id="map-loading" class="absolute inset-0 bg-white/70 flex items-center justify-center hidden z-10">
                            <div class="flex flex-col items-center space-y-2">
                                <svg class="animate-spin h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-[10px] text-gray-500 font-semibold">Mengambil data spasial...</span>
                            </div>
                        </div>
                    </div>

                    <!-- Overlay popup container -->
                    <div id="preview-popup" class="absolute bg-white px-3 py-2.5 rounded-lg shadow-lg border border-gray-100 hidden text-[11px] min-w-[200px] max-w-[280px] z-50">
                        <div class="font-bold text-blue-600 border-b border-gray-100 pb-1 mb-1" id="preview-popup-title">Detail Fitur</div>
                        <div id="preview-popup-content" class="max-h-40 overflow-y-auto space-y-1"></div>
                    </div>
                </div>

                <!-- SLD XML Card -->
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)] space-y-3">
                    <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-50 pb-2">Styled Layer Descriptor (SLD XML)</span>
                    <pre id="sld-preview" class="w-full h-56 p-3 bg-gray-900 text-gray-200 rounded-lg overflow-auto text-[10px] font-mono whitespace-pre-wrap">SLD XML will generate here...</pre>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/ol@v8.2.0/dist/ol.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radWms = document.querySelector('input[name="sumber_peta"][value="wms"]');
        const radPgsql = document.querySelector('input[name="sumber_peta"][value="pgsql"]');
        const wmsGroup = document.getElementById('wms-group');
        const pgsqlGroup = document.getElementById('pgsql-group');
        const txtLink = document.getElementById('link_openlayer');
        const selOpenLayer = document.getElementById('open_layer_id');
        const manualPgsqlConfig = document.getElementById('manual-pgsql-config');
        const selTable = document.getElementById('pgsql_table');
        const selColumn = document.getElementById('pgsql_column');
        const colGroup = document.getElementById('column-group');
        const ruleBuilderGroup = document.getElementById('rule-builder-group');
        const rulesContainer = document.getElementById('rules-container');
        const btnAddRule = document.getElementById('btn-add-rule');
        const styleRulesInput = document.getElementById('style_rules');
        const sldPreview = document.getElementById('sld-preview');
        const mapLoading = document.getElementById('map-loading');
        
        let map;
        let vectorSource;
        let vectorLayer;
        let popupOverlay;
        let geojsonFeatures = [];

        // Toggle Source Group
        function toggleSource() {
            if (radWms.checked) {
                wmsGroup.classList.remove('hidden');
                pgsqlGroup.classList.add('hidden');
                txtLink.setAttribute('required', 'required');
                selTable.removeAttribute('required');
                
                document.getElementById('preview-map-container').parentElement.classList.add('opacity-50');
            } else {
                wmsGroup.classList.add('hidden');
                pgsqlGroup.classList.remove('hidden');
                txtLink.removeAttribute('required');
                
                if (selOpenLayer.value === '') {
                    selTable.setAttribute('required', 'required');
                } else {
                    selTable.removeAttribute('required');
                }
                
                document.getElementById('preview-map-container').parentElement.classList.remove('opacity-50');
                if (!map) {
                    initMap();
                }
            }
        }

        radWms.addEventListener('change', toggleSource);
        radPgsql.addEventListener('change', toggleSource);
        
        // Initial setup
        toggleSource();

        // Handle Open Layer selection
        selOpenLayer.addEventListener('change', function() {
            if (this.value !== '') {
                // Hide manual config
                manualPgsqlConfig.classList.add('hidden');
                selTable.removeAttribute('required');
                
                // Get table name from selected option's data attribute
                const selectedOption = this.options[this.selectedIndex];
                const tableName = selectedOption.getAttribute('data-table');
                
                if (tableName) {
                    // Fetch map data just for preview
                    loadMapData(tableName, true);
                    sldPreview.textContent = "Menggunakan styling dari Open Layer terkonfigurasi. Preview SLD disembunyikan.";
                }
            } else {
                // Show manual config
                manualPgsqlConfig.classList.remove('hidden');
                selTable.setAttribute('required', 'required');
                
                // Trigger table change if already selected
                if (selTable.value) {
                    selTable.dispatchEvent(new Event('change'));
                } else {
                    vectorSource.clear();
                    sldPreview.textContent = "SLD XML will generate here...";
                }
            }
        });

        // Helper to load map data
        function loadMapData(table, useDefaultStyle = false) {
            mapLoading.classList.remove('hidden');
            vectorSource.clear();
            
            fetch(`/api/spatial/geojson/${table}`)
                .then(res => res.json())
                .then(data => {
                    const format = new ol.format.GeoJSON();
                    const features = format.readFeatures(data, {
                        dataProjection: 'EPSG:4326',
                        featureProjection: 'EPSG:3857'
                    });
                    
                    geojsonFeatures = features;
                    vectorSource.addFeatures(features);
                    
                    if (useDefaultStyle && vectorLayer) {
                        vectorLayer.setStyle(getDefaultStyle());
                    }
                    
                    if (features.length > 0) {
                        const extent = vectorSource.getExtent();
                        map.getView().fit(extent, {
                            padding: [20, 20, 20, 20],
                            duration: 1000
                        });
                    }
                    mapLoading.classList.add('hidden');
                })
                .catch(err => {
                    console.error(err);
                    mapLoading.classList.add('hidden');
                    alert('Gagal mengambil data spasial dari PostgreSQL.');
                });
        }

        // If there's an existing pgsql configuration, initialize it
        const initialTable = "{{ $map->pgsql_table }}";
        const initialOpenLayer = "{{ $map->open_layer_id }}";
        // Parse initial style rules safely
        let initialRules = null;
        try {
            initialRules = @json($map->style_rules);
            if (typeof initialRules === 'string') {
                initialRules = JSON.parse(initialRules);
            }
        } catch (e) {
            console.error("Failed to parse initial style rules:", e);
        }

        if (radPgsql.checked) {
            if (initialOpenLayer) {
                // If using an Open Layer, trigger the change event to set it up
                selOpenLayer.dispatchEvent(new Event('change'));
            } else if (initialTable) {
                // If using manual config, load metadata
                loadTableMetadata(initialTable, initialRules);
            }
        }

        function loadTableMetadata(table, rules) {
            selTable.value = table;
            
            // Fetch columns
            fetch(`/api/spatial/columns/${table}`)
                .then(res => res.json())
                .then(cols => {
                    selColumn.innerHTML = '<option value="">-- Pilih Kolom --</option>';
                    cols.forEach(col => {
                        if (!col.data_type.includes('geometry') && col.column_name !== 'geom') {
                            const selected = (rules && rules.column === col.column_name) ? 'selected' : '';
                            selColumn.innerHTML += `<option value="${col.column_name}" ${selected}>${col.column_name} (${col.data_type})</option>`;
                        }
                    });
                    colGroup.classList.remove('hidden');
                    
                    if (rules && rules.column) {
                        ruleBuilderGroup.classList.remove('hidden');
                        
                        // Populate rules
                        rulesContainer.innerHTML = '';
                        if (rules.ranges && rules.ranges.length > 0) {
                            rules.ranges.forEach(range => {
                                addRuleRow(range.min, range.max, range.color);
                            });
                        } else {
                            addDefaultRanges();
                        }
                    }
                });

            // Fetch GeoJSON for preview
            mapLoading.classList.remove('hidden');
            vectorSource.clear();
            
            fetch(`/api/spatial/geojson/${table}`)
                .then(res => res.json())
                .then(data => {
                    const format = new ol.format.GeoJSON();
                    const features = format.readFeatures(data, {
                        dataProjection: 'EPSG:4326',
                        featureProjection: 'EPSG:3857'
                    });
                    
                    geojsonFeatures = features;
                    vectorSource.addFeatures(features);
                    
                    if (features.length > 0) {
                        const extent = vectorSource.getExtent();
                        map.getView().fit(extent, {
                            padding: [20, 20, 20, 20],
                            duration: 1000
                        });
                    }
                    mapLoading.classList.add('hidden');
                    updateStylesAndSLD(); // trigger initial draw
                })
                .catch(err => {
                    console.error(err);
                    mapLoading.classList.add('hidden');
                });
        }

        // Dropdown selection trigger for table change
        selTable.addEventListener('change', function() {
            const table = this.value;
            if (!table) {
                colGroup.classList.add('hidden');
                ruleBuilderGroup.classList.add('hidden');
                vectorSource.clear();
                return;
            }
            loadTableMetadata(table, null);
        });

        selColumn.addEventListener('change', function() {
            if (this.value) {
                ruleBuilderGroup.classList.remove('hidden');
                if (rulesContainer.children.length === 0) {
                    addDefaultRanges();
                } else {
                    updateStylesAndSLD();
                }
            } else {
                ruleBuilderGroup.classList.add('hidden');
            }
        });

        // Add Rule Event
        btnAddRule.addEventListener('click', () => {
            addRuleRow('', '', getRandomColor());
        });

        function getRandomColor() {
            const colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#6366f1'];
            return colors[Math.floor(Math.random() * colors.length)];
        }

        function addDefaultRanges() {
            rulesContainer.innerHTML = '';
            addRuleRow(0, 100, '#3b82f6');
            addRuleRow(100, 500, '#10b981');
            addRuleRow(500, 1000, '#f59e0b');
            addRuleRow(1000, 99999, '#ef4444');
        }

        let ruleIndex = 0;
        function addRuleRow(min = '', max = '', color = '#3b82f6') {
            const row = document.createElement('div');
            row.className = 'flex items-center space-x-2 bg-white p-2 rounded-lg border border-gray-100 shadow-[0_1px_2px_rgba(0,0,0,0.01)] rule-row';
            row.dataset.index = ruleIndex;
            
            row.innerHTML = `
                <div class="flex-1 grid grid-cols-2 gap-2">
                    <div>
                        <input type="number" step="any" placeholder="Min" value="${min}" class="w-full text-[11px] px-2 py-1 border border-gray-200 rounded focus:outline-none focus:ring-1 focus:ring-blue-400 rule-min" required>
                    </div>
                    <div>
                        <input type="number" step="any" placeholder="Max" value="${max}" class="w-full text-[11px] px-2 py-1 border border-gray-200 rounded focus:outline-none focus:ring-1 focus:ring-blue-400 rule-max" required>
                    </div>
                </div>
                <div class="flex items-center space-x-1">
                    <input type="color" value="${color}" class="w-8 h-7 p-0.5 border border-gray-200 rounded cursor-pointer rule-color">
                    <button type="button" class="p-1 text-red-500 hover:text-red-700 hover:bg-red-50 rounded btn-delete-rule">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            `;
            
            row.querySelector('.rule-min').addEventListener('input', updateStylesAndSLD);
            row.querySelector('.rule-max').addEventListener('input', updateStylesAndSLD);
            row.querySelector('.rule-color').addEventListener('input', updateStylesAndSLD);
            
            row.querySelector('.btn-delete-rule').addEventListener('click', function() {
                row.remove();
                updateStylesAndSLD();
            });
            
            rulesContainer.appendChild(row);
            ruleIndex++;
            updateStylesAndSLD();
        }

        function hexToRgba(hex, alpha) {
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }

        // OpenLayers Style function
        const styleCache = {};
        function previewStyleFunction(feature) {
            const columnName = selColumn.value;
            if (!columnName) return getDefaultStyle();

            const value = feature.get(columnName);
            let color = '#cccccc';
            
            if (value !== undefined && value !== null) {
                const valNum = parseFloat(value);
                const rows = rulesContainer.querySelectorAll('.rule-row');
                
                for (const row of rows) {
                    const min = parseFloat(row.querySelector('.rule-min').value);
                    const max = parseFloat(row.querySelector('.rule-max').value);
                    const rowColor = row.querySelector('.rule-color').value;

                    if (!isNaN(valNum) && !isNaN(min) && !isNaN(max)) {
                        if (valNum >= min && valNum < max) {
                            color = rowColor;
                            break;
                        }
                    }
                }
            }

            if (!styleCache[color]) {
                styleCache[color] = new ol.style.Style({
                    fill: new ol.style.Fill({
                        color: hexToRgba(color, 0.7)
                    }),
                    stroke: new ol.style.Stroke({
                        color: '#333333',
                        width: 1
                    })
                });
            }

            return styleCache[color];
        }

        function getDefaultStyle() {
            return new ol.style.Style({
                fill: new ol.style.Fill({
                    color: 'rgba(59, 130, 246, 0.5)'
                }),
                stroke: new ol.style.Stroke({
                    color: '#2563eb',
                    width: 1
                })
            });
        }

        function updateStylesAndSLD() {
            const columnName = selColumn.value;
            const tableName = selTable.value;
            if (!columnName || !tableName) return;

            const ranges = [];
            const rows = rulesContainer.querySelectorAll('.rule-row');
            
            rows.forEach(row => {
                const min = row.querySelector('.rule-min').value;
                const max = row.querySelector('.rule-max').value;
                const color = row.querySelector('.rule-color').value;
                if (min !== '' && max !== '') {
                    ranges.push({ min, max, color });
                }
            });

            const rulesObj = {
                column: columnName,
                ranges: ranges
            };
            styleRulesInput.value = JSON.stringify(rulesObj);

            const sldXml = generateSLDXML(tableName, columnName, ranges);
            sldPreview.textContent = sldXml;

            for (const key in styleCache) delete styleCache[key];
            if (vectorLayer) {
                vectorLayer.changed();
            }
        }

        function initMap() {
            vectorSource = new ol.source.Vector();
            vectorLayer = new ol.layer.Vector({
                source: vectorSource,
                style: previewStyleFunction
            });

            const popupEl = document.getElementById('preview-popup');
            popupOverlay = new ol.Overlay({
                element: popupEl,
                autoPan: {
                    animation: {
                        duration: 250,
                    },
                },
            });

            map = new ol.Map({
                target: 'preview-map',
                layers: [
                    new ol.layer.Tile({
                        source: new ol.source.OSM()
                    }),
                    vectorLayer
                ],
                overlays: [popupOverlay],
                view: new ol.View({
                    center: ol.proj.fromLonLat([112.5, -7.5]),
                    zoom: 8
                })
            });

            map.on('singleclick', function(evt) {
                const feature = map.forEachFeatureAtPixel(evt.pixel, function(feature) {
                    return feature;
                });

                if (feature) {
                    const props = feature.getProperties();
                    const cleanProps = { ...props };
                    delete cleanProps.geometry;
                    delete cleanProps.geom;

                    const nameInfo = getFeatureName(cleanProps);
                    
                    document.getElementById('preview-popup-title').innerText = nameInfo.value;
                    
                    let tableHtml = '<table class="w-full text-[10px] mt-1 border-collapse">';
                    for (const key in cleanProps) {
                        tableHtml += `
                            <tr class="border-b border-gray-50">
                                <td class="font-semibold text-gray-500 py-0.5 pr-2 truncate max-w-[80px]">${key}</td>
                                <td class="text-gray-700 py-0.5 truncate max-w-[120px]" title="${cleanProps[key]}">${cleanProps[key]}</td>
                            </tr>
                        `;
                    }
                    tableHtml += '</table>';
                    
                    document.getElementById('preview-popup-content').innerHTML = tableHtml;
                    popupOverlay.setPosition(evt.coordinate);
                    popupEl.classList.remove('hidden');
                } else {
                    popupEl.classList.add('hidden');
                }
            });
        }

        function getFeatureName(properties) {
            const nameKeys = ['nama', 'name', 'desa', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi'];
            for (const key of nameKeys) {
                for (const prop in properties) {
                    if (prop.toLowerCase() === key) {
                        return { key: prop, value: properties[prop] };
                    }
                }
            }
            for (const prop in properties) {
                if (prop.toLowerCase().includes('nama') || prop.toLowerCase().includes('name')) {
                    return { key: prop, value: properties[prop] };
                }
            }
            const keys = Object.keys(properties);
            if (keys.length > 0) {
                return { key: keys[0], value: properties[keys[0]] };
            }
            return { key: 'Fitur', value: 'Detail Fitur' };
        }

        function generateSLDXML(tableName, columnName, ranges) {
            let sld = `<?xml version="1.0" encoding="UTF-8"?>
<StyledLayerDescriptor version="1.0.0" 
    xsi:schemaLocation="http://www.opengis.net/sld StyledLayerDescriptor.xsd" 
    xmlns="http://www.opengis.net/sld" 
    xmlns:ogc="http://www.opengis.net/ogc" 
    xmlns:xlink="http://www.w3.org/1999/xlink" 
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  <NamedLayer>
    <Name>${escapeXml(tableName)}</Name>
    <UserStyle>
      <Title>Choropleth Style for ${escapeXml(columnName)}</Title>
      <FeatureTypeStyle>`;

            ranges.forEach((range, idx) => {
                const min = escapeXml(range.min);
                const max = escapeXml(range.max);
                const color = escapeXml(range.color);
                const ruleName = `Rule_${idx + 1}`;

                sld += `
        <Rule>
          <Name>${ruleName}</Name>
          <Title>Range ${min} - ${max}</Title>
          <ogc:Filter>
            <ogc:And>
              <ogc:PropertyIsGreaterThanOrEqualTo>
                <ogc:PropertyName>${escapeXml(columnName)}</ogc:PropertyName>
                <ogc:Literal>${min}</ogc:Literal>
              </ogc:PropertyIsGreaterThanOrEqualTo>
              <ogc:PropertyIsLessThan>
                <ogc:PropertyName>${escapeXml(columnName)}</ogc:PropertyName>
                <ogc:Literal>${max}</ogc:Literal>
              </ogc:PropertyIsLessThan>
            </ogc:And>
          </ogc:Filter>
          <PolygonSymbolizer>
            <Fill>
              <CssParameter name="fill">${color}</CssParameter>
              <CssParameter name="fill-opacity">0.7</CssParameter>
            </Fill>
            <Stroke>
              <CssParameter name="stroke">#333333</CssParameter>
              <CssParameter name="stroke-width">1</CssParameter>
            </Stroke>
          </PolygonSymbolizer>
        </Rule>`;
            });

            sld += `
      </FeatureTypeStyle>
    </UserStyle>
  </NamedLayer>
</StyledLayerDescriptor>`;

            return sld;
        }

        function escapeXml(unsafe) {
            if (unsafe === undefined || unsafe === null) return '';
            return unsafe.toString().replace(/[<>&'"]/g, function (c) {
                switch (c) {
                    case '<': return '&lt;';
                    case '>': return '&gt;';
                    case '&': return '&amp;';
                    case '\'': return '&apos;';
                    case '"': return '&quot;';
                }
            });
        }
    });
</script>
@endpush
