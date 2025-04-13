<?php

use App\Http\Controllers\{
  UserController,
  DashboardController,
  RekapLaporanController,
  RekapLaporanDetailBerkalaController,
  RekapLaporanDetailInsidentalController,
};

use Illuminate\Support\Facades\Route;

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

Route::impersonate();

Route::get('/', function () {
  return view('auth.login');
});

Route::group([
  'middleware' => 'auth'
], function () {
  // Dashboard
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('redirect_by_role');

  // Profil
  Route::get('user/profil', [UserController::class, 'showFormProfil'])->name('user.show_form_profil');
  Route::post('user/update_profil', [UserController::class, 'updateProfil'])->name('user.update_profil');
  Route::post('user/update_password', [UserController::class, 'updatePassword'])->name('user.update_password');

  // Rekap Laporan
  Route::group([], function () {
    Route::get('rekap_laporan', [RekapLaporanController::class, 'index'])->name('rekap_laporan.index');
    Route::get('rekap_laporan/data', [RekapLaporanController::class, 'data'])->name('rekap_laporan.data');

    Route::get('rekap_laporan/{nama_ljk}', [RekapLaporanController::class, 'show'])->name('rekap_laporan.show');
    Route::get('rekap_laporan/{nama_ljk}/data', [RekapLaporanController::class, 'show_data'])->name('rekap_laporan.show_data');
    Route::get('rekap_laporan_detail/{jenis_laporan}', [RekapLaporanController::class, 'show_detail'])->name('rekap_laporan_detail.show_data');

    Route::get('rekap_detail/laporan_berkala', [RekapLaporanDetailBerkalaController::class, 'index'])->name('rekap_laporan.detail.berkala.index');
    Route::get('rekap_detail/laporan_berkala/data', [RekapLaporanDetailBerkalaController::class, 'data'])->name('rekap_laporan.detail.berkala.data');

    Route::get('rekap_detail/laporan_insidental', [RekapLaporanDetailInsidentalController::class, 'index'])->name('rekap_laporan.detail.insidental.index');
    Route::get('rekap_detail/laporan_insidental/data', [RekapLaporanDetailInsidentalController::class, 'data'])->name('rekap_laporan.detail.insidental.data');

    Route::get('rekap_laporan_hampir_terlambat', [RekapLaporanController::class, 'show_hampir_terlambat'])->name('rekap_laporan.show_hampir_terlambat.index');
    Route::get('rekap_laporan_hampir_terlambat/data', [RekapLaporanController::class, 'show_hampir_terlambat_data'])->name('rekap_laporan.show_hampir_terlambat.data');
  });
});
