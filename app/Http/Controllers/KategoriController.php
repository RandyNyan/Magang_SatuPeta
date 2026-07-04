<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $kategoris = Kategori::withCount('maps')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('manajemen_konten.kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('manajemen_konten.kategori.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()
            ->route('manajemen.konten.kategori')
            ->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the category.
     */
    public function edit(Kategori $kategori)
    {
        return view('manajemen_konten.kategori.edit', compact('kategori'));
    }

    /**
     * Update the category.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $kategori->id,
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()
            ->route('manajemen.konten.kategori')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the category.
     */
    public function destroy(Kategori $kategori)
    {
        if ($kategori->maps()->count() > 0) {
            return redirect()
                ->route('manajemen.konten.kategori')
                ->with('error', 'Kategori gagal dihapus karena masih digunakan oleh data peta!');
        }

        $kategori->delete();
        return redirect()
            ->route('manajemen.konten.kategori')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
