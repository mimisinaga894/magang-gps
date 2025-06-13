<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\LokasiKantorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CutiController;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route(Auth::user()->role . '.dashboard');
    }
    return redirect()->route('login');
});

// ==================== AUTH & PROFILE ==================== //
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route(Auth::user()->role . '.dashboard');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');


// Route lupa password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Route reset password
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// ==================== LOGIN GOOGLE ==================== //
Route::get('/login/google/redirect', [SocialiteController::class, 'redirect'])->name('google.redirect');
Route::get('/login/google/callback', [SocialiteController::class, 'callback'])->name('google.callback');


// ==================== AUTHENTICATED ROUTES ==================== //
Route::middleware('auth')->group(function () {

    // Profile
    Route::middleware('auth')->group(function () {
        Route::get('/admin/pengaturan-akun', [ProfileController::class, 'edit'])->name('admin.pengaturan-akun');
        Route::patch('/admin/pengaturan-akun', [ProfileController::class, 'update'])->name('profile.update');
    });


    // dashboard
    Route::get('/dashboard', function () {
        return redirect()->route(Auth::user()->role . '.dashboard');
    })->name('dashboard');

    // ==================== ADMIN ==================== //
    Route::prefix('admin')->group(function () {

        // Dashboard & Data
        Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
        Route::get('/data-karyawan', [AdminController::class, 'dataKaryawan'])->name('admin.dataKaryawan');
        Route::get('/data-departemen', [AdminController::class, 'dataDepartemen'])->name('admin.dataDepartemen');

        Route::get('/edit-user/{id}', [AdminController::class, 'editUser'])->name('admin.editUser');
        Route::put('/update-user/{id}', [AdminController::class, 'updateUser'])->name('admin.updateUser');
        Route::delete('/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
        Route::get('/admin/user/create', [AdminController::class, 'createUser'])->name('admin.user.create');
        Route::post('/admin/user/store', [AdminController::class, 'storeUser'])->name('admin.user.store');


        // Departemen
        Route::get('/departemen', [AdminController::class, 'departemen'])->name('admin.departemen');
        Route::get('/admin/data-departemen', [AdminController::class, 'dataDepartemen'])->name('admin.dataDepartemen');
        Route::post('/departemen/tambah', [DepartemenController::class, 'store'])->name('admin.departemen.store');
        Route::get('/departemen/perbarui', [DepartemenController::class, 'edit'])->name('admin.departemen.edit');
        Route::post('/departemen/perbarui', [DepartemenController::class, 'update'])->name('admin.departemen.update');
        Route::post('/departemen/hapus', [DepartemenController::class, 'delete'])->name('admin.departemen.delete');

        // Presensi
        Route::get('/monitoring-presensi', [PresensiController::class, 'monitoringPresensi'])->name('admin.monitoring-presensi');
        Route::post('/monitoring-presensi', [PresensiController::class, 'viewLokasi'])->name('admin.monitoring-presensi.lokasi');

        // Laporan Presensi
        Route::get('/laporan/presensi', [PresensiController::class, 'laporan'])->name('admin.laporan.presensi');
        Route::post('/laporan/presensi/karyawan', [PresensiController::class, 'laporanPresensiKaryawan'])->name('admin.laporan.presensi.karyawan');
        Route::post('/laporan/presensi/semua-karyawan', [PresensiController::class, 'laporanPresensiSemuaKaryawan'])->name('admin.laporan.presensi.semua-karyawan');

        // Lokasi Kantor
        Route::get('/lokasi', [LokasiKantorController::class, 'index'])->name('admin.lokasi-kantor');
        Route::post('/lokasi/tambah', [LokasiKantorController::class, 'store'])->name('admin.lokasi-kantor.store');
        Route::get('/lokasi/perbarui', [LokasiKantorController::class, 'edit'])->name('admin.lokasi-kantor.edit');
        Route::post('/lokasi/perbarui', [LokasiKantorController::class, 'update'])->name('admin.lokasi-kantor.update');
        Route::post('/lokasi/hapus', [LokasiKantorController::class, 'delete'])->name('admin.lokasi-kantor.delete');
    });

    // ==================== KARYAWAN ==================== //
    Route::prefix('karyawan')->group(function () {
        Route::get('/dashboard', [KaryawanController::class, 'showDashboard'])->name('karyawan.dashboard');
        Route::post('/absen-masuk', [KaryawanController::class, 'absenMasuk'])->name('absen.masuk');
        Route::post('/absen-pulang', [KaryawanController::class, 'absenPulang'])->name('absen.pulang');

        // Laporan
        Route::get('/export-excel', [KaryawanController::class, 'exportExcel'])->name('karyawan.laporan.excel');
        Route::get('/export-pdf', [KaryawanController::class, 'exportPdf'])->name('karyawan.laporan.pdf');
    });

    // Cuti
    Route::middleware(['auth'])->group(function () {
        Route::post('/cuti/submit', [CutiController::class, 'store'])->name('cuti.submit');
    });
});
