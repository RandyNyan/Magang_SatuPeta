<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Peta - Smart Facility Map</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- OpenLayers CSS and JS CDNs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v8.2.0/ol.css">
    <script src="https://cdn.jsdelivr.net/npm/ol@v8.2.0/dist/ol.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .ol-popup {
            min-width: 280px;
            max-width: 400px;
        }
        /* Custom Popup Styling */
        .custom-popup-table { width: 100%; border-collapse: collapse; font-size: 12px; }
        .custom-popup-table th { background-color: #f8fafc; padding: 8px 12px; text-align: left; color: #64748b; font-weight: 600; border-bottom: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; width: 40%; }
        .custom-popup-table td { padding: 8px 12px; color: #334155; border-bottom: 1px solid #e2e8f0; word-break: break-word; }
        .custom-popup-table tr:hover { background-color: #f1f5f9; }
    </style>
</head>
<body class="h-screen w-full overflow-hidden bg-gray-100 flex flex-col font-sans">

    <nav class="h-[60px] bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0 z-50 shadow-sm relative">
        <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600 text-decoration-none flex items-center gap-2 hover:opacity-80 transition">
            <svg class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
            </svg>
            <span class="font-bold text-lg tracking-tight text-gray-800">Smart Facility Map</span>
        </a>
        <div class="flex items-center gap-6">
            <a href="#" class="text-gray-600 hover:text-blue-600 font-medium text-sm transition">Katalog</a>
            <a href="#" class="text-gray-600 hover:text-blue-600 font-medium text-sm transition">Instansi</a>
            <a href="#" class="text-gray-600 hover:text-blue-600 font-medium text-sm transition">Berita</a>
            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-1.5 px-6 rounded-full transition shadow-sm">
                MASUK
            </a>
        </div>
    </nav>

    <div class="flex flex-1 h-[calc(100vh-60px)] relative" x-data="{ selectedMap: null, showRightSidebar: false, activeTab: 'informasi', viewMode: 'kategori' }">

        <div class="w-[350px] bg-white flex flex-col flex-shrink-0 z-20 shadow-[2px_0_10px_rgba(0,0,0,0.1)] relative">
            <div class="flex px-4 pt-3 border-b border-gray-200">
                <button @click="viewMode = 'kategori'" :class="viewMode === 'kategori' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-semibold transition focus:outline-none">Kategori</button>
                <button @click="viewMode = 'instansi'" :class="viewMode === 'instansi' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-semibold transition focus:outline-none">Instansi</button>
            </div>
            <div class="p-4 border-b border-gray-100">
                <form action="{{ route('katalog.peta') }}" method="GET" class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">🔍</span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari dataset..." class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                </form>
            </div>

            <div class="flex-1 overflow-y-auto">
                <div x-show="viewMode === 'kategori'">
                    @foreach($kategoris as $kategori)
                    <div x-data="{ open: {{ request('q') ? 'true' : 'false' }} }" class="border-b border-gray-100">
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
                                            selectedMap = @js($map);
                                            selectedMap.nama_kategori = @js($kategori->nama_kategori);
                                            showRightSidebar = true;
                                            activeTab = 'informasi';
                                            displayMapLayer(selectedMap);
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

                <div x-show="viewMode === 'instansi'" x-cloak>
                    @foreach($organisasis as $org)
                    <div x-data="{ open: {{ request('q') ? 'true' : 'false' }} }" class="border-b border-gray-100">
                        <button @click="open = !open" class="w-full flex justify-between items-center p-4 hover:bg-gray-50 transition-colors focus:outline-none">
                            <span class="font-medium text-sm text-gray-800" :class="{ 'text-blue-600': open }">
                                {{ $org->nama }} <span class="text-gray-400 font-normal">({{ $org->maps_count }})</span>
                            </span>
                            <svg :class="{ 'rotate-180': open }" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" x-cloak class="bg-gray-50 border-t border-gray-100">
                            <ul class="flex flex-col">
                                @foreach($org->maps as $map)
                                <li class="p-4 border-b border-gray-200 border-opacity-50 flex justify-between items-center hover:bg-blue-50/50 transition">
                                    <div class="pr-3">
                                        <h4 class="text-sm font-semibold text-gray-700 leading-tight mb-1">{{ $map->judul_mapset }}</h4>
                                        <p class="text-[11px] text-gray-500">{{ $map->tipe_layer }} • {{ $map->tahun_data }}</p>
                                    </div>
                                    <button @click="
                                            selectedMap = @js($map);
                                            selectedMap.nama_kategori = @js($map->kategori->nama_kategori ?? '-');
                                            selectedMap.organisasi = @js($org);
                                            showRightSidebar = true;
                                            activeTab = 'informasi';
                                            displayMapLayer(selectedMap);
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
        </div>

        <div class="flex-1 relative bg-gray-200 overflow-hidden">
            <!-- Map Container -->
            <div id="map" class="absolute inset-0 w-full h-full"></div>

            <!-- OpenLayers Overlay Popup Element -->
            <div id="popup" class="ol-popup absolute bg-white rounded-lg shadow-lg border border-gray-200 hidden z-50 overflow-hidden">
                <a href="#" id="popup-closer" class="absolute top-2.5 right-3 text-gray-400 hover:text-gray-600 text-lg font-bold leading-none">&times;</a>
                <div id="popup-content" class="p-4"></div>
            </div>

            <!-- Legend UI -->
            <div id="map-legend" class="absolute bottom-6 left-6 z-40 bg-white/95 backdrop-blur p-4 rounded-xl shadow-lg border border-gray-100 hidden max-w-[250px]">
                <h4 class="text-xs font-extrabold text-gray-800 border-b border-gray-100 pb-2 mb-3 tracking-wide" id="legend-title">Legenda</h4>
                <div id="legend-content" class="space-y-2.5 max-h-[200px] overflow-y-auto pr-2 custom-scrollbar"></div>
            </div>

            <button x-show="selectedMap" x-cloak
                    @click="showRightSidebar = !showRightSidebar"
                    class="absolute z-20 top-1/2 transform -translate-y-1/2 bg-white border border-gray-200 shadow-md rounded-l-md p-2 hover:bg-gray-50 transition-all duration-300 flex items-center justify-center"
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
                        <div class="text-gray-500 font-medium">Nama Instansi</div>
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

    <script>
        // Initialize OpenLayers Map
        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([112.5, -7.7]),
                zoom: 8
            })
        });

        // Setup OpenLayers Popup Overlay
        var container = document.getElementById('popup');
        var content = document.getElementById('popup-content');
        var closer = document.getElementById('popup-closer');

        var overlay = new ol.Overlay({
            element: container,
            autoPan: {
                animation: {
                    duration: 250,
                },
            },
        });
        map.addOverlay(overlay);

        closer.onclick = function () {
            overlay.setPosition(undefined);
            container.classList.add('hidden');
            closer.blur();
            return false;
        };

        var activeWmsLayer = null;
        var activePgsqlLayer = null;
        var activeTextLayer = null;
        var currentWmsBaseUrl = '';
        var currentWmsLayerName = '';
        var wmsSource = null;

        function displayMapLayer(mapData) {
            // Close any open popup
            overlay.setPosition(undefined);
            container.classList.add('hidden');

            // Clean up previous layers
            if (activeWmsLayer) {
                map.removeLayer(activeWmsLayer);
                activeWmsLayer = null;
            }
            if (activePgsqlLayer) {
                map.removeLayer(activePgsqlLayer);
                activePgsqlLayer = null;
            }
            if (activeTextLayer) {
                map.removeLayer(activeTextLayer);
                activeTextLayer = null;
            }

            if (mapData.sumber_peta === 'pgsql') {
                const table = mapData.pgsql_table || (mapData.open_layer ? mapData.open_layer.pgsql_table : null);
                if (!table) return;

                let rules = mapData.open_layer ? mapData.open_layer.style_rules : mapData.style_rules;
                if (typeof rules === 'string') {
                    try {
                        rules = JSON.parse(rules);
                    } catch(e) {
                        rules = null;
                    }
                }
                
                renderLegend(rules);

                const vectorSource = new ol.source.Vector();

                // Fetch GeoJSON manually to ensure projection transformation
                fetch(`/api/spatial/geojson/${table}`)
                    .then(response => response.json())
                    .then(data => {
                        const format = new ol.format.GeoJSON();
                        const features = format.readFeatures(data, {
                            dataProjection: 'EPSG:4326',
                            featureProjection: 'EPSG:3857'
                        });
                        vectorSource.addFeatures(features);
                        
                        // Zoom to features once loaded
                        if (features.length > 0) {
                            const extent = vectorSource.getExtent();
                            if (!ol.extent.isEmpty(extent)) {
                                map.getView().fit(extent, {
                                    size: map.getSize(),
                                    duration: 1000,
                                    padding: [40, 40, 40, 40]
                                });
                            }
                        }
                    })
                    .catch(err => console.error("Error loading GeoJSON:", err));

                const styleFn = createPgsqlStyleFunction(rules);

                activePgsqlLayer = new ol.layer.Vector({
                    source: vectorSource,
                    style: styleFn
                });

                map.addLayer(activePgsqlLayer);
            } else {
                const link = mapData.link_openlayer;
                if (!link) return;

                let rules = mapData.open_layer ? mapData.open_layer.style_rules : mapData.style_rules;
                if (typeof rules === 'string') {
                    try {
                        rules = JSON.parse(rules);
                    } catch(e) {
                        rules = null;
                    }
                }
                renderLegend(rules, mapData);

                const urlParams = new URLSearchParams(link.split('?')[1]);
                currentWmsLayerName = urlParams.get('layers');
                currentWmsBaseUrl = link.split('?')[0];

                if (!currentWmsLayerName) return;

                let wmsParams = {
                    'LAYERS': currentWmsLayerName,
                    'TILED': true,
                    'VERSION': '1.1.0',
                    'FORMAT': 'image/png',
                    'TRANSPARENT': true
                };

                // Add SLD_BODY if we have generated SLD for WMS (optional, usually WMS uses predefined server styles)
                if (mapData.open_layer && mapData.open_layer.sld_style) {
                    wmsParams['SLD_BODY'] = mapData.open_layer.sld_style;
                }

                wmsSource = new ol.source.TileWMS({
                    url: currentWmsBaseUrl,
                    params: wmsParams,
                    serverType: 'geoserver',
                    transition: 0
                });

                activeWmsLayer = new ol.layer.Tile({
                    source: wmsSource
                });

                map.addLayer(activeWmsLayer);

                // Automatically pan and fit the map view to the layer's bbox
                var bboxParam = urlParams.get('bbox');
                if (bboxParam) {
                    var coords = bboxParam.split(',').map(Number); // minLon, minLat, maxLon, maxLat
                    var extent = ol.proj.transformExtent(coords, 'EPSG:4326', 'EPSG:3857');
                    map.getView().fit(extent, { size: map.getSize(), duration: 1000 });
                }

                // Fallback to fetch WFS for labels if it's WMS
                if (currentWmsBaseUrl.includes('/wms')) {
                    const wfsUrl = currentWmsBaseUrl.replace('/wms', '/wfs') + '?service=WFS&version=1.0.0&request=GetFeature&typeName=' + currentWmsLayerName + '&outputFormat=application/json';
                    fetch(wfsUrl)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.features) {
                                const format = new ol.format.GeoJSON();
                                const features = format.readFeatures(data, {
                                    dataProjection: 'EPSG:4326',
                                    featureProjection: 'EPSG:3857'
                                });
                                
                                const textSource = new ol.source.Vector({ features: features });
                                activeTextLayer = new ol.layer.Vector({
                                    source: textSource,
                                    style: function(feature) {
                                        const textLabel = getFeatureName(feature.getProperties()).value;
                                        return new ol.style.Style({
                                            text: new ol.style.Text({
                                                font: 'bold 11px Inter, Calibri, sans-serif',
                                                fill: new ol.style.Fill({ color: '#1f2937' }),
                                                stroke: new ol.style.Stroke({ color: '#ffffff', width: 3 }),
                                                text: textLabel,
                                                overflow: true
                                            }),
                                            geometry: function(feature) {
                                                const geom = feature.getGeometry();
                                                if (!geom) return null;
                                                if (geom.getType() === 'Polygon') {
                                                    return geom.getInteriorPoint();
                                                } else if (geom.getType() === 'MultiPolygon') {
                                                    const ext = geom.getExtent();
                                                    return new ol.geom.Point(ol.extent.getCenter(ext));
                                                }
                                                return geom;
                                            }
                                        });
                                    }
                                });
                                map.addLayer(activeTextLayer);
                            }
                        })
                        .catch(err => console.error("Error loading WFS for labels:", err));
                }
            }
        }

        function renderLegend(rules, mapData = null) {
            const legendContainer = document.getElementById('map-legend');
            
            // WMS Legend
            if (mapData && mapData.sumber_peta === 'wms') {
                const link = mapData.link_openlayer;
                if (link) {
                    const urlParams = new URLSearchParams(link.split('?')[1]);
                    const layerName = urlParams.get('layers');
                    const baseUrl = link.split('?')[0];
                    if (layerName && baseUrl) {
                        const legendUrl = `${baseUrl}?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=${layerName}`;
                        legendContainer.classList.remove('hidden');
                        document.getElementById('legend-title').innerText = 'Legenda';
                        document.getElementById('legend-content').innerHTML = `<img src="${legendUrl}" alt="Legend">`;
                        return;
                    }
                }
            }

            if (rules && rules.ranges && rules.ranges.length > 0) {
                legendContainer.classList.remove('hidden');
                document.getElementById('legend-title').innerText = rules.column || 'Legenda';
                let legendHtml = '';
                rules.ranges.forEach(r => {
                    let symbol = '';
                    const colorOrUrl = r.icon_url || r.color;
                    if (rules.geom_type === 'Point') {
                        symbol = `<img src="${colorOrUrl}" class="w-5 h-5 object-contain">`;
                    } else if (rules.geom_type === 'Line') {
                        symbol = `<div class="w-5 h-1.5 mt-1.5 rounded-sm" style="background-color: ${colorOrUrl}"></div>`;
                    } else {
                        symbol = `<div class="w-5 h-5 border border-gray-300 rounded-sm shadow-sm" style="background-color: ${colorOrUrl}"></div>`;
                    }
                    legendHtml += `
                        <div class="flex items-center space-x-3 text-[11px] font-medium text-gray-700">
                            ${symbol}
                            <span>${r.min} - ${r.max}</span>
                        </div>`;
                });
                document.getElementById('legend-content').innerHTML = legendHtml;
            } else {
                legendContainer.classList.add('hidden');
            }
        }

        // Color ranges styling function for pgsql layers
        function createPgsqlStyleFunction(styleRules) {
            const styleCache = {};
            const geomType = styleRules ? (styleRules.geom_type || 'Polygon') : 'Polygon';
            
            return function (feature) {
                const textLabel = getFeatureName(feature.getProperties()).value;

                if (!styleRules || !styleRules.column) {
                    const defaultKey = 'default_' + textLabel;
                    if (!styleCache[defaultKey]) {
                        styleCache[defaultKey] = createStyleObject(geomType, '#3b82f6', textLabel, true);
                    }
                    return styleCache[defaultKey];
                }

                const value = feature.get(styleRules.column);
                let colorOrUrl = geomType === 'Point' ? 'https://cdn-icons-png.flaticon.com/512/684/684908.png' : '#cccccc';
                
                if (value !== undefined && value !== null) {
                    const valNum = parseFloat(value);
                    const ranges = styleRules.ranges || [];

                    for (const range of ranges) {
                        const min = parseFloat(range.min);
                        const max = parseFloat(range.max);
                        if (!isNaN(valNum) && !isNaN(min) && !isNaN(max)) {
                            if (valNum >= min && valNum < max) {
                                colorOrUrl = geomType === 'Point' ? (range.icon_url || range.color) : range.color;
                                break;
                            }
                        }
                    }
                }

                const cacheKey = colorOrUrl + '_' + textLabel;

                if (!styleCache[cacheKey]) {
                    styleCache[cacheKey] = createStyleObject(geomType, colorOrUrl, textLabel, false);
                }

                return styleCache[cacheKey];
            };
        }

        function createStyleObject(geomType, colorOrUrl, textLabel, isDefault) {
            const textStyle = new ol.style.Text({
                font: 'bold 11px Inter, Calibri, sans-serif',
                fill: new ol.style.Fill({ color: '#1f2937' }),
                stroke: new ol.style.Stroke({ color: '#ffffff', width: 3 }),
                text: geomType === 'Polygon' ? textLabel : '', // Only show label heavily on Polygon to avoid clutter, or maybe Point too? The user said "Khusus untuk layer bertipe Polygon"
                overflow: true
            });

            if (geomType === 'Point') {
                return new ol.style.Style({
                    image: new ol.style.Icon({
                        src: colorOrUrl,
                        scale: 0.08,
                        crossOrigin: 'anonymous'
                    }),
                    text: new ol.style.Text({
                        font: 'bold 11px Inter, Calibri, sans-serif',
                        fill: new ol.style.Fill({ color: '#1f2937' }),
                        stroke: new ol.style.Stroke({ color: '#ffffff', width: 3 }),
                        text: textLabel,
                        offsetY: 15
                    })
                });
            } else if (geomType === 'Line') {
                return new ol.style.Style({
                    stroke: new ol.style.Stroke({ color: colorOrUrl, width: 3 })
                });
            } else {
                // Polygon
                const fillAlpha = isDefault ? 0.5 : 0.7;
                return [
                    new ol.style.Style({
                        fill: new ol.style.Fill({ color: hexToRgba(colorOrUrl, fillAlpha) }),
                        stroke: new ol.style.Stroke({ color: '#333333', width: 1 })
                    }),
                    new ol.style.Style({
                        text: textStyle,
                        geometry: function(feature) {
                            const geom = feature.getGeometry();
                            if (!geom) return null;
                            if (geom.getType() === 'Polygon') {
                                return geom.getInteriorPoint();
                            } else if (geom.getType() === 'MultiPolygon') {
                                const ext = geom.getExtent();
                                return new ol.geom.Point(ol.extent.getCenter(ext));
                            }
                            return geom;
                        }
                    })
                ];
            }
        }

        function hexToRgba(hex, alpha) {
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }

        // Helper to find the best match for display name
        function getFeatureName(properties) {
            const nameKeys = ['nama', 'nama_objek', 'name', 'desa', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi'];
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
            return { key: 'Fitur', value: 'Detail Objek' };
        }

        // Click handler to query polygon information (Vector features or GetFeatureInfo for WMS)
        map.on('singleclick', function (evt) {
            overlay.setPosition(undefined);
            container.classList.add('hidden');

            // 1. Check for clicked vector features (PostgreSQL)
            let clickedFeature = map.forEachFeatureAtPixel(evt.pixel, function (feature) {
                return feature;
            });

            if (clickedFeature) {
                const properties = clickedFeature.getProperties();
                const cleanProps = { ...properties };
                delete cleanProps.geometry;
                delete cleanProps.geom;

                const nameInfo = getFeatureName(cleanProps);

                let html = '<div style="max-height: 250px; overflow-y: auto;">';
                html += '<h4 class="text-sm font-bold text-blue-600 border-b border-gray-100 pb-2 mb-2">' + nameInfo.value + '</h4>';
                html += '<table class="custom-popup-table">';

                for (const key in cleanProps) {
                    var cleanKey = key.replace(/_/g, ' ');
                    html += '<tr>';
                    html += '<th>' + cleanKey + '</th>';
                    html += '<td>' + (cleanProps[key] !== null ? cleanProps[key] : '-') + '</td>';
                    html += '</tr>';
                }

                html += '</table></div>';

                content.innerHTML = html;
                overlay.setPosition(evt.coordinate);
                container.classList.remove('hidden');
                return;
            }

            // 2. Fallback to WMS GetFeatureInfo
            if (activeWmsLayer && wmsSource) {
                var viewResolution = map.getView().getResolution();
                var viewProjection = map.getView().getProjection();
                
                var url = wmsSource.getFeatureInfoUrl(
                    evt.coordinate,
                    viewResolution,
                    viewProjection,
                    {
                        'INFO_FORMAT': 'application/json',
                        'FEATURE_COUNT': 1
                    }
                );

                if (url) {
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.features && data.features.length > 0) {
                                var properties = data.features[0].properties;
                                var nameInfo = getFeatureName(properties);

                                var html = '<div style="max-height: 250px; overflow-y: auto;">';
                                html += '<h4 class="text-sm font-bold text-blue-600 border-b border-gray-100 pb-2 mb-2">' + nameInfo.value + '</h4>';
                                html += '<table class="custom-popup-table">';

                                for (var key in properties) {
                                    if (key === 'bbox' || key === 'fid') continue;

                                    var cleanKey = key.replace(/_/g, ' ');
                                    html += '<tr>';
                                    html += '<th>' + cleanKey + '</th>';
                                    html += '<td>' + (properties[key] !== null ? properties[key] : '-') + '</td>';
                                    html += '</tr>';
                                }

                                html += '</table></div>';

                                content.innerHTML = html;
                                overlay.setPosition(evt.coordinate);
                                container.classList.remove('hidden');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching GetFeatureInfo:', error);
                        });
                }
            }
        });

        // Parse URL params to autoload map
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const mapId = urlParams.get('id') || urlParams.get('map_id');
            if (mapId) {
                const kategoris = @json($kategoris);
                for (const kat of kategoris) {
                    const mapItem = kat.maps.find(m => m.id == mapId);
                    if (mapItem) {
                        mapItem.nama_kategori = kat.nama_kategori;
                        const alpineEl = document.querySelector('[x-data]');
                        if (alpineEl && alpineEl.__x) {
                            alpineEl.__x.$data.selectedMap = mapItem;
                            alpineEl.__x.$data.showRightSidebar = true;
                            alpineEl.__x.$data.activeTab = 'informasi';
                        }
                        displayMapLayer(mapItem);
                        break;
                    }
                }
            }
        });
    </script>
</body>
</html>
