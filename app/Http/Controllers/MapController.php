<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        // Tambahkan 'maps.organisasi' agar data relasi organisasi ikut diambil
        $kategoris = Kategori::with(['maps.organisasi'])
            ->withCount('maps')
            ->having('maps_count', '>', 0)
            ->get();

        return view('maps_view', compact('kategoris'));
    }
}
