<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Manajemen_user_Controller;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\SpatialDataController;
use App\Http\Controllers\OpenLayerController;

/*
|--------------------------------------------------------------------------
| Public Routes (Bisa diakses siapa saja, tanpa perlu login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $totalMaps = \App\Models\Maps::count();
    $totalOrganisasi = \App\Models\Organisasi::count();
    $totalKategori = \App\Models\Kategori::count();
    $totalBerita = \App\Models\Berita::count();
    $kategoris = \App\Models\Kategori::withCount('maps')->get();
    $organisasis = \App\Models\Organisasi::withCount('maps')->get();
    $beritas = \App\Models\Berita::orderBy('created_at', 'desc')->take(3)->get();
    return view('homepage', compact('totalMaps', 'totalOrganisasi', 'totalKategori', 'totalBerita', 'kategoris', 'organisasis', 'beritas'));
})->name('home');

Route::get('/katalog-peta', [MapController::class, 'index'])->name('katalog.peta');

Route::get('/topik', function () {
    $kategoris = \App\Models\Kategori::withCount('maps')->orderBy('nama_kategori')->get();
    return view('semua_topik', compact('kategoris'));
})->name('semua.topik');

Route::get('/opd', function () {
    $organisasis = \App\Models\Organisasi::withCount('maps')->orderBy('nama')->get();
    return view('semua_opd', compact('organisasis'));
})->name('semua.opd');

Route::get('/berita', function () {
    $beritas = \App\Models\Berita::orderBy('created_at', 'desc')->paginate(12);
    return view('semua_berita', compact('beritas'));
})->name('semua.berita');

/*
|--------------------------------------------------------------------------
| Guest Routes (Hanya untuk yang BELUM login)
|--------------------------------------------------------------------------
*/
// Mencegah user yang sudah login mengakses halaman login lagi
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Wajib Login / Khusus Admin)
|--------------------------------------------------------------------------
*/
// Mengunci rute di bawah ini. Kalau belum login, dilempar ke /login
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Manajemen User
    Route::get('/manajemen_user', [Manajemen_user_Controller::class, 'index'])->name('manajemen.user');
    Route::get('/manajemen_user/tambah', [Manajemen_user_Controller::class, 'create'])->name('manajemen.user.create');
    Route::post('/manajemen_user/simpan', [Manajemen_user_Controller::class, 'store'])->name('manajemen.user.store');
    Route::get('/manajemen_user/{user}/edit', [Manajemen_user_Controller::class, 'edit'])->name('manajemen.user.edit');
    Route::post('/manajemen_user/{user}/update', [Manajemen_user_Controller::class, 'update'])->name('manajemen.user.update');
    Route::delete('/manajemen_user/{user}/hapus', [Manajemen_user_Controller::class, 'destroy'])->name('manajemen.user.destroy');

    // Manajemen Peta (MySQL)
    Route::get('/manajemen_peta', [PetaController::class, 'index'])->name('manajemen.peta');
    Route::get('/manajemen_peta/tambah', [PetaController::class, 'create'])->name('manajemen.peta.create');
    Route::post('/manajemen_peta/simpan', [PetaController::class, 'store'])->name('manajemen.peta.store');
    Route::get('/manajemen_peta/{map}/edit', [PetaController::class, 'edit'])->name('manajemen.peta.edit');
    Route::post('/manajemen_peta/{map}/update', [PetaController::class, 'update'])->name('manajemen.peta.update');
    Route::delete('/manajemen_peta/{map}/hapus', [PetaController::class, 'destroy'])->name('manajemen.peta.destroy');

    // Manajemen Open Layer
    Route::get('/manajemen_openlayer', [OpenLayerController::class, 'index'])->name('manajemen.openlayer');
    Route::get('/manajemen_openlayer/tambah', [OpenLayerController::class, 'create'])->name('manajemen.openlayer.create');
    Route::post('/manajemen_openlayer/simpan', [OpenLayerController::class, 'store'])->name('manajemen.openlayer.store');
    Route::get('/manajemen_openlayer/{openLayer}/edit', [OpenLayerController::class, 'edit'])->name('manajemen.openlayer.edit');
    Route::post('/manajemen_openlayer/{openLayer}/update', [OpenLayerController::class, 'update'])->name('manajemen.openlayer.update');
    Route::delete('/manajemen_openlayer/{openLayer}/hapus', [OpenLayerController::class, 'destroy'])->name('manajemen.openlayer.destroy');

    // Manajemen Konten (Dashboard & Sub-CRUDs)
    Route::get('/manajemen_konten', function () {
        $totalKategori = \App\Models\Kategori::count();
        $totalOrganisasi = \App\Models\Organisasi::count();
        $totalBerita = \App\Models\Berita::count();
        return view('manajemen_konten', compact('totalKategori', 'totalOrganisasi', 'totalBerita'));
    })->name('manajemen.konten');

    // Manajemen Konten: Kategori
    Route::get('/manajemen_konten/kategori', [KategoriController::class, 'index'])->name('manajemen.konten.kategori');
    Route::get('/manajemen_konten/kategori/tambah', [KategoriController::class, 'create'])->name('manajemen.konten.kategori.create');
    Route::post('/manajemen_konten/kategori/simpan', [KategoriController::class, 'store'])->name('manajemen.konten.kategori.store');
    Route::get('/manajemen_konten/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('manajemen.konten.kategori.edit');
    Route::post('/manajemen_konten/kategori/{kategori}/update', [KategoriController::class, 'update'])->name('manajemen.konten.kategori.update');
    Route::delete('/manajemen_konten/kategori/{kategori}/hapus', [KategoriController::class, 'destroy'])->name('manajemen.konten.kategori.destroy');

    // Manajemen Konten: Organisasi
    Route::get('/manajemen_konten/organisasi', [OrganisasiController::class, 'index'])->name('manajemen.konten.organisasi');
    Route::get('/manajemen_konten/organisasi/tambah', [OrganisasiController::class, 'create'])->name('manajemen.konten.organisasi.create');
    Route::post('/manajemen_konten/organisasi/simpan', [OrganisasiController::class, 'store'])->name('manajemen.konten.organisasi.store');
    Route::get('/manajemen_konten/organisasi/{organisasi}/edit', [OrganisasiController::class, 'edit'])->name('manajemen.konten.organisasi.edit');
    Route::post('/manajemen_konten/organisasi/{organisasi}/update', [OrganisasiController::class, 'update'])->name('manajemen.konten.organisasi.update');
    Route::delete('/manajemen_konten/organisasi/{organisasi}/hapus', [OrganisasiController::class, 'destroy'])->name('manajemen.konten.organisasi.destroy');

    // Manajemen Konten: Berita
    Route::get('/manajemen_konten/berita', [BeritaController::class, 'index'])->name('manajemen.konten.berita');
    Route::get('/manajemen_konten/berita/tambah', [BeritaController::class, 'create'])->name('manajemen.konten.berita.create');
    Route::post('/manajemen_konten/berita/simpan', [BeritaController::class, 'store'])->name('manajemen.konten.berita.store');
    Route::get('/manajemen_konten/berita/{berita}/edit', [BeritaController::class, 'edit'])->name('manajemen.konten.berita.edit');
    Route::post('/manajemen_konten/berita/{berita}/update', [BeritaController::class, 'update'])->name('manajemen.konten.berita.update');
    Route::delete('/manajemen_konten/berita/{berita}/hapus', [BeritaController::class, 'destroy'])->name('manajemen.konten.berita.destroy');


    // Spatial Data API (Auth)
    Route::get('/api/spatial/tables', [SpatialDataController::class, 'getTables'])->name('api.spatial.tables');
    Route::get('/api/spatial/columns/{table}', [SpatialDataController::class, 'getColumns'])->name('api.spatial.columns');

});

// Public Spatial Data API (No auth required for catalog maps loading)
Route::get('/api/spatial/geojson/{table}', [SpatialDataController::class, 'getGeoJSON'])->name('api.spatial.geojson');
