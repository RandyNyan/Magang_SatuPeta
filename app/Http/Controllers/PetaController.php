<?php

namespace App\Http\Controllers;

use App\Models\Maps;
use App\Models\Kategori;
use App\Models\Organisasi;
use App\Models\OpenLayer;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    /**
     * Display a listing of maps.
     */
    public function index()
    {
        $maps = Maps::with(['kategori', 'organisasi'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('manajemen_peta', compact('maps'));
    }

    /**
     * Show the form for creating a new map.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $organisasis = Organisasi::all();
        
        $pgsqlTables = [];
        try {
            $tables = \DB::connection('pgsql')->select("
                SELECT table_name 
                FROM information_schema.tables 
                WHERE table_schema = 'public' 
                  AND table_name != 'spatial_ref_sys'
                ORDER BY table_name ASC
            ");
            $pgsqlTables = array_map(function($t) { return $t->table_name; }, $tables);
        } catch (\Exception $e) {
            // PostgreSQL connection failed, continue with empty array
        }
        
        $openLayers = OpenLayer::orderBy('nama_layer')->get();
        
        return view('tambah_peta', compact('kategoris', 'organisasis', 'pgsqlTables', 'openLayers'));
    }

    /**
     * Store a newly created map in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_mapset' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'skala' => 'required|string',
            'sistem_proyeksi' => 'required|in:UTM,WGS 84',
            'kategori_id' => 'required|exists:kategori,id',
            'organisasi_id' => 'required|exists:organisasi,id',
            'tipe_layer' => 'required|in:Polygon,Point,Line',
            'tingkat_penyajian' => 'required|in:Desa/Kelurahan,Kecamatan,Kabupaten/Kota,Provinsi',
            'cakupan_wilayah' => 'required|in:Desa/Kelurahan,Kecamatan,Kabupaten/Kota,Provinsi',
            'tahun_data' => 'required|integer|min:1900|max:2100',
            'sumber_peta' => 'required|in:wms,pgsql',
            'link_openlayer' => 'required_if:sumber_peta,wms|nullable|url',
            'pgsql_table' => 'required_if:sumber_peta,pgsql|nullable|string',
            'style_rules' => 'nullable',
            'open_layer_id' => 'nullable|exists:open_layers,id',
        ]);

        $styleRules = null;
        $sldStyle = null;
        $openLayerId = null;
        $pgsqlTable = $request->sumber_peta === 'pgsql' ? $request->pgsql_table : null;

        if ($request->sumber_peta === 'pgsql') {
            // If an Open Layer is selected, use its styling
            if ($request->open_layer_id) {
                $openLayer = OpenLayer::find($request->open_layer_id);
                if ($openLayer) {
                    $openLayerId = $openLayer->id;
                    $pgsqlTable = $openLayer->pgsql_table;
                    $styleRules = $openLayer->style_rules;
                    $sldStyle = $openLayer->sld_style;
                }
            } else {
                $rulesInput = $request->style_rules;
                $rulesData = is_string($rulesInput) ? json_decode($rulesInput, true) : $rulesInput;
                
                if (is_array($rulesData)) {
                    $styleRules = $rulesData;
                    $sldStyle = $this->generateSLD(
                        $request->pgsql_table, 
                        $rulesData['column'] ?? '', 
                        $rulesData['ranges'] ?? []
                    );
                }
            }
        }

        Maps::create([
            'judul_mapset' => $request->judul_mapset,
            'deskripsi' => $request->deskripsi,
            'skala' => $request->skala,
            'sistem_proyeksi' => $request->sistem_proyeksi,
            'kategori_id' => $request->kategori_id,
            'organisasi_id' => $request->organisasi_id,
            'tipe_layer' => $request->tipe_layer,
            'tingkat_penyajian' => $request->tingkat_penyajian,
            'cakupan_wilayah' => $request->cakupan_wilayah,
            'tahun_data' => $request->tahun_data,
            'sumber_peta' => $request->sumber_peta,
            'open_layer_id' => $openLayerId,
            'link_openlayer' => $request->sumber_peta === 'wms' ? $request->link_openlayer : null,
            'pgsql_table' => $pgsqlTable,
            'sld_style' => $sldStyle,
            'style_rules' => $styleRules,
        ]);

        return redirect()
            ->route('manajemen.peta')
            ->with('success', 'Peta baru berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified map.
     */
    public function edit(Maps $map)
    {
        $kategoris = Kategori::all();
        $organisasis = Organisasi::all();
        
        $pgsqlTables = [];
        try {
            $tables = \DB::connection('pgsql')->select("
                SELECT table_name 
                FROM information_schema.tables 
                WHERE table_schema = 'public' 
                  AND table_name != 'spatial_ref_sys'
                ORDER BY table_name ASC
            ");
            $pgsqlTables = array_map(function($t) { return $t->table_name; }, $tables);
        } catch (\Exception $e) {
            // PostgreSQL connection failed, continue with empty array
        }
        
        $openLayers = OpenLayer::orderBy('nama_layer')->get();
        
        return view('edit_peta', compact('map', 'kategoris', 'organisasis', 'pgsqlTables', 'openLayers'));
    }

    /**
     * Update the specified map in the database.
     */
    public function update(Request $request, Maps $map)
    {
        $request->validate([
            'judul_mapset' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'skala' => 'required|string',
            'sistem_proyeksi' => 'required|in:UTM,WGS 84',
            'kategori_id' => 'required|exists:kategori,id',
            'organisasi_id' => 'required|exists:organisasi,id',
            'tipe_layer' => 'required|in:Polygon,Point,Line',
            'tingkat_penyajian' => 'required|in:Desa/Kelurahan,Kecamatan,Kabupaten/Kota,Provinsi',
            'cakupan_wilayah' => 'required|in:Desa/Kelurahan,Kecamatan,Kabupaten/Kota,Provinsi',
            'tahun_data' => 'required|integer|min:1900|max:2100',
            'sumber_peta' => 'required|in:wms,pgsql',
            'link_openlayer' => 'required_if:sumber_peta,wms|nullable|url',
            'pgsql_table' => 'required_if:sumber_peta,pgsql|nullable|string',
            'style_rules' => 'nullable',
            'open_layer_id' => 'nullable|exists:open_layers,id',
        ]);

        $styleRules = null;
        $sldStyle = null;
        $openLayerId = null;
        $pgsqlTable = $request->sumber_peta === 'pgsql' ? $request->pgsql_table : null;

        if ($request->sumber_peta === 'pgsql') {
            if ($request->open_layer_id) {
                $openLayer = OpenLayer::find($request->open_layer_id);
                if ($openLayer) {
                    $openLayerId = $openLayer->id;
                    $pgsqlTable = $openLayer->pgsql_table;
                    $styleRules = $openLayer->style_rules;
                    $sldStyle = $openLayer->sld_style;
                }
            } else {
                $rulesInput = $request->style_rules;
                $rulesData = is_string($rulesInput) ? json_decode($rulesInput, true) : $rulesInput;
                
                if (is_array($rulesData)) {
                    $styleRules = $rulesData;
                    $sldStyle = $this->generateSLD(
                        $request->pgsql_table, 
                        $rulesData['column'] ?? '', 
                        $rulesData['ranges'] ?? []
                    );
                }
            }
        }

        $map->update([
            'judul_mapset' => $request->judul_mapset,
            'deskripsi' => $request->deskripsi,
            'skala' => $request->skala,
            'sistem_proyeksi' => $request->sistem_proyeksi,
            'kategori_id' => $request->kategori_id,
            'organisasi_id' => $request->organisasi_id,
            'tipe_layer' => $request->tipe_layer,
            'tingkat_penyajian' => $request->tingkat_penyajian,
            'cakupan_wilayah' => $request->cakupan_wilayah,
            'tahun_data' => $request->tahun_data,
            'sumber_peta' => $request->sumber_peta,
            'open_layer_id' => $openLayerId,
            'link_openlayer' => $request->sumber_peta === 'wms' ? $request->link_openlayer : null,
            'pgsql_table' => $pgsqlTable,
            'sld_style' => $sldStyle,
            'style_rules' => $styleRules,
        ]);

        return redirect()
            ->route('manajemen.peta')
            ->with('success', 'Peta berhasil diperbarui!');
    }

    /**
     * Remove the specified map from the database.
     */
    public function destroy(Maps $map)
    {
        $map->delete();
        return redirect()
            ->route('manajemen.peta')
            ->with('success', 'Peta berhasil dihapus!');
    }

    /**
     * Generate SLD XML string for dynamic polygon classification.
     */
    private function generateSLD($tableName, $columnName, $ranges)
    {
        $sld = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sld .= '<StyledLayerDescriptor version="1.0.0" ' . "\n";
        $sld .= '    xsi:schemaLocation="http://www.opengis.net/sld StyledLayerDescriptor.xsd" ' . "\n";
        $sld .= '    xmlns="http://www.opengis.net/sld" ' . "\n";
        $sld .= '    xmlns:ogc="http://www.opengis.net/ogc" ' . "\n";
        $sld .= '    xmlns:xlink="http://www.w3.org/1999/xlink" ' . "\n";
        $sld .= '    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">' . "\n";
        $sld .= "  <NamedLayer>\n";
        $sld .= "    <Name>" . htmlspecialchars($tableName) . "</Name>\n";
        $sld .= "    <UserStyle>\n";
        $sld .= "      <Title>Choropleth Style for " . htmlspecialchars($columnName) . "</Title>\n";
        $sld .= "      <FeatureTypeStyle>\n";

        foreach ($ranges as $index => $range) {
            $min = htmlspecialchars($range['min'] ?? '');
            $max = htmlspecialchars($range['max'] ?? '');
            $color = htmlspecialchars($range['color'] ?? '#ffffff');
            $ruleName = "Rule_" . ($index + 1);

            $sld .= "        <Rule>\n";
            $sld .= "          <Name>{$ruleName}</Name>\n";
            $sld .= "          <Title>Range {$min} - {$max}</Title>\n";
            $sld .= "          <ogc:Filter>\n";
            $sld .= "            <ogc:And>\n";
            $sld .= "              <ogc:PropertyIsGreaterThanOrEqualTo>\n";
            $sld .= "                <ogc:PropertyName>" . htmlspecialchars($columnName) . "</ogc:PropertyName>\n";
            $sld .= "                <ogc:Literal>{$min}</ogc:Literal>\n";
            $sld .= "              </ogc:PropertyIsGreaterThanOrEqualTo>\n";
            $sld .= "              <ogc:PropertyIsLessThan>\n";
            $sld .= "                <ogc:PropertyName>" . htmlspecialchars($columnName) . "</ogc:PropertyName>\n";
            $sld .= "                <ogc:Literal>{$max}</ogc:Literal>\n";
            $sld .= "              </ogc:PropertyIsLessThan>\n";
            $sld .= "            </ogc:And>\n";
            $sld .= "          </ogc:Filter>\n";
            $sld .= "          <PolygonSymbolizer>\n";
            $sld .= "            <Fill>\n";
            $sld .= "              <CssParameter name=\"fill\">{$color}</CssParameter>\n";
            $sld .= "              <CssParameter name=\"fill-opacity\">0.7</CssParameter>\n";
            $sld .= "            </Fill>\n";
            $sld .= "            <Stroke>\n";
            $sld .= "              <CssParameter name=\"stroke\">#333333</CssParameter>\n";
            $sld .= "              <CssParameter name=\"stroke-width\">1</CssParameter>\n";
            $sld .= "            </Stroke>\n";
            $sld .= "          </PolygonSymbolizer>\n";
            $sld .= "        </Rule>\n";
        }

        $sld .= "      </FeatureTypeStyle>\n";
        $sld .= "    </UserStyle>\n";
        $sld .= "  </NamedLayer>\n";
        $sld .= "</StyledLayerDescriptor>";

        return $sld;
    }
}
