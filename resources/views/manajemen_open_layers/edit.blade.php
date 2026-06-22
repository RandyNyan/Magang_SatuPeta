@extends('layouts.admin')

@section('title', 'Edit Open Layer')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.css" />
<style>
    .leaflet-container { z-index: 1 !important; }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <div class="flex items-center space-x-2">
        <a href="{{ route('manajemen.open-layers') }}" class="text-xs text-gray-400 hover:text-blue-600 transition">&larr; Kembali ke daftar</a>
    </div>

    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-tight">Edit Open Layer: {{ $openLayer->nama_layer }}</h2>
        <p class="text-xs text-gray-500">Edit informasi layer atau edit gambar koordinat langsung dari peta.</p>
    </div>

    <form action="{{ route('manajemen.open-layers.update', $openLayer->id) }}" method="POST" id="layerForm" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        
        <!-- Sidebar Input Form -->
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)] space-y-4">
            <div>
                <label for="nama_layer" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Layer</label>
                <input type="text" name="nama_layer" id="nama_layer" required value="{{ old('nama_layer', $openLayer->nama_layer) }}"
                       class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                @error('nama_layer')
                    <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="tipe_layer" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tipe Geometri</label>
                <select name="tipe_layer" id="tipe_layer" required
                        class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                    <option value="Polygon" {{ old('tipe_layer', $openLayer->tipe_layer) === 'Polygon' ? 'selected' : '' }}>Polygon (Area/Bidang)</option>
                    <option value="Point" {{ old('tipe_layer', $openLayer->tipe_layer) === 'Point' ? 'selected' : '' }}>Point (Titik Koordinat)</option>
                    <option value="Line" {{ old('tipe_layer', $openLayer->tipe_layer) === 'Line' ? 'selected' : '' }}>Line (Garis/Jaringan)</option>
                </select>
                @error('tipe_layer')
                    <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="3"
                          class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">{{ old('deskripsi', $openLayer->deskripsi) }}</textarea>
                @error('deskripsi')
                    <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <input type="hidden" name="geojson" id="geojson_input">
            @error('geojson')
                <div class="p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded-lg">
                    Silakan gambar minimal satu objek pada peta sebelum menyimpan.
                </div>
            @enderror

            <div class="pt-2">
                <button type="submit" class="w-full bg-[#008cf8] hover:bg-[#007ee0] text-white py-2 rounded-lg text-xs font-bold shadow-sm transition">
                    Perbarui Layer
                </button>
            </div>
        </div>

        <!-- Peta Editor (Leaflet + Geoman) -->
        <div class="lg:col-span-2 space-y-2">
            <div class="flex justify-between items-center bg-gray-50 px-2 py-1 rounded">
                <span class="text-[11px] text-gray-500 font-medium">Visualisasi Canvas Peta Jawa Timur</span>
                <span id="shape-counter" class="text-[10px] bg-blue-100 text-blue-800 font-bold px-2 py-0.5 rounded-full">0 Objek Tergambar</span>
            </div>
            <div id="editor-map" class="h-[480px] w-full rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)]"></div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.min.js"></script>
<script>
    // Initialize map centered at Jawa Timur
    var map = L.map('editor-map').setView([-7.7, 112.5], 8);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Setup Leaflet Geoman Drawing controls
    map.pm.addControls({
        position: 'topleft',
        drawMarker: false,
        drawPolyline: false,
        drawRectangle: false,
        drawPolygon: false,
        drawCircle: false,
        editMode: true,
        dragMode: true,
        cutPolygon: false,
        removalMode: true,
    });

    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    var tipeLayerSelect = document.getElementById('tipe_layer');
    var geojsonInput = document.getElementById('geojson_input');
    var shapeCounter = document.getElementById('shape-counter');

    // Function to configure drawing toolbar based on select dropdown
    function updateDrawingControls() {
        var tipe = tipeLayerSelect.value;
        
        // Reset controls first
        map.pm.setDrawMode(false);
        map.pm.updateControls({
            drawMarker: false,
            drawPolyline: false,
            drawRectangle: false,
            drawPolygon: false
        });

        // Enable only the active one
        if (tipe === 'Point') {
            map.pm.updateControls({ drawMarker: true });
        } else if (tipe === 'Line') {
            map.pm.updateControls({ drawPolyline: true });
        } else if (tipe === 'Polygon') {
            map.pm.updateControls({ drawPolygon: true, drawRectangle: true });
        }
    }

    tipeLayerSelect.addEventListener('change', function() {
        if (drawnItems.getLayers().length > 0) {
            if (confirm('Mengubah tipe geometri akan menghapus gambar yang ada saat ini. Lanjutkan?')) {
                drawnItems.clearLayers();
                updateGeoJSONInput();
            } else {
                tipeLayerSelect.value = tipeLayerSelect.dataset.lastVal || 'Polygon';
                return;
            }
        }
        tipeLayerSelect.dataset.lastVal = tipeLayerSelect.value;
        updateDrawingControls();
    });

    tipeLayerSelect.dataset.lastVal = tipeLayerSelect.value;
    updateDrawingControls();

    // Event listener when a shape is drawn
    map.on('pm:create', function(e) {
        var layer = e.layer;
        drawnItems.addLayer(layer);
        
        var nama_fitur = prompt("Masukkan keterangan/nama untuk objek ini (Opsional):", "");
        layer.feature = layer.feature || { type: "Feature", properties: {} };
        layer.feature.properties = layer.feature.properties || {};
        if (nama_fitur) {
            layer.feature.properties.nama = nama_fitur;
        }

        updateGeoJSONInput();

        layer.on('pm:edit', updateGeoJSONInput);
        layer.on('pm:remove', updateGeoJSONInput);
    });

    // Compiling global GeoJSON
    function updateGeoJSONInput() {
        var geojson = {
            type: "FeatureCollection",
            features: []
        };

        drawnItems.eachLayer(function(layer) {
            var featureGeoJSON = layer.toGeoJSON();
            if (layer.feature && layer.feature.properties) {
                featureGeoJSON.properties = layer.feature.properties;
            }
            geojson.features.push(featureGeoJSON);
        });

        var count = geojson.features.length;
        shapeCounter.textContent = count + " Objek Tergambar";
        geojsonInput.value = JSON.stringify(geojson);
    }

    // Load existing GeoJSON features
    var rawGeoJSON = @json($openLayer->geojson);
    if (rawGeoJSON && rawGeoJSON.features) {
        L.geoJSON(rawGeoJSON, {
            onEachFeature: function(feature, layer) {
                drawnItems.addLayer(layer);
                layer.on('pm:edit', updateGeoJSONInput);
                layer.on('pm:remove', updateGeoJSONInput);
            }
        });
        
        if (drawnItems.getLayers().length > 0) {
            map.fitBounds(drawnItems.getBounds());
        }
    }

    // Initial compilation
    updateGeoJSONInput();

    // Intercept form submission
    document.getElementById('layerForm').addEventListener('submit', function(e) {
        updateGeoJSONInput();
        var data = JSON.parse(geojsonInput.value);
        if (data.features.length === 0) {
            e.preventDefault();
            alert('Silakan gambar minimal satu objek pada peta.');
        }
    });
</script>
@endpush
