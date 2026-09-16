<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfilController;

// ==================== WELCOME ====================
Route::get('/', function () {
    if (Auth::check()) return redirect()->route('dashboard');
    return view('welcome');
})->name('welcome');

// ==================== AUTH ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==================== AUTHENTICATED ====================
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::post('/profil/ganti-password', [ProfilController::class, 'gantiPassword'])->name('profil.ganti-password');

    // Notifikasi
    Route::get('/notifikasi', [TiketController::class, 'notifikasi'])->name('notifikasi');

    // ==================== TIKET ====================
    Route::prefix('tiket')->name('tiket.')->group(function () {

        // Semua role bisa lihat daftar dan detail
        Route::get('/', [TiketController::class, 'index'])->name('index');
        Route::get('/{tiket}', [TiketController::class, 'show'])->name('show');

        // Hanya PIC OPD yang bisa buat laporan baru
        Route::middleware('role:pic_opd')->group(function () {
            Route::get('/create/baru', [TiketController::class, 'create'])->name('create');
            Route::post('/', [TiketController::class, 'store'])->name('store');
            Route::post('/{tiket}/konfirmasi', [TiketController::class, 'konfirmasiSelesai'])->name('konfirmasi');
        });

        // Hanya CSIRT yang bisa update status
        Route::middleware('role:csirt')->group(function () {
            Route::post('/{tiket}/status', [TiketController::class, 'updateStatus'])->name('update-status');
        });
    });

    // ==================== LAPORAN ====================
    Route::middleware('role:csirt,kabid_aptika,admin')->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
    });

    // ==================== ADMIN ====================
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        // OPD
        Route::get('/opd', [AdminController::class, 'opdIndex'])->name('opd.index');
        Route::post('/opd', [AdminController::class, 'opdStore'])->name('opd.store');
        Route::put('/opd/{opd}', [AdminController::class, 'opdUpdate'])->name('opd.update');
        Route::delete('/opd/{opd}', [AdminController::class, 'opdDestroy'])->name('opd.destroy');

        // User
        Route::get('/user', [AdminController::class, 'userIndex'])->name('user.index');
        Route::post('/user', [AdminController::class, 'userStore'])->name('user.store');
        Route::put('/user/{user}', [AdminController::class, 'userUpdate'])->name('user.update');
        Route::delete('/user/{user}', [AdminController::class, 'userDestroy'])->name('user.destroy');

        // Kategori Insiden
        Route::get('/kategori', [AdminController::class, 'kategoriIndex'])->name('kategori.index');
        Route::post('/kategori', [AdminController::class, 'kategoriStore'])->name('kategori.store');
        Route::delete('/kategori/{kategoriInsiden}', [AdminController::class, 'kategoriDestroy'])->name('kategori.destroy');

        // SLA Config
        Route::put('/sla/{slaConfig}', [AdminController::class, 'slaUpdate'])->name('sla.update');
    });
});
