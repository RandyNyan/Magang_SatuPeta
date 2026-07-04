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
            'jabatan' => 'nullable|string',
            'role' => 'required|string',
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

    public function edit(User $user)
    {
        return view('edit_user', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'jabatan' => 'nullable|string',
            'organisasi_id' => 'required|exists:organisasi,id',
            'role' => 'required|string',
            'status' => 'required|string',
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'organisasi_id' => $request->organisasi_id,
            'role' => $request->role,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('manajemen.user')->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        // Cegah user menghapus dirinya sendiri jika perlu
        if (auth()->id() === $user->id) {
            return redirect()->route('manajemen.user')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('manajemen.user')->with('success', 'User berhasil dihapus!');
    }

}
