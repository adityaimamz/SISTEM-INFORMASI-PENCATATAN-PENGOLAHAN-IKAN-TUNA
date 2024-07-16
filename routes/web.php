<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CuttingController;
use App\Http\Controllers\DetailProdukController;
use App\Http\Controllers\IkanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PackingController;
use App\Http\Controllers\PenerimaanIkanController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/reload-captcha', [LoginController::class, 'reloadCaptcha']);

Route::middleware('is_admin')->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    });
    Route::resource('akun', AccountController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('ikan', IkanController::class);
});

Route::middleware('is_karyawan')->group(function () {
    Route::get('/karyawan', function () {
        return view('karyawan.dashboard');
    });
});

Route::resource('penerimaan_ikan', PenerimaanIkanController::class)->middleware('is_karyawan', 'is_admin');
Route::resource('cutting', CuttingController::class)->middleware('is_karyawan', 'is_admin');
Route::resource('detailproduk', DetailProdukController::class)->middleware('is_karyawan', 'is_admin');
Route::resource('service', ServiceController::class)->middleware('is_karyawan' ,'is_admin');
Route::resource('packing', PackingController::class)->middleware('is_karyawan','is_admin');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
