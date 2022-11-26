<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CekRoleController;
use App\Http\Controllers\Peminjam\BukuController as PeminjamBukuController;
use App\Http\Controllers\Peminjam\KeranjangController;
use App\Http\Controllers\Petugas\BukuController;
use App\Http\Controllers\Petugas\ChartController;
use App\Http\Controllers\Petugas\DashboardController;
use App\Http\Controllers\Petugas\KategoriController;
use App\Http\Controllers\Petugas\PenerbitController;
use App\Http\Controllers\Petugas\RakController;
use App\Http\Controllers\Petugas\SiswaController;
use App\Http\Controllers\Petugas\TransaksiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Route::get('/', PeminjamBukuController::class);
    
    Route::get('/cek-role', CekRoleController::class);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // role admin dan petugas
    Route::middleware(['role:admin|petugas'])->group(function () {
        Route::get('/', DashboardController::class);

        Route::get('/siswa', SiswaController::class);
        Route::get('/kategori', KategoriController::class);
        Route::get('/rak', RakController::class);
        Route::get('/penerbit', PenerbitController::class);
        Route::get('/buku', BukuController::class);
        Route::get('/transaksi', TransaksiController::class);
        Route::get('/chart', ChartController::class);
    });

    // role peminjam
    // Route::middleware(['role:peminjam'])->group(function () {
    //     Route::get('/keranjang', KeranjangController::class);
    // });

    // role admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/user', UserController::class);
    });
});