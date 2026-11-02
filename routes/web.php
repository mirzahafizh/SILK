
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminKaryawanController;

/*
|--------------------------------------------------------------------------
| HALAMAN LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});

/*
|--------------------------------------------------------------------------
| DASHBOARD DAN LAPORAN PJLP
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pjlp'])->group(function () {

    // Dashboard PJLP
    Route::get('/dashboard', [DashboardController::class, 'pjlp'])
        ->name('dashboard.pjlp');

    // Daftar laporan
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');

    // Form tambah laporan
    Route::get('/laporan/create', [LaporanController::class, 'create'])
        ->name('laporan.create');

    // Simpan laporan
    Route::post('/laporan', [LaporanController::class, 'store'])
        ->name('laporan.store');

    // Riwayat laporan berdasarkan bulan
    Route::get('/laporan/riwayat/{year}/{month}', [LaporanController::class, 'riwayatBulan'])
        ->where([
            'year' => '[0-9]{4}',
            'month' => '[0-9]{1,2}',
        ])
        ->name('laporan.bulan');
        
    Route::get('/laporan/{laporan}/edit', [LaporanController::class, 'edit'])
    ->name('laporan.edit');

    Route::put('/laporan/{laporan}', [LaporanController::class, 'update'])
    ->name('laporan.update');

    // Detail laporan
    Route::get('/laporan/{id}', [LaporanController::class, 'show'])
        ->whereNumber('id')
        ->name('laporan.show');

    // Hapus laporan
    Route::delete('/laporan/{id}', [LaporanController::class, 'destroy'])
        ->whereNumber('id')
        ->name('laporan.destroy');

});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard admin
        Route::get('/dashboard', [DashboardController::class, 'admin'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | DATA KARYAWAN
        |--------------------------------------------------------------------------
        */

        Route::get('/karyawan', [AdminKaryawanController::class, 'index'])
            ->name('karyawan.index');

        // Arsip laporan per bulan milik karyawan
        Route::get('/karyawan/{id}/bulan', [AdminKaryawanController::class, 'months'])
            ->whereNumber('id')
            ->name('karyawan.months');

        // Daftar laporan karyawan berdasarkan bulan
        Route::get('/karyawan/{id}/laporan/{year}/{month}', [AdminKaryawanController::class, 'laporan'])
            ->where([
                'id' => '[0-9]+',
                'year' => '[0-9]{4}',
                'month' => '[0-9]{1,2}',
            ])
            ->name('karyawan.laporan');

        /*
        |--------------------------------------------------------------------------
        | EXPORT LAPORAN
        |--------------------------------------------------------------------------
        */

        Route::get('/karyawan/{id}/laporan/{year}/{month}/pdf', [AdminKaryawanController::class, 'exportPdf'])
            ->where([
                'id' => '[0-9]+',
                'year' => '[0-9]{4}',
                'month' => '[0-9]{1,2}',
            ])
            ->name('karyawan.export.pdf');

        Route::get('/karyawan/{id}/laporan/{year}/{month}/excel', [AdminKaryawanController::class, 'exportExcel'])
            ->where([
                'id' => '[0-9]+',
                'year' => '[0-9]{4}',
                'month' => '[0-9]{1,2}',
            ])
            ->name('karyawan.export.excel');

        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI LAPORAN
        |--------------------------------------------------------------------------
        */

        Route::patch('/laporan/{id}/verifikasi', [AdminKaryawanController::class, 'verifikasi'])
            ->whereNumber('id')
            ->name('karyawan.verifikasi');

    });

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->role === 'pjlp') {
        return redirect()->route('dashboard.pjlp');
    }

    abort(403);

});
