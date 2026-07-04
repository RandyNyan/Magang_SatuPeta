<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Display a listing of news.
     */
    public function index()
    {
        $beritas = Berita::orderBy('created_at', 'desc')->paginate(10);
        return view('manajemen_konten.berita.index', compact('beritas'));
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        return view('manajemen_konten.berita.create');
    }

    /**
     * Store a newly created article.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'nullable|string',
            'konten' => 'required|string',
            'penulis' => 'nullable|string|max:255',
        ]);

        Berita::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul) . '-' . rand(100, 999),
            'ringkasan' => $request->ringkasan,
            'konten' => $request->konten,
            'penulis' => $request->penulis ?? auth()->user()->nama ?? 'Admin',
        ]);

        return redirect()
            ->route('manajemen.konten.berita')
            ->with('success', 'Berita berhasil diterbitkan!');
    }

    /**
     * Show the form for editing the article.
     */
    public function edit(Berita $berita)
    {
        return view('manajemen_konten.berita.edit', compact('berita'));
    }

    /**
     * Update the article.
     */
    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'nullable|string',
            'konten' => 'required|string',
            'penulis' => 'nullable|string|max:255',
        ]);

        $berita->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul) . '-' . $berita->id,
            'ringkasan' => $request->ringkasan,
            'konten' => $request->konten,
            'penulis' => $request->penulis ?? $berita->penulis,
        ]);

        return redirect()
            ->route('manajemen.konten.berita')
            ->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the article.
     */
    public function destroy(Berita $berita)
    {
        $berita->delete();
        return redirect()
            ->route('manajemen.konten.berita')
            ->with('success', 'Berita berhasil dihapus!');
    }
}
