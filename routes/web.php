<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Manajemen_user_Controller;
use App\Http\Controllers\OpenLayerController;
use App\Http\Controllers\PetaController;

/*
|--------------------------------------------------------------------------
| Public Routes (Bisa diakses siapa saja, tanpa perlu login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('homepage');
})->name('home');

Route::get('/katalog-peta', [MapController::class, 'index'])->name('katalog.peta');

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

    // Manajemen Peta (MySQL)
    Route::get('/manajemen_peta', [PetaController::class, 'index'])->name('manajemen.peta');
    Route::get('/manajemen_peta/tambah', [PetaController::class, 'create'])->name('manajemen.peta.create');
    Route::post('/manajemen_peta/simpan', [PetaController::class, 'store'])->name('manajemen.peta.store');
    Route::get('/manajemen_peta/{map}/edit', [PetaController::class, 'edit'])->name('manajemen.peta.edit');
    Route::post('/manajemen_peta/{map}/update', [PetaController::class, 'update'])->name('manajemen.peta.update');
    Route::delete('/manajemen_peta/{map}/hapus', [PetaController::class, 'destroy'])->name('manajemen.peta.destroy');

    // Manajemen Open Layer (PostgreSQL)
    Route::get('/manajemen_open_layers', [OpenLayerController::class, 'index'])->name('manajemen.open-layers');
    Route::get('/manajemen_open_layers/tambah', [OpenLayerController::class, 'create'])->name('manajemen.open-layers.create');
    Route::post('/manajemen_open_layers/simpan', [OpenLayerController::class, 'store'])->name('manajemen.open-layers.store');
    Route::get('/manajemen_open_layers/{openLayer}/edit', [OpenLayerController::class, 'edit'])->name('manajemen.open-layers.edit');
    Route::post('/manajemen_open_layers/{openLayer}/update', [OpenLayerController::class, 'update'])->name('manajemen.open-layers.update');
    Route::delete('/manajemen_open_layers/{openLayer}/hapus', [OpenLayerController::class, 'destroy'])->name('manajemen.open-layers.destroy');
    Route::get('/open-layers/{openLayer}/geojson', [OpenLayerController::class, 'geojson'])->name('open-layers.geojson');


    // Manajemen Konten
    Route::get('/manajemen_konten', function () {
        return view('manajemen_konten');
    })->name('manajemen.konten');

});
