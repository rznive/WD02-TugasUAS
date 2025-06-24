<?php

use App\Http\Controllers\adminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\dokterController;
use App\Http\Controllers\pasienController;
use Illuminate\Support\Facades\Auth;

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
Route::get('/pages/auth/login-dokter', function () {
    return view('pages.auth.loginDokter');
})->name('loginDokter');
Route::post('/pages/auth/login-dokter', [authController::class, 'loginDokter']);
Route::post('/logout', function () {
    Auth::guard('web')->logout();
    Auth::guard('pasien')->logout();
    Auth::guard('dokter')->logout();
    return redirect('/pages/auth/login');
})->name('logout');


// Pasien
Route::get('/pages/pasien', function () {
    return view('pages.pasien.dashboard');
})->name('dashboard.pasien')->middleware('auth:pasien');
Route::get('/pages/pasien/poli', [pasienController::class, 'Poli'])->name('poli.dokter')->middleware('auth:pasien');
Route::post('/pages/pasien/poli', [pasienController::class, 'CRUDPoli'])->name('poli.pasien')->middleware('auth:pasien');
Route::get('/get-jadwal-by-poli/{id_poli}', [PasienController::class, 'getJadwalByPoli']);


// Dokter
Route::get('/pages/dokter', function () {
    return view('pages.dokter.dashboard');
})->name('dashboard.dokter')->middleware('auth:dokter');
Route::get('/pages/dokter/jadwalPeriksa', [dokterController::class, 'jadwalPeriksa'])->name('jadwalPeriksa.dokter')->middleware('auth:dokter');
Route::post('/pages/dokter/jadwalPeriksa', [dokterController::class, 'CRUDJadwal'])->name('jadwalPeriksa.dokter')->middleware('auth:dokter');
Route::get('/pages/dokter/periksaPasien', [dokterController::class, 'periksaPasien'])->name('periksaPasien.dokter')->middleware('auth:dokter');
Route::get('/pages/dokter/profile', function () {
    return view('pages.dokter.profile');
})->name('profile.dokter')->middleware('auth:dokter');
Route::post('/pages/dokter/profile', [dokterController::class, 'editProfile'])->name('editProfile.dokter')->middleware('auth:dokter');


// Admin
Route::get('/pages/admin', function () {
    return view('pages.admin.dashboard');
})->name('dashboard.admin')->middleware('auth:web');
Route::get('/pages/admin/pasien', [adminController::class, 'pasien'])->name('pasien.admin')->middleware('auth:web');
Route::post('/pages/admin/pasien', [adminController::class, 'crudPasien'])->name('crudPasien.admin')->middleware('auth:web');
Route::delete('/pages/admin/pasien/{id}', [adminController::class, 'deletePasien'])->name('deletePasien.admin')->middleware('auth:web');
Route::get('/pages/admin/dokter', [adminController::class, 'dokter'])->name('dokter.admin')->middleware('auth:web');
Route::post('/pages/admin/dokter', [adminController::class, 'crudDokter'])->name('crudDokter.admin')->middleware('auth:web');
Route::delete('/pages/admin/dokter/{id}', [adminController::class, 'deleteDokter'])->name('deleteDokter.admin')->middleware('auth:web');
Route::get('/pages/admin/poli', [adminController::class, 'poli'])->name('poli.admin')->middleware('auth:web');
Route::post('/pages/admin/poli', [adminController::class, 'crudPoli'])->name('crudPoli.admin')->middleware('auth:web');
Route::delete('/pages/admin/poli/{id}', [adminController::class, 'deletePoli'])->name('deletePoli.admin')->middleware('auth:web');
Route::get('/pages/admin/obat', [adminController::class, 'obat'])->name('obat.admin')->middleware('auth:web');
Route::post('/pages/admin/obat', [adminController::class, 'crudObat'])->name('crudObat.admin')->middleware('auth:web');
Route::delete('/pages/admin/obat/{id}', [adminController::class, 'deleteObat'])->name('deleteObat.admin')->middleware('auth:web');
