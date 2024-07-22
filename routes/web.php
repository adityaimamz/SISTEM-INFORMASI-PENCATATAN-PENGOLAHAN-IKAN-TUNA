<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CuttingController;
use App\Http\Controllers\DetailProdukController;
use App\Http\Controllers\IkanController;
use App\Http\Controllers\ProdukMasukController;
use App\Http\Controllers\ProdukKeluarController;
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
    Route::resource('produk-masuk', ProdukMasukController::class);
    Route::resource('produk-keluar', ProdukKeluarController::class);
});

Route::middleware('is_karyawan')->group(function () {
    Route::get('/karyawan', function () {
        return view('karyawan.dashboard');
    });
});

Route::get('/laporan_ikan_masuk', function () {
    return view('admin.laporan_penerimaan_ikan');
})->middleware('is_admin');

Route::get('/laporan_cutting', function () {
    return view('admin.laporan_cutting');
})->middleware('is_admin');

Route::get('/laporan_service', function () {
    return view('admin.laporan_service');
})->middleware('is_admin');

Route::get('/laporan_packing', function () {
    return view('admin.laporan_packing');
})->middleware('is_admin');

Route::get('/laporan_stok_masuk', function () {
    return view('admin.laporan_stok_masuk');
})->middleware('is_admin');

Route::get('/laporan_stok_keluar', function () {
    return view('admin.laporan_stok_keluar');
})->middleware('is_admin');

Route::get('/ikan-pdf/{month}/{year}', [PenerimaanIkanController::class, 'ikanPdf'])->name('ikan.pdf');
Route::get('/cutting-pdf/{month}/{year}', [CuttingController::class, 'cuttingPdf'])->name('cutting.pdf');
Route::get('/service-pdf/{month}/{year}', [ServiceController::class, 'servicePdf'])->name('service.pdf');
Route::get('/stok-masuk-pdf/{month}/{year}', [ProdukMasukController::class, 'stokMasukPdf'])->name('stok-masuk.pdf');
Route::get('/stok-keluar-pdf/{month}/{year}', [ProdukKeluarController::class, 'stokKeluarPdf'])->name('stok-keluar.pdf');
Route::resource('penerimaan_ikan', PenerimaanIkanController::class)->middleware('auth');
Route::resource('cutting', CuttingController::class)->middleware('auth');
Route::resource('detailproduk', DetailProdukController::class)->middleware('auth');
Route::resource('service', ServiceController::class)->middleware('auth');
Route::resource('packing', PackingController::class)->middleware('auth');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
