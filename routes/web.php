<?php

use App\Constants\DashboardConstant;
use App\Constants\InstansiConstant;
use App\Constants\BeritaAcaraConstant;
use App\Constants\BeritaAcaraRekomendasiConstant;
use App\Constants\BeritaAcaraTandatanganConstant;
use App\Constants\InstansiKontakConstant;
use App\Constants\KuesionerBagianConstant;
use App\Constants\KuesionerConstant;
use App\Constants\KuesionerPertanyaanConstant;
use App\Constants\KuesionerPertanyaanPilihanConstant;
use App\Constants\KuesionerPertanyaanPenilaianConstant;
use App\Constants\KuesionerRespondenConstant;
use App\Constants\PenilaianAspekConstant;
use App\Constants\EvaluasiConstant;
use App\Constants\PenilaianIndikatorConstant;
use App\Constants\PenilaianKelompokConstant;
use App\Constants\JadwalConstant;
use App\Constants\SiteConstant;
use App\Constants\UserConstant;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\InstansiKontakController;
use App\Http\Controllers\BeritaAcaraController;
use App\Http\Controllers\BeritaAcaraRekomendasiController;
use App\Http\Controllers\BeritaAcaraTandatanganController;
use App\Http\Controllers\KuesionerBagianController;
use App\Http\Controllers\KuesionerController;
use App\Http\Controllers\KuesionerPertanyaanController;
use App\Http\Controllers\KuesionerPertanyaanPilihanController;
use App\Http\Controllers\KuesionerPertanyaanPenilaianController;
use App\Http\Controllers\PenilaianAspekController;
use App\Http\Controllers\EvaluasiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenilaianIndikatorController;
use App\Http\Controllers\PenilaianKelompokController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KuesionerRespondenController;
use Illuminate\Support\Facades\Route;


// Route::get('/', [HomeController::class, 'index']);
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])->name(DashboardConstant::RouteIndex);
Route::get('/dashboard/instansi', [DashboardController::class, 'instansi'])->name(DashboardConstant::RouteInstansi);

// INSTANSI
Route::get('/instansi/index', [InstansiController::class, 'index'])->name(InstansiConstant::RouteIndex);
Route::get('/instansi/create', [InstansiController::class, 'create'])->name(InstansiConstant::RouteCreate);
Route::post('/instansi/create', [InstansiController::class, 'create'])->name(InstansiConstant::RouteCreateProcess);
Route::get('/instansi/update', [InstansiController::class, 'update'])->name(InstansiConstant::RouteUpdate);
Route::post('/instansi/update', [InstansiController::class, 'update'])->name(InstansiConstant::RouteUpdateProcess);
Route::get('/instansi/read', [InstansiController::class, 'read'])->name(InstansiConstant::RouteRead);
Route::post('/instansi/delete', [InstansiController::class, 'delete'])->name(InstansiConstant::RouteDelete);
Route::get('/instansi/export-excel', [InstansiController::class, 'exportExcel'])->name(InstansiConstant::RouteExportExcel);
Route::get('/instansi/index-pengisian', [InstansiController::class, 'indexPengisian'])->name(InstansiConstant::RouteIndexPengisian);
Route::get('/instansi/index-penilaian', [InstansiController::class, 'indexPenilaian'])->name(InstansiConstant::RouteIndexPenilaian);
Route::get('/instansi/index-berita-acara', [InstansiController::class, 'indexBeritaAcara'])->name(InstansiConstant::RouteIndexBeritaAcara);

// USER
Route::get('/user/index', [UserController::class, 'index'])->name(UserConstant::RouteIndex);
Route::get('/user/create', [UserController::class, 'create'])->name(UserConstant::RouteCreate);
Route::post('/user/create', [UserController::class, 'create'])->name(UserConstant::RouteCreateProcess);
Route::get('/user/update', [UserController::class, 'update'])->name(UserConstant::RouteUpdate);
Route::post('/user/update', [UserController::class, 'update'])->name(UserConstant::RouteUpdateProcess);
Route::get('/user/set-password', [UserController::class, 'setPassword'])->name(UserConstant::RouteSetPassword);
Route::post('/user/set-password', [UserController::class, 'setPassword'])->name(UserConstant::RouteSetPasswordProcess);
Route::get('/user/change-password', [UserController::class, 'changePassword'])->name(UserConstant::RouteChangePassword);
Route::post('/user/change-password', [UserController::class, 'changePassword'])->name(UserConstant::RouteChangePasswordProcess);
Route::get('/user/read', [UserController::class, 'read'])->name(UserConstant::RouteRead);
Route::post('/user/delete', [UserController::class, 'delete'])->name(UserConstant::RouteDelete);
Route::get('/user/export-excel', [UserController::class, 'exportExcel'])->name(UserConstant::RouteExportExcel);
Route::post('/user/reset-password-default-all', [UserController::class, 'resetPasswordDefaultAll'])->name(UserConstant::RouteResetPasswordDefaultAll);