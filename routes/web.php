<?php

use App\Http\Controllers\adminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/pages/auth/register', function () {
    return view('pages.auth.registerPasien');
})->name('registerPasien');
Route::post('/pages/auth/register', [authController::class, 'register']);
Route::get('/pages/auth/login', function () {
    return view('pages.auth.loginPasien');
})->name('loginPasien');
Route::post('/pages/auth/login', [authController::class, 'login']);


// Pasien
Route::get('/pages/pasien', function () {
    return view('pages.pasien.dashboard');
})->name('dashboard.pasien');
Route::get('/pages/pasien/poli', function () {
    return view('pages.pasien.poli');
})->name('poli.pasien');


// Dokter
Route::get('/pages/dokter', function () {
    return view('pages.dokter.dashboard');
})->name('dashboard.dokter');
Route::get('/pages/dokter/jadwalPeriksa', function () {
    return view('pages.dokter.jadwal');
})->name('jadwal.dokter');

// Admin
Route::get('/pages/admin', function () {
    return view('pages.admin.dashboard');
})->name('dashboard.admin');
Route::get('/pages/admin/pasien', [adminController::class, 'pasien'])->name('pasien.admin');
Route::post('/pages/admin/pasien', [adminController::class, 'crudPasien'])->name('crudPasien.admin');
Route::delete('/pages/admin/pasien/{id}', [adminController::class, 'deletePasien'])->name('deletePasien.admin');
Route::get('/pages/admin/dokter', [adminController::class, 'dokter'])->name('dokter.admin');
Route::post('/pages/admin/dokter', [adminController::class, 'crudDokter'])->name('crudDokter.admin');
Route::delete('/pages/admin/dokter/{id}', [adminController::class, 'deleteDokter'])->name('deleteDokter.admin');
Route::get('/pages/admin/poli', [adminController::class, 'poli'])->name('poli.admin');
Route::post('/pages/admin/poli', [adminController::class, 'crudPoli'])->name('crudPoli.admin');
Route::delete('/pages/admin/poli/{id}', [adminController::class, 'deletePoli'])->name('deletePoli.admin');
Route::get('/pages/admin/obat', [adminController::class, 'obat'])->name('obat.admin');
Route::post('/pages/admin/obat', [adminController::class, 'crudObat'])->name('crudObat.admin');
Route::delete('/pages/admin/obat/{id}', [adminController::class, 'deleteObat'])->name('deleteObat.admin');
