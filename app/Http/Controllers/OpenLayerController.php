<?php

namespace App\Http\Controllers;

use App\Models\OpenLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpenLayerController extends Controller
{
    public function index()
    {
        $openLayers = OpenLayer::orderBy('created_at', 'desc')->paginate(10);
        return view('manajemen_openlayer', compact('openLayers'));
    }

    public function create()
    {
        $pgsqlTables = [];
        try {
            $tables = DB::connection('pgsql')->select("
                SELECT table_name 
                FROM information_schema.tables 
                WHERE table_schema = 'public' 
                  AND table_name != 'spatial_ref_sys'
                ORDER BY table_name ASC
            ");
            $pgsqlTables = array_map(function($t) { return $t->table_name; }, $tables);
        } catch (\Exception $e) {
            // PostgreSQL connection failed
        }
        
        return view('tambah_openlayer', compact('pgsqlTables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layer' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'pgsql_table' => 'required|string',
            'geom_column' => 'nullable|string',
            'style_column' => 'nullable|string',
            'style_rules' => 'nullable',
            'sld_style' => 'nullable|string',
        ]);

        $styleRules = null;
        $sldStyle = $request->sld_style;

        $rulesInput = $request->style_rules;
        $rulesData = is_string($rulesInput) ? json_decode($rulesInput, true) : $rulesInput;
        
        if (is_array($rulesData) && !empty($rulesData)) {
            $styleRules = $rulesData;
            if (empty($sldStyle)) {
                $sldStyle = $this->generateSLD(
                    $request->pgsql_table, 
                    $rulesData['column'] ?? '', 
                    $rulesData['ranges'] ?? [],
                    $rulesData['geom_type'] ?? 'Polygon'
                );
            }
        }

        OpenLayer::create([
            'nama_layer' => $request->nama_layer,
            'deskripsi' => $request->deskripsi,
            'pgsql_table' => $request->pgsql_table,
            'geom_column' => $request->geom_column ?? 'geom',
            'style_column' => $rulesData['column'] ?? $request->style_column,
            'sld_style' => $sldStyle,
            'style_rules' => $styleRules,
        ]);

        return redirect()
            ->route('manajemen.openlayer')
            ->with('success', 'Open Layer berhasil ditambahkan!');
    }

    public function edit(OpenLayer $openLayer)
    {
        $pgsqlTables = [];
        try {
            $tables = DB::connection('pgsql')->select("
                SELECT table_name 
                FROM information_schema.tables 
                WHERE table_schema = 'public' 
                  AND table_name != 'spatial_ref_sys'
                ORDER BY table_name ASC
            ");
            $pgsqlTables = array_map(function($t) { return $t->table_name; }, $tables);
        } catch (\Exception $e) {
            // PostgreSQL connection failed
        }

        return view('edit_openlayer', compact('openLayer', 'pgsqlTables'));
    }

    public function update(Request $request, OpenLayer $openLayer)
    {
        $request->validate([
            'nama_layer' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'pgsql_table' => 'required|string',
            'geom_column' => 'nullable|string',
            'style_column' => 'nullable|string',
            'style_rules' => 'nullable',
            'sld_style' => 'nullable|string',
        ]);

        $styleRules = null;
        $sldStyle = $request->sld_style;

        $rulesInput = $request->style_rules;
        $rulesData = is_string($rulesInput) ? json_decode($rulesInput, true) : $rulesInput;
        
        if (is_array($rulesData) && !empty($rulesData)) {
            $styleRules = $rulesData;
            if (empty($sldStyle)) {
                $sldStyle = $this->generateSLD(
                    $request->pgsql_table, 
                    $rulesData['column'] ?? '', 
                    $rulesData['ranges'] ?? [],
                    $rulesData['geom_type'] ?? 'Polygon'
                );
            }
        }

        $openLayer->update([
            'nama_layer' => $request->nama_layer,
            'deskripsi' => $request->deskripsi,
            'pgsql_table' => $request->pgsql_table,
            'geom_column' => $request->geom_column ?? 'geom',
            'style_column' => $rulesData['column'] ?? $request->style_column,
            'sld_style' => $sldStyle,
            'style_rules' => $styleRules,
        ]);

        return redirect()
            ->route('manajemen.openlayer')
            ->with('success', 'Open Layer berhasil diperbarui!');
    }

    public function destroy(OpenLayer $openLayer)
    {
        $openLayer->delete();
        return redirect()
            ->route('manajemen.openlayer')
            ->with('success', 'Open Layer berhasil dihapus!');
    }

    private function guessLabelColumn($tableName)
    {
        try {
            $columns = DB::connection('pgsql')->select("
                SELECT column_name 
                FROM information_schema.columns 
                WHERE table_name = ? 
                AND data_type IN ('character varying', 'text', 'character')
            ", [$tableName]);
            
            $nameKeys = ['nama', 'name', 'desa', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi'];
            foreach ($nameKeys as $key) {
                foreach ($columns as $col) {
                    if (strtolower($col->column_name) === $key) {
                        return $col->column_name;
                    }
                }
            }
            foreach ($columns as $col) {
                if (stripos($col->column_name, 'nama') !== false || stripos($col->column_name, 'name') !== false) {
                    return $col->column_name;
                }
            }
            if (count($columns) > 0) return $columns[0]->column_name;
        } catch (\Exception $e) {}
        
        return ''; // fallback
    }

    private function generateSLD($tableName, $columnName, $ranges, $geomType = 'Polygon')
    {
        $labelColumn = $this->guessLabelColumn($tableName);

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
            $color = htmlspecialchars($range['color'] ?? '#ffffff'); // For Polygon/Line
            $iconUrl = htmlspecialchars($range['icon_url'] ?? $range['color'] ?? ''); // For Point
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

            if ($geomType === 'Point') {
                $sld .= "          <PointSymbolizer>\n";
                $sld .= "            <Graphic>\n";
                $sld .= "              <ExternalGraphic>\n";
                $sld .= "                <OnlineResource xlink:type=\"simple\" xlink:href=\"{$iconUrl}\" />\n";
                $sld .= "                <Format>image/png</Format>\n";
                $sld .= "              </ExternalGraphic>\n";
                $sld .= "              <Size>32</Size>\n";
                $sld .= "            </Graphic>\n";
                $sld .= "          </PointSymbolizer>\n";
            } elseif ($geomType === 'Line') {
                $sld .= "          <LineSymbolizer>\n";
                $sld .= "            <Stroke>\n";
                $sld .= "              <CssParameter name=\"stroke\">{$color}</CssParameter>\n";
                $sld .= "              <CssParameter name=\"stroke-width\">3</CssParameter>\n";
                $sld .= "            </Stroke>\n";
                $sld .= "          </LineSymbolizer>\n";
            } else {
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
                
                if (!empty($labelColumn)) {
                    $sld .= "          <TextSymbolizer>\n";
                    $sld .= "            <Label>\n";
                    $sld .= "              <ogc:PropertyName>" . htmlspecialchars($labelColumn) . "</ogc:PropertyName>\n";
                    $sld .= "            </Label>\n";
                    $sld .= "            <Font>\n";
                    $sld .= "              <CssParameter name=\"font-family\">Arial</CssParameter>\n";
                    $sld .= "              <CssParameter name=\"font-size\">12</CssParameter>\n";
                    $sld .= "              <CssParameter name=\"font-weight\">bold</CssParameter>\n";
                    $sld .= "            </Font>\n";
                    $sld .= "            <LabelPlacement>\n";
                    $sld .= "              <PointPlacement>\n";
                    $sld .= "                <AnchorPoint>\n";
                    $sld .= "                  <AnchorPointX>0.5</AnchorPointX>\n";
                    $sld .= "                  <AnchorPointY>0.5</AnchorPointY>\n";
                    $sld .= "                </AnchorPoint>\n";
                    $sld .= "              </PointPlacement>\n";
                    $sld .= "            </LabelPlacement>\n";
                    $sld .= "            <Halo>\n";
                    $sld .= "              <Radius>2</Radius>\n";
                    $sld .= "              <Fill>\n";
                    $sld .= "                <CssParameter name=\"fill\">#FFFFFF</CssParameter>\n";
                    $sld .= "              </Fill>\n";
                    $sld .= "            </Halo>\n";
                    $sld .= "            <VendorOption name=\"polygonAlign\">mbr</VendorOption>\n";
                    $sld .= "            <VendorOption name=\"group\">yes</VendorOption>\n";
                    $sld .= "            <VendorOption name=\"goodnessOfFit\">0.2</VendorOption>\n";
                    $sld .= "            <VendorOption name=\"maxDisplacement\">400</VendorOption>\n";
                    $sld .= "          </TextSymbolizer>\n";
                }
            }
            $sld .= "        </Rule>\n";
        }

        $sld .= "      </FeatureTypeStyle>\n";
        $sld .= "    </UserStyle>\n";
        $sld .= "  </NamedLayer>\n";
        $sld .= "</StyledLayerDescriptor>";

        return $sld;
    }
}
