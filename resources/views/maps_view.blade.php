<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Peta - Satu Peta Jatim</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        [x-cloak] { display: none !important; }
        .leaflet-container { z-index: 0 !important; }

        /* Kustomisasi Popup Leaflet agar tabelnya cantik */
        .leaflet-popup-content-wrapper { border-radius: 8px; padding: 0; overflow: hidden; }
        .leaflet-popup-content { width: auto !important; min-width: 250px; max-width: 400px; margin: 0; line-height: 1.5; }
        .custom-popup-table { width: 100%; border-collapse: collapse; font-size: 12px; }
        .custom-popup-table th { background-color: #f8fafc; padding: 8px 12px; text-align: left; color: #64748b; font-weight: 600; border-bottom: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; width: 40%; }
        .custom-popup-table td { padding: 8px 12px; color: #334155; border-bottom: 1px solid #e2e8f0; word-break: break-word; }
        .custom-popup-table tr:hover { background-color: #f1f5f9; }
    </style>
</head>
<body class="h-screen w-full overflow-hidden bg-gray-100 flex flex-col font-sans">

    <nav class="h-[60px] bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0 z-50 shadow-sm relative">
        <a href="#" class="text-xl font-bold text-blue-600 text-decoration-none flex items-center gap-2">
            🗺️ Satu Peta <span class="text-gray-500 font-normal text-sm pt-1">Jawa Timur</span>
        </a>
        <div class="flex items-center gap-6">
            <a href="#" class="text-gray-600 hover:text-blue-600 font-medium text-sm transition">Katalog</a>
            <a href="#" class="text-gray-600 hover:text-blue-600 font-medium text-sm transition">OPD</a>
            <a href="#" class="text-gray-600 hover:text-blue-600 font-medium text-sm transition">Berita</a>
            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-1.5 px-6 rounded-full transition shadow-sm">
                MASUK
            </a>
        </div>
    </nav>

    <div class="flex flex-1 h-[calc(100vh-60px)] relative" x-data="{ selectedMap: null, showRightSidebar: false, activeTab: 'informasi' }">

        <div class="w-[350px] bg-white flex flex-col flex-shrink-0 z-20 shadow-[2px_0_10px_rgba(0,0,0,0.1)] relative">
            <div class="flex px-4 pt-3 border-b border-gray-200">
                <button class="px-4 py-2 text-sm font-semibold text-blue-600 border-b-2 border-blue-600">Kategori</button>
                <button class="px-4 py-2 text-sm font-semibold text-gray-500 hover:text-gray-700">Organisasi</button>
            </div>
            <div class="p-4 border-b border-gray-100">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">🔍</span>
                    <input type="text" placeholder="Cari dataset..." class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="flex-1 overflow-y-auto">
                @foreach($kategoris as $kategori)
                <div x-data="{ open: false }" class="border-b border-gray-100">
                    <button @click="open = !open" class="w-full flex justify-between items-center p-4 hover:bg-gray-50 transition-colors focus:outline-none">
                        <span class="font-medium text-sm text-gray-800" :class="{ 'text-blue-600': open }">
                            {{ $kategori->nama_kategori }} <span class="text-gray-400 font-normal">({{ $kategori->maps_count }})</span>
                        </span>
                        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" x-cloak class="bg-gray-50 border-t border-gray-100">
                        <ul class="flex flex-col">
                            @foreach($kategori->maps as $map)
                            <li class="p-4 border-b border-gray-200 border-opacity-50 flex justify-between items-center hover:bg-blue-50/50 transition">
                                <div class="pr-3">
                                    <h4 class="text-sm font-semibold text-gray-700 leading-tight mb-1">{{ $map->judul_mapset }}</h4>
                                    <p class="text-[11px] text-gray-500">{{ $map->tipe_layer }} • {{ $map->tahun_data }}</p>
                                </div>
                                <button @click="
                                        selectedMap = {{ json_encode($map) }};
                                        selectedMap.nama_kategori = '{{ $kategori->nama_kategori }}';
                                        showRightSidebar = true;
                                        activeTab = 'informasi';
                                        addLayerToMap('{{ $map->link_openlayer }}');
                                    "
                                    class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded border border-gray-300 text-gray-500 hover:bg-blue-500 hover:text-white hover:border-blue-500 transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex-1 relative bg-gray-200 overflow-hidden flex">
            <div id="map" class="w-full h-full"></div>

            <button x-show="selectedMap" x-cloak
                    @click="showRightSidebar = !showRightSidebar"
                    class="absolute z-[400] top-1/2 transform -translate-y-1/2 bg-white border border-gray-200 shadow-md rounded-l-md p-2 hover:bg-gray-50 transition-all duration-300 flex items-center justify-center"
                    :class="showRightSidebar ? 'right-[400px]' : 'right-0'">
                <svg x-show="showRightSidebar" class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <svg x-show="!showRightSidebar" class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
        </div>

        <div x-show="showRightSidebar" x-cloak
             class="w-[400px] bg-white flex flex-col flex-shrink-0 z-20 shadow-[-2px_0_10px_rgba(0,0,0,0.1)] absolute right-0 h-full border-l border-gray-200 overflow-y-auto"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full">

            <div class="p-6 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-bold text-gray-800 leading-snug" x-text="selectedMap?.judul_mapset"></h2>
            </div>

            <div class="flex border-b border-gray-200 text-sm">
                <button @click="activeTab = 'informasi'" :class="{'bg-blue-600 text-white font-semibold': activeTab === 'informasi', 'text-gray-600 hover:bg-gray-50': activeTab !== 'informasi'}" class="flex-1 py-3 text-center transition">
                    Informasi Dataset
                </button>
                <button @click="activeTab = 'organisasi'" :class="{'bg-blue-600 text-white font-semibold': activeTab === 'organisasi', 'text-gray-600 hover:bg-gray-50': activeTab !== 'organisasi'}" class="flex-1 py-3 text-center transition">
                    Penanggung Jawab
                </button>
            </div>

            <div class="p-6 text-sm">

                <div x-show="activeTab === 'informasi'" class="space-y-4">
                    <div class="grid grid-cols-3 gap-3 border-b border-gray-100 pb-3">
                        <div class="text-gray-500 font-medium">Klasifikasi</div>
                        <div class="col-span-2 text-gray-800">Terbuka</div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 border-b border-gray-100 pb-3">
                        <div class="text-gray-500 font-medium">Deskripsi</div>
                        <div class="col-span-2 text-gray-800 text-justify" x-text="selectedMap?.deskripsi"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 border-b border-gray-100 pb-3">
                        <div class="text-gray-500 font-medium">Kategori</div>
                        <div class="col-span-2 text-gray-800" x-text="selectedMap?.nama_kategori"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 border-b border-gray-100 pb-3">
                        <div class="text-gray-500 font-medium">Skala</div>
                        <div class="col-span-2 text-gray-800" x-text="selectedMap?.skala"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 border-b border-gray-100 pb-3">
                        <div class="text-gray-500 font-medium">Sistem Proyeksi</div>
                        <div class="col-span-2 text-gray-800" x-text="selectedMap?.sistem_proyeksi"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 border-b border-gray-100 pb-3">
                        <div class="text-gray-500 font-medium">Tahun Data</div>
                        <div class="col-span-2 text-gray-800" x-text="selectedMap?.tahun_data"></div>
                    </div>
                </div>

                <div x-show="activeTab === 'organisasi'" x-cloak class="space-y-4">
                    <div class="grid grid-cols-3 gap-3 border-b border-gray-100 pb-3">
                        <div class="text-gray-500 font-medium">Nama Organisasi</div>
                        <div class="col-span-2 text-gray-800 font-semibold" x-text="selectedMap?.organisasi?.nama || selectedMap?.organisasi?.nama_organisasi || '-'"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 border-b border-gray-100 pb-3">
                        <div class="text-gray-500 font-medium">Deskripsi</div>
                        <div class="col-span-2 text-gray-800 text-justify" x-text="selectedMap?.organisasi?.deskripsi || '-'"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 border-b border-gray-100 pb-3">
                        <div class="text-gray-500 font-medium">Alamat</div>
                        <div class="col-span-2 text-gray-800" x-text="selectedMap?.organisasi?.alamat || '-'"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 border-b border-gray-100 pb-3">
                        <div class="text-gray-500 font-medium">Telepon</div>
                        <div class="col-span-2 text-gray-800" x-text="selectedMap?.organisasi?.telepon || '-'"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 border-b border-gray-100 pb-3">
                        <div class="text-gray-500 font-medium">Email</div>
                        <div class="col-span-2 text-gray-800" x-text="selectedMap?.organisasi?.email || '-'"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 border-b border-gray-100 pb-3">
                        <div class="text-gray-500 font-medium">Website</div>
                        <div class="col-span-2 text-blue-600 hover:underline">
                            <a :href="selectedMap?.organisasi?.website" target="_blank" x-text="selectedMap?.organisasi?.website || '-'"></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map = L.map('map', { zoomControl: false }).setView([-7.7, 112.5], 8);

        // Posisi zoom diatur sedikit ke bawah supaya tidak tertutup header popup jika panjang
        L.control.zoom({ position: 'topleft' }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var activeWmsLayer = null;
        var activeGeoJsonLayer = null;
        var currentWmsBaseUrl = '';
        var currentWmsLayerName = '';

        function addLayerToMap(link_openlayer) {
            // Clean up previous layers
            if (activeWmsLayer) {
                map.removeLayer(activeWmsLayer);
                activeWmsLayer = null;
            }
            if (activeGeoJsonLayer) {
                map.removeLayer(activeGeoJsonLayer);
                activeGeoJsonLayer = null;
            }
            currentWmsLayerName = '';
            currentWmsBaseUrl = '';

            // Detect if PostgreSQL local API route is used
            if (link_openlayer.includes('/geojson')) {
                fetch(link_openlayer)
                    .then(response => response.json())
                    .then(data => {
                        activeGeoJsonLayer = L.geoJSON(data, {
                            style: function (feature) {
                                return {
                                    color: '#2563eb', // Blue line/border
                                    weight: 3,
                                    opacity: 0.8,
                                    fillColor: '#3b82f6', // Light blue fill
                                    fillOpacity: 0.4
                                };
                            },
                            pointToLayer: function (feature, latlng) {
                                return L.marker(latlng);
                            },
                            onEachFeature: function (feature, layer) {
                                if (feature.properties) {
                                    var html = '<div style="max-height: 250px; overflow-y: auto;">';
                                    html += '<table class="custom-popup-table">';
                                    for (var key in feature.properties) {
                                        var cleanKey = key.replace(/_/g, ' ');
                                        html += '<tr>';
                                        html += '<th>' + cleanKey + '</th>';
                                        html += '<td>' + (feature.properties[key] !== null ? feature.properties[key] : '-') + '</td>';
                                        html += '</tr>';
                                    }
                                    html += '</table></div>';
                                    layer.bindPopup(html);
                                }
                            }
                        }).addTo(map);

                        // Fit map bounds to show drawn elements
                        if (activeGeoJsonLayer.getBounds().isValid()) {
                            map.fitBounds(activeGeoJsonLayer.getBounds());
                        }
                    })
                    .catch(error => {
                        console.error('Error loading PostgreSQL GeoJSON layer:', error);
                    });
            } else {
                // WMS flow
                const urlParams = new URLSearchParams(link_openlayer.split('?')[1]);
                currentWmsLayerName = urlParams.get('layers');
                currentWmsBaseUrl = link_openlayer.split('?')[0];

                if(!currentWmsLayerName) return;

                activeWmsLayer = L.tileLayer.wms(currentWmsBaseUrl, {
                    layers: currentWmsLayerName,
                    format: 'image/png',
                    transparent: true,
                    version: '1.1.0'
                });

                activeWmsLayer.addTo(map);
            }
        }

        // PERBAIKAN: Minta output JSON dari GeoServer dan buat tabel secara manual
        map.on('click', function(e) {
            if (!activeWmsLayer || !currentWmsBaseUrl || !currentWmsLayerName) return;

            var bounds = map.getBounds();
            var bbox = bounds.getSouthWest().lng + ',' + bounds.getSouthWest().lat + ',' + bounds.getNorthEast().lng + ',' + bounds.getNorthEast().lat;
            var width = map.getSize().x;
            var height = map.getSize().y;
            var x = Math.round(map.layerPointToContainerPoint(e.layerPoint).x);
            var y = Math.round(map.layerPointToContainerPoint(e.layerPoint).y);

            // Ganti format permintaan menjadi application/json
            var url = currentWmsBaseUrl + '?SERVICE=WMS&VERSION=1.1.1&REQUEST=GetFeatureInfo' +
                      '&LAYERS=' + currentWmsLayerName +
                      '&QUERY_LAYERS=' + currentWmsLayerName +
                      '&BBOX=' + bbox +
                      '&FEATURE_COUNT=1' +
                      '&HEIGHT=' + height + '&WIDTH=' + width +
                      '&INFO_FORMAT=application/json' +
                      '&SRS=EPSG:4326' +
                      '&X=' + x + '&Y=' + y;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Cek jika GeoServer menemukan data (features array tidak kosong)
                    if (data && data.features && data.features.length > 0) {
                        var properties = data.features[0].properties;

                        // Membuat elemen tabel HTML custom
                        var html = '<div style="max-height: 250px; overflow-y: auto;">';
                        html += '<table class="custom-popup-table">';

                        for (var key in properties) {
                            // Abaikan kolom sistem seperti fid atau bbox agar lebih rapi
                            if(key === 'bbox' || key === 'fid') continue;

                            // Format header tabel agar lebih bersih (menghilangkan underscore)
                            var cleanKey = key.replace(/_/g, ' ');

                            html += '<tr>';
                            html += '<th>' + cleanKey + '</th>';
                            html += '<td>' + (properties[key] !== null ? properties[key] : '-') + '</td>';
                            html += '</tr>';
                        }

                        html += '</table></div>';

                        L.popup()
                            .setLatLng(e.latlng)
                            .setContent(html)
                            .openOn(map);
                    }
                })
                .catch(error => {
                    console.error('Error fetching GetFeatureInfo (JSON):', error);
                });
        });
    </script>
</body>
</html>
