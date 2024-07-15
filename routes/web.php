<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenerimaanIkanController;
use App\Http\Controllers\CuttingController;
use App\Http\Controllers\DetailProdukController;
use App\Http\Controllers\IkanController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\KaryawanMiddleware;



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
    Route::resource('penerimaan_ikan', PenerimaanIkanController::class);
    Route::resource('cutting', CuttingController::class);
    Route::resource('detailproduk', DetailProdukController::class);

});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');