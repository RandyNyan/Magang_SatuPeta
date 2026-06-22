<?php

namespace App\Http\Controllers;

use App\Models\OpenLayer;
use Illuminate\Http\Request;

class OpenLayerController extends Controller
{
    /**
     * Display a listing of open layers.
     */
    public function index()
    {
        $layers = OpenLayer::orderBy('created_at', 'desc')->paginate(10);
        return view('manajemen_open_layers.index', compact('layers'));
    }

    /**
     * Show the form for creating a new open layer.
     */
    public function create()
    {
        return view('manajemen_open_layers.create');
    }

    /**
     * Store a newly created open layer in PostgreSQL.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_layer' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe_layer' => 'required|in:Polygon,Point,Line',
            'geojson' => 'required|json',
        ]);

        OpenLayer::create([
            'nama_layer' => $request->nama_layer,
            'deskripsi' => $request->deskripsi,
            'tipe_layer' => $request->tipe_layer,
            'geojson' => json_decode($request->geojson, true),
        ]);

        return redirect()
            ->route('manajemen.open-layers')
            ->with('success', 'Open Layer baru berhasil dibuat di database PostgreSQL!');
    }

    /**
     * Show the form for editing the specified open layer.
     */
    public function edit(OpenLayer $openLayer)
    {
        return view('manajemen_open_layers.edit', compact('openLayer'));
    }

    /**
     * Update the specified open layer in PostgreSQL.
     */
    public function update(Request $request, OpenLayer $openLayer)
    {
        $request->validate([
            'nama_layer' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe_layer' => 'required|in:Polygon,Point,Line',
            'geojson' => 'required|json',
        ]);

        $openLayer->update([
            'nama_layer' => $request->nama_layer,
            'deskripsi' => $request->deskripsi,
            'tipe_layer' => $request->tipe_layer,
            'geojson' => json_decode($request->geojson, true),
        ]);

        return redirect()
            ->route('manajemen.open-layers')
            ->with('success', 'Open Layer berhasil diperbarui!');
    }

    /**
     * Remove the specified open layer from PostgreSQL.
     */
    public function destroy(OpenLayer $openLayer)
    {
        $openLayer->delete();
        return redirect()
            ->route('manajemen.open-layers')
            ->with('success', 'Open Layer berhasil dihapus!');
    }

    /**
     * Return the GeoJSON data for frontend rendering.
     */
    public function geojson(OpenLayer $openLayer)
    {
        return response()->json($openLayer->geojson);
    }
}
