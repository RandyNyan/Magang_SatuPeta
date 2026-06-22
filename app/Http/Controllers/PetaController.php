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
        $maps = Maps::with(['kategori', 'organisasi', 'openLayer'])
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
        $openLayers = OpenLayer::orderBy('nama_layer', 'asc')->get();
        
        return view('tambah_peta', compact('kategoris', 'organisasis', 'openLayers'));
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
            'layer_source' => 'required|in:wms,pgsql',
            'link_openlayer' => 'required_if:layer_source,wms|nullable|url',
            'open_layer_id' => 'required_if:layer_source,pgsql|nullable|exists:pgsql.open_layers,id',
        ]);

        $open_layer_id = $request->layer_source === 'pgsql' ? $request->open_layer_id : null;
        $link_openlayer = $request->link_openlayer;

        // If pgsql layer is selected, generate the API URL dynamically
        if ($request->layer_source === 'pgsql' && $open_layer_id) {
            $link_openlayer = route('open-layers.geojson', $open_layer_id, false); // relative path /open-layers/{id}/geojson
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
            'open_layer_id' => $open_layer_id,
            'link_openlayer' => $link_openlayer,
        ]);

        return redirect()
            ->route('manajemen.peta')
            ->with('success', 'Mapset baru berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified map.
     */
    public function edit(Maps $map)
    {
        $kategoris = Kategori::all();
        $organisasis = Organisasi::all();
        $openLayers = OpenLayer::orderBy('nama_layer', 'asc')->get();
        
        return view('edit_peta', compact('map', 'kategoris', 'organisasis', 'openLayers'));
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
            'layer_source' => 'required|in:wms,pgsql',
            'link_openlayer' => 'required_if:layer_source,wms|nullable|url',
            'open_layer_id' => 'required_if:layer_source,pgsql|nullable|exists:pgsql.open_layers,id',
        ]);

        $open_layer_id = $request->layer_source === 'pgsql' ? $request->open_layer_id : null;
        $link_openlayer = $request->link_openlayer;

        if ($request->layer_source === 'pgsql' && $open_layer_id) {
            $link_openlayer = route('open-layers.geojson', $open_layer_id, false);
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
            'open_layer_id' => $open_layer_id,
            'link_openlayer' => $link_openlayer,
        ]);

        return redirect()
            ->route('manajemen.peta')
            ->with('success', 'Mapset berhasil diperbarui!');
    }

    /**
     * Remove the specified map from the database.
     */
    public function destroy(Maps $map)
    {
        $map->delete();
        return redirect()
            ->route('manajemen.peta')
            ->with('success', 'Mapset berhasil dihapus!');
    }
}
