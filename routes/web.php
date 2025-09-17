<?php

use App\Http\Controllers\ArsipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\PageUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Halaman admin
    Route::middleware('role:admin')->group(function () {
        // Route::get('/admin/index', fn() => view('admin.page-admin'))->name('admin.index');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/biodata/index', fn() => view('admin.biodata'))->name('biodata.index');

        Route::prefix('arsip')->group(function () {
            Route::get('/create', [ArsipController::class, 'create'])->name('arsip.create');
            Route::post('/store', [ArsipController::class, 'store'])->name('arsip.store');
            Route::get('/{id}/edit', [ArsipController::class, 'edit'])->name('arsip.edit');
            Route::post('/{id}/update', [ArsipController::class, 'update'])->name('arsip.update-file');
            Route::delete('/delete/{id}', [ArsipController::class, 'destroy'])->name('arsip.destroy');
        });

        Route::prefix('kategori-surat')->group(function () {
            Route::get('/', [KategoriSuratController::class, 'index'])->name('kategori-surat.index');
            Route::get('/create', [KategoriSuratController::class, 'create'])->name('kategori-surat.create');
            Route::post('/store', [KategoriSuratController::class, 'store'])->name('kategori-surat.store');
            Route::get('/{id}/edit', [KategoriSuratController::class, 'edit'])->name('kategori-surat.edit');
            Route::put('/{id}/update', [KategoriSuratController::class, 'update'])->name('kategori-surat.update');
            Route::delete('/{id}/destroy', [KategoriSuratController::class, 'destroy'])->name('kategori-surat.destroy');
        });
    });

    Route::middleware('role:user')->group(function () {
        // Route::get('/user/index', fn() => view('user.page-user'))->name('user.index');
        Route::get('/dashboard-user', [PageUserController::class, 'index'])->name('dashboard-user.index');
    });

    Route::prefix('arsip')->group(function () {
        Route::get('/', [ArsipController::class, 'index'])->name('arsip.index');
        Route::get('/download/{id}', [ArsipController::class, 'download'])->name('arsip.download');
        Route::get('/show/{id}', [ArsipController::class, 'show'])->name('arsip.show');
    });
});
