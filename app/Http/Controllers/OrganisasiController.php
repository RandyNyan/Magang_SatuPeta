<?php

namespace App\Http\Controllers;

use App\Models\Organisasi;
use Illuminate\Http\Request;

class OrganisasiController extends Controller
{
    /**
     * Display a listing of organizations.
     */
    public function index()
    {
        $organisasis = Organisasi::orderBy('nama', 'desc')->paginate(10);
        return view('manajemen_konten.organisasi.index', compact('organisasis'));
    }

    /**
     * Show the form for creating a new organization.
     */
    public function create()
    {
        return view('manajemen_konten.organisasi.create');
    }

    /**
     * Store a newly created organization.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:organisasi,nama',
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        Organisasi::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'website' => $request->website,
        ]);

        return redirect()
            ->route('manajemen.konten.organisasi')
            ->with('success', 'Organisasi baru berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the organization.
     */
    public function edit(Organisasi $organisasi)
    {
        return view('manajemen_konten.organisasi.edit', compact('organisasi'));
    }

    /**
     * Update the organization.
     */
    public function update(Request $request, Organisasi $organisasi)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:organisasi,nama,' . $organisasi->id,
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        $organisasi->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'website' => $request->website,
        ]);

        return redirect()
            ->route('manajemen.konten.organisasi')
            ->with('success', 'Organisasi berhasil diperbarui!');
    }

    /**
     * Remove the organization.
     */
    public function destroy(Organisasi $organisasi)
    {
        if ($organisasi->users()->count() > 0) {
            return redirect()
                ->route('manajemen.konten.organisasi')
                ->with('error', 'Organisasi gagal dihapus karena masih memiliki user terdaftar!');
        }

        $organisasi->delete();
        return redirect()
            ->route('manajemen.konten.organisasi')
            ->with('success', 'Organisasi berhasil dihapus!');
    }
}
