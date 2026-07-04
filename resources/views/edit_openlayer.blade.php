@extends('layouts.admin')

@section('title', 'Edit Open Layer')

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
        <a href="{{ route('manajemen.openlayer') }}" class="text-xs text-gray-400 hover:text-blue-600 transition">&larr; Kembali ke daftar</a>
    </div>

    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-tight">Edit Open Layer</h2>
        <p class="text-xs text-gray-500">Perbarui konfigurasi layer dari data PostGIS.</p>
    </div>

    <form action="{{ route('manajemen.openlayer.update', $openLayer) }}" method="POST" id="openlayer-form">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Form Card -->
            <div class="lg:col-span-6 bg-white p-6 rounded-xl border border-gray-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)] space-y-4">
                <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-50 pb-2">Informasi Layer</span>

                <div>
                    <label for="nama_layer" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Layer</label>
                    <input type="text" name="nama_layer" id="nama_layer" required placeholder="Contoh: Kepadatan Penduduk Sidoarjo" value="{{ old('nama_layer', $openLayer->nama_layer) }}"
                           class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                    @error('nama_layer')
                        <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="deskripsi" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Deskripsikan layer ini..."
                              class="w-full text-xs px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">{{ old('deskripsi', $openLayer->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <span class="text-[10px] text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-4 pt-3 border-t border-gray-50">
                    <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Sumber Data PostGIS</span>

                    <div>
                        <label for="pgsql_table" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Pilih Tabel PostgreSQL</label>
                        <select name="pgsql_table" id="pgsql_table" required
                                class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                            <option value="">-- Pilih Tabel --</option>
                            @foreach($pgsqlTables as $table)
                                <option value="{{ $table }}" {{ old('pgsql_table', $openLayer->pgsql_table) === $table ? 'selected' : '' }}>{{ $table }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="column-group" class="hidden">
                        <label for="pgsql_column" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Kolom untuk Klasifikasi</label>
                        <select id="pgsql_column"
                                class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                            <option value="">-- Pilih Kolom --</option>
                        </select>

                        <div class="mt-3">
                            <label for="geom_type" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Tipe Geometri</label>
                            <select id="geom_type" class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                                <option value="Polygon">Polygon (Area)</option>
                                <option value="Line">Line (Garis)</option>
                                <option value="Point">Point (Titik / Marker)</option>
                            </select>
                        </div>
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

                        <input type="hidden" name="style_rules" id="style_rules">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-[#008cf8] hover:bg-[#007ee0] text-white py-2.5 rounded-lg text-xs font-bold shadow-sm transition">
                        Perbarui Layer
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
                    <div class="flex justify-between items-center border-b border-gray-50 pb-2 mb-3">
                        <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Styled Layer Descriptor (SLD XML)</span>
                        <button type="button" id="btn-apply-sld" class="px-2.5 py-1 bg-green-50 text-green-600 border border-green-100 rounded-md text-[10px] font-bold hover:bg-green-100 transition">Terapkan SLD Manual</button>
                    </div>
                    <textarea id="sld-preview" name="sld_style" class="w-full h-56 p-3 bg-gray-900 text-gray-200 rounded-lg overflow-auto text-[10px] font-mono whitespace-pre-wrap focus:outline-none focus:ring-1 focus:ring-green-400" spellcheck="false">{{ old('sld_style', $openLayer->sld_style) }}</textarea>
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
        const selTable = document.getElementById('pgsql_table');
        const selColumn = document.getElementById('pgsql_column');
        const selGeomType = document.getElementById('geom_type');
        const colGroup = document.getElementById('column-group');
        const ruleBuilderGroup = document.getElementById('rule-builder-group');
        const rulesContainer = document.getElementById('rules-container');
        const btnAddRule = document.getElementById('btn-add-rule');
        const btnApplySld = document.getElementById('btn-apply-sld');
        const styleRulesInput = document.getElementById('style_rules');
        const sldPreview = document.getElementById('sld-preview');
        const mapLoading = document.getElementById('map-loading');
        
        let map;
        let vectorSource;
        let vectorLayer;
        let popupOverlay;
        let geojsonFeatures = [];
        let currentRanges = []; // Optimized cache for previewStyleFunction
        let isManualSldMode = false; // Flag to prevent UI loop overriding manual SLD
        let detectedLabelColumn = ''; // Stores auto-detected label column for SLD text symbolizer

        const existingTable = @json($openLayer->pgsql_table);
        const existingStyleRules = @json($openLayer->style_rules);

        initMap();

        if (existingTable) {
            loadColumnsAndData(existingTable, true);
        }

        selTable.addEventListener('change', function() {
            const table = this.value;
            if (!table) {
                colGroup.classList.add('hidden');
                ruleBuilderGroup.classList.add('hidden');
                vectorSource.clear();
                return;
            }
            loadColumnsAndData(table, false);
        });

        function loadColumnsAndData(table, isInitialLoad) {
            fetch(`/api/spatial/columns/${table}`)
                .then(res => res.json())
                .then(cols => {
                    selColumn.innerHTML = '<option value="">-- Pilih Kolom --</option>';
                    detectedLabelColumn = ''; // reset
                    
                    const nameKeys = ['nama', 'name', 'desa', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi'];
                    for (const key of nameKeys) {
                        if (detectedLabelColumn) break;
                        for (const col of cols) {
                            if (col.column_name.toLowerCase() === key) {
                                detectedLabelColumn = col.column_name;
                                break;
                            }
                        }
                    }
                    if (!detectedLabelColumn) {
                         for (const col of cols) {
                            if (col.column_name.toLowerCase().includes('nama') || col.column_name.toLowerCase().includes('name')) {
                                detectedLabelColumn = col.column_name;
                                break;
                            }
                        }
                    }
                    if (!detectedLabelColumn && cols.length > 0) {
                         const stringCols = cols.filter(c => c.data_type.includes('char') || c.data_type.includes('text'));
                         if(stringCols.length > 0) detectedLabelColumn = stringCols[0].column_name;
                    }

                    cols.forEach(col => {
                        if (!col.data_type.includes('geometry') && col.column_name !== 'geom') {
                            const selected = (isInitialLoad && existingStyleRules && existingStyleRules.column === col.column_name) ? 'selected' : '';
                            selColumn.innerHTML += `<option value="${col.column_name}" ${selected}>${col.column_name} (${col.data_type})</option>`;
                        }
                    });
                    colGroup.classList.remove('hidden');

                    if (isInitialLoad && existingStyleRules && existingStyleRules.column) {
                        if (existingStyleRules.geom_type) {
                            selGeomType.value = existingStyleRules.geom_type;
                        }
                        ruleBuilderGroup.classList.remove('hidden');
                        rulesContainer.innerHTML = '';
                        if (existingStyleRules.ranges && existingStyleRules.ranges.length > 0) {
                            existingStyleRules.ranges.forEach(range => {
                                const colorOrUrl = existingStyleRules.geom_type === 'Point' ? (range.icon_url || range.color) : range.color;
                                addRuleRow(range.min, range.max, colorOrUrl, false);
                            });
                            // Re-sync currentRanges after loading existing
                            syncRangesFromUI(false); 
                        }
                    }
                });

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
                })
                .catch(err => {
                    console.error(err);
                    mapLoading.classList.add('hidden');
                    alert('Gagal mengambil data spasial dari PostgreSQL.');
                });
        }

        selColumn.addEventListener('change', handleUiChange);
        selGeomType.addEventListener('change', function() {
            // Rebuild UI rows to swap Color Picker vs Text Input
            const ranges = [...currentRanges];
            rulesContainer.innerHTML = '';
            ranges.forEach(r => addRuleRow(r.min, r.max, r.color, false));
            handleUiChange();
        });

        btnAddRule.addEventListener('click', () => {
            const defaultColor = selGeomType.value === 'Point' ? 'https://cdn-icons-png.flaticon.com/512/684/684908.png' : getRandomColor();
            addRuleRow('', '', defaultColor, true);
        });

        function handleUiChange() {
            if (selColumn.value) {
                ruleBuilderGroup.classList.remove('hidden');
                if (rulesContainer.children.length === 0) {
                    addDefaultRanges();
                } else {
                    syncRangesFromUI(true); // true = regenerate SLD
                }
            } else {
                ruleBuilderGroup.classList.add('hidden');
            }
        }

        function getRandomColor() {
            const colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#6366f1'];
            return colors[Math.floor(Math.random() * colors.length)];
        }

        function addDefaultRanges() {
            rulesContainer.innerHTML = '';
            const isPoint = selGeomType.value === 'Point';
            const defaultIcon = 'https://cdn-icons-png.flaticon.com/512/684/684908.png';
            addRuleRow(0, 100, isPoint ? defaultIcon : '#3b82f6', false);
            addRuleRow(100, 500, isPoint ? defaultIcon : '#10b981', false);
            addRuleRow(500, 1000, isPoint ? defaultIcon : '#f59e0b', false);
            addRuleRow(1000, 99999, isPoint ? defaultIcon : '#ef4444', true);
        }

        let ruleIndex = 0;
        function addRuleRow(min = '', max = '', colorOrUrl = '', triggerSldRegen = true) {
            const isPoint = selGeomType.value === 'Point';
            const row = document.createElement('div');
            row.className = 'flex items-center space-x-2 bg-white p-2 rounded-lg border border-gray-100 shadow-[0_1px_2px_rgba(0,0,0,0.01)] rule-row';
            row.dataset.index = ruleIndex;
            
            const colorInputHtml = isPoint 
                ? `<input type="text" placeholder="URL Icon" value="${colorOrUrl}" class="w-full text-[11px] px-2 py-1 border border-gray-200 rounded focus:outline-none focus:ring-1 focus:ring-blue-400 rule-color" title="Gunakan URL untuk gambar">`
                : `<input type="color" value="${colorOrUrl}" class="w-8 h-7 p-0.5 border border-gray-200 rounded cursor-pointer rule-color">`;

            row.innerHTML = `
                <div class="flex-1 grid grid-cols-2 gap-2">
                    <div>
                        <input type="number" step="any" placeholder="Min" value="${min}" class="w-full text-[11px] px-2 py-1 border border-gray-200 rounded focus:outline-none focus:ring-1 focus:ring-blue-400 rule-min" required>
                    </div>
                    <div>
                        <input type="number" step="any" placeholder="Max" value="${max}" class="w-full text-[11px] px-2 py-1 border border-gray-200 rounded focus:outline-none focus:ring-1 focus:ring-blue-400 rule-max" required>
                    </div>
                </div>
                <div class="flex items-center space-x-1 ${isPoint ? 'w-32' : ''}">
                    ${colorInputHtml}
                    <button type="button" class="p-1 text-red-500 hover:text-red-700 hover:bg-red-50 rounded btn-delete-rule">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            `;
            
            row.querySelector('.rule-min').addEventListener('input', () => syncRangesFromUI(true));
            row.querySelector('.rule-max').addEventListener('input', () => syncRangesFromUI(true));
            row.querySelector('.rule-color').addEventListener('input', () => syncRangesFromUI(true));
            
            row.querySelector('.btn-delete-rule').addEventListener('click', function() {
                row.remove();
                syncRangesFromUI(true);
            });
            
            rulesContainer.appendChild(row);
            ruleIndex++;
            if (triggerSldRegen) syncRangesFromUI(true);
        }

        // Extracts UI state into currentRanges variable, optionally regenerates SLD
        function syncRangesFromUI(regenerateSld) {
            const columnName = selColumn.value;
            const geomType = selGeomType.value;
            const tableName = selTable.value;
            if (!columnName || !tableName) return;

            const ranges = [];
            const rows = rulesContainer.querySelectorAll('.rule-row');
            
            rows.forEach(row => {
                const min = row.querySelector('.rule-min').value;
                const max = row.querySelector('.rule-max').value;
                const color = row.querySelector('.rule-color').value;
                if (min !== '' && max !== '') {
                    ranges.push({ min, max, color, icon_url: color });
                }
            });

            currentRanges = ranges;
            
            const rulesObj = {
                column: columnName,
                geom_type: geomType,
                ranges: ranges
            };
            styleRulesInput.value = JSON.stringify(rulesObj);

            if (regenerateSld) {
                const sldXml = generateSLDXML(tableName, columnName, ranges, geomType);
                sldPreview.value = sldXml;
            }

            refreshMapStyles();
        }

        function hexToRgba(hex, alpha) {
            if(!/^#[0-9A-F]{6}$/i.test(hex)) return `rgba(200, 200, 200, ${alpha})`;
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }

        const styleCache = {};
        function previewStyleFunction(feature) {
            const columnName = selColumn.value;
            const geomType = selGeomType.value;
            if (!columnName) return getDefaultStyle(geomType);

            const value = feature.get(columnName);
            let colorOrUrl = geomType === 'Point' ? 'https://cdn-icons-png.flaticon.com/512/684/684908.png' : '#cccccc';
            
            if (value !== undefined && value !== null) {
                const valNum = parseFloat(value);
                
                for (const range of currentRanges) {
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

            if (!styleCache[colorOrUrl]) {
                if (geomType === 'Point') {
                    styleCache[colorOrUrl] = new ol.style.Style({
                        image: new ol.style.Icon({
                            src: colorOrUrl,
                            scale: 0.08,
                            crossOrigin: 'anonymous'
                        })
                    });
                } else if (geomType === 'Line') {
                    styleCache[colorOrUrl] = new ol.style.Style({
                        stroke: new ol.style.Stroke({ color: colorOrUrl, width: 3 })
                    });
                } else {
                    styleCache[colorOrUrl] = new ol.style.Style({
                        fill: new ol.style.Fill({ color: hexToRgba(colorOrUrl, 0.7) }),
                        stroke: new ol.style.Stroke({ color: '#333333', width: 1 })
                    });
                }
            }

            return styleCache[colorOrUrl];
        }

        function getDefaultStyle(geomType) {
            if (geomType === 'Point') {
                return new ol.style.Style({
                    image: new ol.style.Icon({ src: 'https://cdn-icons-png.flaticon.com/512/684/684908.png', scale: 0.08, crossOrigin: 'anonymous' })
                });
            } else if (geomType === 'Line') {
                return new ol.style.Style({ stroke: new ol.style.Stroke({ color: '#2563eb', width: 3 }) });
            }
            return new ol.style.Style({
                fill: new ol.style.Fill({ color: 'rgba(59, 130, 246, 0.5)' }),
                stroke: new ol.style.Stroke({ color: '#2563eb', width: 1 })
            });
        }

        function refreshMapStyles() {
            for (const key in styleCache) delete styleCache[key];
            if (vectorLayer) vectorLayer.changed();
        }

        // XML Manual Parsing
        btnApplySld.addEventListener('click', function() {
            const sldText = sldPreview.value;
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(sldText, "text/xml");
            
            if (xmlDoc.getElementsByTagName("parsererror").length > 0) {
                alert("Format SLD XML tidak valid. Periksa kembali tag dan struktur XML Anda.");
                return;
            }
            
            const rules = xmlDoc.getElementsByTagName("Rule");
            if(rules.length === 0) {
                alert("Tidak ada tag <Rule> yang ditemukan di dalam SLD.");
                return;
            }
            
            // Auto detect geometry
            let detectedGeom = 'Polygon';
            if (xmlDoc.getElementsByTagName("PointSymbolizer").length > 0) detectedGeom = 'Point';
            else if (xmlDoc.getElementsByTagName("LineSymbolizer").length > 0) detectedGeom = 'Line';
            
            selGeomType.value = detectedGeom;
            
            const newRanges = [];
            for (let i = 0; i < rules.length; i++) {
                const rule = rules[i];
                let min = '', max = '', color = '';
                
                const greaterNode = rule.getElementsByTagName("PropertyIsGreaterThanOrEqualTo")[0] || rule.getElementsByTagName("ogc:PropertyIsGreaterThanOrEqualTo")[0];
                if (greaterNode) {
                    const literalNode = greaterNode.getElementsByTagName("Literal")[0] || greaterNode.getElementsByTagName("ogc:Literal")[0];
                    if (literalNode) min = literalNode.textContent;
                }
                
                const lessNode = rule.getElementsByTagName("PropertyIsLessThan")[0] || rule.getElementsByTagName("ogc:PropertyIsLessThan")[0];
                if (lessNode) {
                    const literalNode = lessNode.getElementsByTagName("Literal")[0] || lessNode.getElementsByTagName("ogc:Literal")[0];
                    if (literalNode) max = literalNode.textContent;
                }
                
                if (detectedGeom === 'Point') {
                    const hrefNode = rule.getElementsByTagName("OnlineResource")[0];
                    if (hrefNode) color = hrefNode.getAttribute("xlink:href") || hrefNode.getAttribute("href");
                } else if (detectedGeom === 'Line') {
                    const cssNodes = rule.getElementsByTagName("CssParameter");
                    for(let j=0; j<cssNodes.length; j++) if(cssNodes[j].getAttribute("name") === "stroke") color = cssNodes[j].textContent;
                } else {
                    const cssNodes = rule.getElementsByTagName("CssParameter");
                    for(let j=0; j<cssNodes.length; j++) if(cssNodes[j].getAttribute("name") === "fill") color = cssNodes[j].textContent;
                }
                
                newRanges.push({ min, max, color });
            }
            
            // Sync UI back without regenerating the SLD XML textarea
            currentRanges = newRanges;
            rulesContainer.innerHTML = '';
            newRanges.forEach(range => addRuleRow(range.min, range.max, range.color, false));
            
            const rulesObj = {
                column: selColumn.value,
                geom_type: detectedGeom,
                ranges: newRanges
            };
            styleRulesInput.value = JSON.stringify(rulesObj);
            
            refreshMapStyles();
            alert("SLD berhasil diterapkan ke Peta Preview!");
        });

        function initMap() {
            vectorSource = new ol.source.Vector();
            vectorLayer = new ol.layer.Vector({
                source: vectorSource,
                style: previewStyleFunction
            });

            const popupEl = document.getElementById('preview-popup');
            popupOverlay = new ol.Overlay({
                element: popupEl,
                autoPan: { animation: { duration: 250 } },
            });

            map = new ol.Map({
                target: 'preview-map',
                layers: [
                    new ol.layer.Tile({ source: new ol.source.OSM() }),
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

        function generateSLDXML(tableName, columnName, ranges, geomType = 'Polygon') {
            let sld = `<?xml version="1.0" encoding="UTF-8"?>\n<StyledLayerDescriptor version="1.0.0" \n    xsi:schemaLocation="http://www.opengis.net/sld StyledLayerDescriptor.xsd" \n    xmlns="http://www.opengis.net/sld" \n    xmlns:ogc="http://www.opengis.net/ogc" \n    xmlns:xlink="http://www.w3.org/1999/xlink" \n    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">\n  <NamedLayer>\n    <Name>${escapeXml(tableName)}</Name>\n    <UserStyle>\n      <Title>Choropleth Style for ${escapeXml(columnName)}</Title>\n      <FeatureTypeStyle>\n`;

            ranges.forEach((range, idx) => {
                const min = escapeXml(range.min);
                const max = escapeXml(range.max);
                const colorOrUrl = escapeXml(range.icon_url || range.color);
                const ruleName = `Rule_${idx + 1}`;

                sld += `        <Rule>\n          <Name>${ruleName}</Name>\n          <Title>Range ${min} - ${max}</Title>\n          <ogc:Filter>\n            <ogc:And>\n              <ogc:PropertyIsGreaterThanOrEqualTo>\n                <ogc:PropertyName>${escapeXml(columnName)}</ogc:PropertyName>\n                <ogc:Literal>${min}</ogc:Literal>\n              </ogc:PropertyIsGreaterThanOrEqualTo>\n              <ogc:PropertyIsLessThan>\n                <ogc:PropertyName>${escapeXml(columnName)}</ogc:PropertyName>\n                <ogc:Literal>${max}</ogc:Literal>\n              </ogc:PropertyIsLessThan>\n            </ogc:And>\n          </ogc:Filter>\n`;

                if (geomType === 'Point') {
                    sld += `          <PointSymbolizer>\n            <Graphic>\n              <ExternalGraphic>\n                <OnlineResource xlink:type="simple" xlink:href="${colorOrUrl}" />\n                <Format>image/png</Format>\n              </ExternalGraphic>\n              <Size>32</Size>\n            </Graphic>\n          </PointSymbolizer>\n`;
                } else if (geomType === 'Line') {
                    sld += `          <LineSymbolizer>\n            <Stroke>\n              <CssParameter name="stroke">${colorOrUrl}</CssParameter>\n              <CssParameter name="stroke-width">3</CssParameter>\n            </Stroke>\n          </LineSymbolizer>\n`;
                } else {
                    sld += `          <PolygonSymbolizer>\n            <Fill>\n              <CssParameter name="fill">${colorOrUrl}</CssParameter>\n              <CssParameter name="fill-opacity">0.7</CssParameter>\n            </Fill>\n            <Stroke>\n              <CssParameter name="stroke">#333333</CssParameter>\n              <CssParameter name="stroke-width">1</CssParameter>\n            </Stroke>\n          </PolygonSymbolizer>\n`;
                    if (detectedLabelColumn) {
                        sld += `          <TextSymbolizer>\n            <Label>\n              <ogc:PropertyName>${escapeXml(detectedLabelColumn)}</ogc:PropertyName>\n            </Label>\n            <Font>\n              <CssParameter name="font-family">Arial</CssParameter>\n              <CssParameter name="font-size">12</CssParameter>\n              <CssParameter name="font-style">normal</CssParameter>\n              <CssParameter name="font-weight">bold</CssParameter>\n            </Font>\n            <LabelPlacement>\n              <PointPlacement>\n                <AnchorPoint>\n                  <AnchorPointX>0.5</AnchorPointX>\n                  <AnchorPointY>0.5</AnchorPointY>\n                </AnchorPoint>\n              </PointPlacement>\n            </LabelPlacement>\n            <Halo>\n              <Radius>2</Radius>\n              <Fill>\n                <CssParameter name="fill">#FFFFFF</CssParameter>\n              </Fill>\n            </Halo>\n            <VendorOption name="polygonAlign">mbr</VendorOption>\n            <VendorOption name="group">yes</VendorOption>\n            <VendorOption name="goodnessOfFit">0.2</VendorOption>\n            <VendorOption name="maxDisplacement">400</VendorOption>\n          </TextSymbolizer>\n`;
                    }
                }
                sld += `        </Rule>\n`;
            });

            sld += `      </FeatureTypeStyle>\n    </UserStyle>\n  </NamedLayer>\n</StyledLayerDescriptor>`;
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
