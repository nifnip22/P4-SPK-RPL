<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('lib.dashboard', ['title' => 'Dashboard | PicoPick Cashier']);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(PenjualanController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/kasir-penjualan', 'index')->name('kasir-penjualan.index');
    Route::post('/kasir-penjualan/proses', 'prosesPenjualan')->name('kasir-penjualan.proses');
    Route::get('/kasir-penjualan/search', 'search')->name('kasir-penjualan.search');
});

Route::controller(PelangganController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/daftar-pelanggan', 'index')->name('daftar-pelanggan.index');
    Route::post('/daftar-pelanggan/store', 'store')->name('daftar-pelanggan.store');
});

Route::controller(PetugasController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/data-petugas', 'index')->name('data-petugas.index');
    Route::post('data-petugas/search', 'search')->name('data-petugas.search');
    Route::post('/data-petugas', 'store')->name('data-petugas.store');
    Route::delete('/data-petugas/destroy/{petugas}', 'destroy')->name('data-petugas.destroy');
});

Route::controller(ProdukController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/data-produk', 'index')->name('data-produk.index');
    Route::post('/data-produk/store', 'store')->name('data-produk.store');
    Route::put('/data-produk/update/{produk}', 'update')->name('data-produk.update');
    Route::delete('/data-produk/destroy/{produk}', 'destroy')->name('data-produk.destroy');
    Route::get('/data-produk/search', 'search')->name('data-produk.search');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
