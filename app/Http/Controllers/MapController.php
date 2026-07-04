<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');

        // Tambahkan 'maps.organisasi' dan 'maps.openLayer'
        $kategorisQuery = Kategori::with(['maps' => function($q) use ($search) {
            if ($search) {
                $q->where('judul_mapset', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            }
            $q->with(['organisasi', 'openLayer']);
        }])
        ->whereHas('maps', function($q) use ($search) {
            if ($search) {
                $q->where('judul_mapset', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            }
        })
        ->withCount(['maps' => function($q) use ($search) {
            if ($search) {
                $q->where('judul_mapset', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            }
        }]);

        $kategoris = $kategorisQuery->get();

        $organisasisQuery = \App\Models\Organisasi::with(['maps' => function($q) use ($search) {
            if ($search) {
                $q->where('judul_mapset', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            }
            $q->with(['kategori', 'openLayer', 'organisasi']);
        }])
        ->whereHas('maps', function($q) use ($search) {
            if ($search) {
                $q->where('judul_mapset', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            }
        })
        ->withCount(['maps' => function($q) use ($search) {
            if ($search) {
                $q->where('judul_mapset', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            }
        }]);

        $organisasis = $organisasisQuery->get();

        return view('maps_view', compact('kategoris', 'organisasis', 'search'));
    }
}
