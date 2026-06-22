<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class Manajemen_user_Controller extends Controller
{
    public function index()
    {
        // Mengambil data dengan batasan 10 data per halaman
    $users = User::with('organisasi')->paginate(10);

    return view('manajemen_user', compact('users'));
    }

    public function create()
    {
        return view('tambah_user');
    }

    public function store(Request $request)
    {
        // 1. Validasi data yang masuk agar tidak asal isi atau kembar
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'jabatan' => 'required|string',
            'organisasi_id' => 'required|exists:organisasi,id',
        ]);
        // 2. Simpan data baru ke dalam tabel Users di database
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-enkripsi biar aman
            'jabatan' => $request->jabatan,
            'organisasi_id' => $request->organisasi_id,
            'role' => $request->role ?? 'User',
            'status' => 'aktif', // Otomatis aktif saat dibuat
        ]);

        // 3. Setelah sukses menyimpan, lempar kembali user ke halaman tabel utama dengan pesan sukses
        return redirect()->route('manajemen.user')->with('success', 'User baru berhasil ditambahkan!');
    }

}
