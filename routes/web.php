<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArsipSuratController;
use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Halaman utama - arsip surat
Route::get('/', [ArsipSuratController::class, 'index'])->name('home');

// Resource routes untuk arsip surat
Route::resource('arsip-surat', ArsipSuratController::class);

// Route khusus untuk download file
Route::get('/arsip-surat/{id}/download', [ArsipSuratController::class, 'download'])->name('arsip-surat.download');

// Route untuk pencarian
Route::get('/search', [ArsipSuratController::class, 'search'])->name('arsip-surat.search');

// Resource routes untuk kategori surat
Route::resource('kategori-surat', KategoriSuratController::class);

// Halaman About
Route::get('/about', [HomeController::class, 'about'])->name('about');
