<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminDataKursusController;
use App\Http\Controllers\AdminTambahDataKursusController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserKursusController;
use App\Http\Controllers\UserPetaController;
use App\Http\Controllers\UserDetailDataKursusController;
use App\Http\Controllers\UserHomeController;

// Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.home');
// Route::get('/admin/data-kursus', [AdminDataKursusController::class, 'index'])->name('admin.dataKursus');
// Route::get('/admin/tambah-data-kursus', [AdminTambahDataKursusController::class, 'create'])->name('admin.tambahDataKursus');

// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/', [UserHomeController::class, 'index'])->name('home');
Route::get('/kursus', [UserKursusController::class, 'index'])->name('user.kursus'); // Perbaikan pada rute ini
Route::get('/peta', [UserPetaController::class, 'index'])->name('user.peta');
// Route::get('/user/detail-data-kursus/{id}', [UserDetailDataKursusController::class, 'show'])->name('user.detailDataKursus');
