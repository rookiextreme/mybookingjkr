<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Segment\Dashboard\DashboardController;
use App\Http\Controllers\Segment\Admin\Tetapan\Lokasi\TetapanLokasiController;
use App\Http\Controllers\Segment\Admin\Tetapan\Fasiliti\TetapanFasilitiController;
use App\Http\Controllers\Segment\Admin\Tetapan\Bangunan\TetapanBangunanController;
use App\Http\Controllers\Segment\Admin\Bilik\BilikController;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Segment\Pengguna\Tempahan\TempahanBilikController;
use App\Http\Controllers\Segment\Admin\Tempahan\Bilik\AdminTempahanBilikController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthenticatedSessionController::class, 'create']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/get-events', [DashboardController::class, 'getEvents'])->name('getEvents');

Route::prefix('/admin')->group(function () {
    Route::prefix('/tetapan')->group(function () {
        Route::prefix('/lokasi')->group(function () {
            Route::get('/', [TetapanLokasiController::class, 'index']);
            Route::get('/get-list', [TetapanLokasiController::class, 'getLokasiList']);
            Route::post('/store-update', [TetapanLokasiController::class, 'lokasiStoreUpdate']);
            Route::post('/get-lokasi', [TetapanLokasiController::class, 'getLokasi']);
            Route::post('/activate', [TetapanLokasiController::class, 'activateLokasi']);
            Route::post('/delete', [TetapanLokasiController::class, 'deleteLokasi']);
        });

        Route::prefix('/fasiliti')->group(function () {
            Route::get('/', [TetapanFasilitiController::class, 'index']);
            Route::get('/get-list', [TetapanFasilitiController::class, 'getFasilitiList']);
            Route::post('/store-update', [TetapanFasilitiController::class, 'fasilitiStoreUpdate']);
            Route::post('/get-fasiliti', [TetapanFasilitiController::class, 'getFasiliti']);
            Route::post('/activate', [TetapanFasilitiController::class, 'activateFasiliti']);
            Route::post('/delete', [TetapanFasilitiController::class, 'deleteFasiliti']);
        });

        Route::prefix('/bangunan')->group(function () {
            Route::get('/', [TetapanBangunanController::class, 'index']);
            Route::get('/get-list', [TetapanBangunanController::class, 'getBangunanList']);
            Route::post('/store-update', [TetapanBangunanController::class, 'bangunanStoreUpdate']);
            Route::post('/get-bangunan', [TetapanBangunanController::class, 'getBangunan']);
            Route::post('/activate', [TetapanBangunanController::class, 'activateBangunan']);
            Route::post('/delete', [TetapanBangunanController::class, 'deleteBangunan']);
        });
    });

    Route::prefix('/bilik')->group(function () {
        Route::get('/', [BilikController::class, 'index']);
        Route::get('/get-list', [BilikController::class, 'getBilikList']);
        Route::post('/store-update', [BilikController::class, 'bilikStoreUpdate']);
        Route::post('/get-bilik', [BilikController::class, 'getBilik']);
        Route::post('/activate', [BilikController::class, 'activateBilik']);
        Route::post('/delete', [BilikController::class, 'deleteBilik']);
    });

    Route::prefix('/tempahan')->group(function () {
        Route::prefix('/bilik')->group(function () {
            Route::get('/', [AdminTempahanBilikController::class, 'index']);
            Route::get('/get-list', [AdminTempahanBilikController::class, 'getTempahanBilikList']);
            Route::post('/get-tempahan', [AdminTempahanBilikController::class, 'getTempahanBilik']);
            Route::post('/lulus', [AdminTempahanBilikController::class, 'lulusTempahanBilik']);
        });
    });
});

Route::prefix('/pengguna')->group(function () {
    Route::prefix('/tempahan')->group(function () {
        Route::prefix('/bilik')->group(function () {
            Route::get('/', [TempahanBilikController::class, 'index']);
            Route::get('/get-list', [TempahanBilikController::class, 'getTempahanBilikList']);
            Route::post('/store-update', [TempahanBilikController::class, 'tempahanBilikStoreUpdate']);
            Route::post('/get-tempahan-bilik', [TempahanBilikController::class, 'getTempahanBilik']);
            Route::post('/delete', [TempahanBilikController::class, 'deleteTempahanBilik']);
            Route::post('/tengok-kosong', [TempahanBilikController::class, 'tengokKosongTempahanBilik']);
        });
    });
});

Route::prefix('/common')->group(function () {
    Route::post('/get-bangunan', [CommonController::class, 'getbangunan']);
    Route::get('/pengguna-carian', [CommonController::class, 'pengguna_carian']);
    Route::post('/pengguna-telefon', [CommonController::class, 'pengguna_telefon']);

});

require __DIR__.'/auth.php';
