<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route Autentikasi (login, logout, register, reset password)
Auth::routes();

// Seluruh halaman aplikasi hanya dapat diakses setelah login
Route::middleware('auth')->group(function () {

    // Route Halaman Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    // Route Resource untuk Master Data Kelas
    Route::resource('kelas', KelasController::class)->except('show');

    // Route Resource untuk Master Data Siswa
    Route::resource('siswa', SiswaController::class);

    // Route Resource untuk Master Data Guru
    Route::resource('guru', GuruController::class)->except('show');

    // Route Resource untuk Master Data Mata Pelajaran (Mapel)
    Route::resource('mapel', MapelController::class)->except('show');

    // Route Resource untuk Data Nilai Akademik
    Route::resource('nilai', NilaiController::class)->except('show');

});
