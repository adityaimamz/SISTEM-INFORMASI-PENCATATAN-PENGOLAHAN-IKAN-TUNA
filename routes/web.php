<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AccountController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\KaryawanMiddleware;



Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/reload-captcha', [LoginController::class, 'reloadCaptcha']);


Route::middleware('is_admin')->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    });
    Route::resource('akun', AccountController::class);
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');