<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CuttingController;
use App\Http\Controllers\DetailProdukController;
use App\Http\Controllers\IkanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PackingController;
use App\Http\Controllers\PenerimaanIkanController;
use App\Http\Controllers\ProdukKeluarController;
use App\Http\Controllers\ProdukMasukController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SupplierController;
use App\Models\Ikan;
use App\Models\Penerimaan_ikan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/reload-captcha', [LoginController::class, 'reloadCaptcha']);

Route::middleware('is_admin')->group(function () {
    Route::get('/admin', function () {
        $totalMasuk = DB::table('produk_masuks')
            ->sum('stok_masuk');

        $totalKeluar = DB::table('produk_keluars')
            ->sum('jumlah_produk');

        $totalStok = $totalMasuk - $totalKeluar;
        return view('admin.dashboard', [
            'totalStok' => $totalStok,
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
        ]);
    });
    Route::resource('akun', AccountController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('ikan', IkanController::class);

});

Route::middleware('is_karyawan')->group(function () {
    Route::get('/karyawan', function () {
        $totalMasuk = DB::table('produk_masuks')
        ->sum('stok_masuk');

    $totalKeluar = DB::table('produk_keluars')
        ->sum('jumlah_produk');

    $totalStok = $totalMasuk - $totalKeluar;
        return view('karyawan.dashboard', [
            'totalStok' => $totalStok,
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
        ]);
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

Route::get('/get-grade/{ikan}', function (Ikan $ikan) {
    return response()->json(['grade' => $ikan->kategori->grade]);
});

Route::get('/get-supplier/{penerimaan_ikan}', function (Penerimaan_ikan $penerimaan_ikan) {
    return response()->json(['nama_supplier' => $penerimaan_ikan->supplier->nama_supplier]);
});

Route::get('/ikan-pdf/{month}/{year}', [PenerimaanIkanController::class, 'ikanPdf'])->name('ikan.pdf');
Route::get('/cutting-pdf/{month}/{year}', [CuttingController::class, 'cuttingPdf'])->name('cutting.pdf');
Route::get('/service-pdf/{month}/{year}', [ServiceController::class, 'servicePdf'])->name('service.pdf');
Route::get('/packing-pdf/{month}/{year}', [PackingController::class, 'packingPdf'])->name('packing.pdf');
Route::get('/stok-masuk-pdf/{month}/{year}', [ProdukMasukController::class, 'stokMasukPdf'])->name('stok-masuk.pdf');
Route::get('/stok-keluar-pdf/{month}/{year}', [ProdukKeluarController::class, 'stokKeluarPdf'])->name('stok-keluar.pdf');
Route::resource('penerimaan_ikan', PenerimaanIkanController::class)->middleware('auth');
Route::resource('cutting', CuttingController::class)->middleware('auth');
Route::resource('detailproduk', DetailProdukController::class)->middleware('auth');
Route::resource('service', ServiceController::class)->middleware('auth');
Route::resource('packing', PackingController::class)->middleware('auth');
Route::resource('produk-masuk', ProdukMasukController::class)->middleware('auth');
Route::resource('produk-keluar', ProdukKeluarController::class)->middleware('auth');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
