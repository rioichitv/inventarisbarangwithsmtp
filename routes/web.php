<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\WebConfigController;
use Illuminate\Support\Facades\Route;

// Halaman utama (frontend)
Route::get('/', [FrontendController::class, 'index'])->name('home');

// Auth
Route::get('/login',        [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',       [AuthController::class, 'login'])->name('login.post');
Route::get('/login/otp',    [AuthController::class, 'showOtp'])->name('login.otp');
Route::post('/login/otp',   [AuthController::class, 'verifyOtp'])->name('login.otp.verify');
Route::post('/login/otp/resend', [AuthController::class, 'resendOtp'])->name('login.otp.resend');
Route::post('/logout',      [AuthController::class, 'logout'])->name('logout');

// Protected
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Barang
    Route::get('/barang/autocomplete', [BarangController::class, 'autocomplete'])->name('barang.autocomplete');
    Route::resource('barang', BarangController::class);

    // Barang Keluar
    Route::resource('barang-keluar', BarangKeluarController::class);

    // Kategori
    Route::resource('kategori', KategoriController::class)->except(['show']);

    // Log Aktivitas
    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');

    // Web Config
    Route::get('/settings/web-config', [WebConfigController::class, 'index'])->name('settings.web-config');
    Route::post('/settings/web-config', [WebConfigController::class, 'store'])->name('settings.web-config.store');
});
