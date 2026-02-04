<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Utama
    Route::get('/dashboard', [PeminjamanController::class, 'index'])->name('dashboard');

    // CRUD USER (Khusus Admin)
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // CRUD MASTER DATA (Admin & Petugas)
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');

    // CRUD PEMINJAMAN & PENGEMBALIAN (Admin & Petugas)
    // Update status digunakan untuk memproses pengembalian (ISI KEMBALI)
    Route::get('/peminjaman/status/{id}/{status}', [PeminjamanController::class, 'updateStatus'])->name('pinjam.status');
    Route::post('/peminjaman/admin-store', [PeminjamanController::class, 'adminStore'])->name('pinjam.adminStore');
    Route::delete('/peminjaman/destroy/{id}', [PeminjamanController::class, 'destroy'])->name('pinjam.destroy');

    // FITUR SISWA
    Route::post('/peminjaman/ajukan', [PeminjamanController::class, 'store'])->name('pinjam.store');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

require __DIR__.'/auth.php';