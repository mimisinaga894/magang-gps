<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KaryawanController as KaryawanDashboardController;
use App\Http\Controllers\Admin\KaryawanController as AdminKaryawanController;
use App\Http\Controllers\LokasiKantorController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\absensitraker;
use App\Http\Controllers\JadwalKerjaController;


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
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
        Route::get('/data-karyawan', [AdminController::class, 'dataKaryawan'])->name('admin.dataKaryawan');
        Route::get('/data-departemen', [AdminController::class, 'dataDepartemen'])->name('admin.dataDepartemen');

        Route::get('/edit-user/{id}', [AdminController::class, 'editUser'])->name('admin.editUser');
        Route::put('/update-user/{id}', [AdminController::class, 'updateUser'])->name('admin.updateUser');
        Route::delete('/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
        Route::get('/admin/user/create', [AdminController::class, 'createUser'])->name('admin.user.create');
        Route::post('/admin/user/store', [AdminController::class, 'storeUser'])->name('admin.storeUser');


        // Departemen
        Route::get('/departemen', [DepartemenController::class, 'index'])->name('admin.departemen');
        Route::get('/admin/data-departemen', [AdminController::class, 'dataDepartemen'])->name('admin.dataDepartemen');
        Route::post('/departemen/tambah', [DepartemenController::class, 'store'])->name('admin.departemen.store');
        Route::get('/departemen/perbarui', [DepartemenController::class, 'edit'])->name('admin.departemen.edit');
        Route::post('/departemen/perbarui', [DepartemenController::class, 'update'])->name('admin.departemen.update');
        Route::post('/departemen/hapus', [DepartemenController::class, 'delete'])->name('admin.departemen.delete');


        //karyawan
        Route::get('/karyawan', [AdminKaryawanController::class, 'index'])->name('admin.karyawan.index');
        Route::get('/admin/data-karyawan', [AdminController::class, 'dataKaryawan'])->name('admin.dataKaryawan');
        Route::resource('karyawan', AdminKaryawanController::class);


        // PRESENSI
        Route::get('/admin/absensi-tracker', [PresensiController::class, 'absensiTrackerAdmin'])->name('admin.absensi-tracker');
        Route::post('/admin/absensi-tracker', [PresensiController::class, 'storeAbsensi'])->name('admin.absensi.store');
        Route::get('/admin/absensi/manual', [PresensiController::class, 'formManualAbsensi'])->name('admin.absensi.manual-form');
        Route::post('/admin/absensi/manual', [PresensiController::class, 'storeManualAbsensi'])->name('admin.absensi.manual.store');
        Route::get('/admin/absensi/export/excel', [PresensiController::class, 'exportExcel'])->name('admin.absensi.export.excel');
        Route::get('/admin/absensi/export/pdf', [PresensiController::class, 'exportPDF'])->name('admin.absensi.export.pdf');
        Route::get('/laporan/presensi', [PresensiController::class, 'laporan'])->name('admin.laporan.presensi');


        // Jadwal Kerja
        Route::prefix('admin')->group(function () {
            Route::get('/jadwal-kerja', [JadwalKerjaController::class, 'index'])->name('jadwal.index');
            Route::get('/jadwal-kerja/create', [JadwalKerjaController::class, 'create'])->name('jadwal.create');
            Route::post('/jadwal-kerja', [JadwalKerjaController::class, 'store'])->name('jadwal.store');
        });
        Route::get('/jadwal-kerja/create', [JadwalKerjaController::class, 'create'])->name('jadwal.create');



        // Lokasi Kantor
        Route::get('/admin/lokasi-kantor', [AdminController::class, 'lokasiKantor'])->name('admin.lokasi-kantor');
    });

    // ==================== KARYAWAN ==================== //

    Route::prefix('karyawan')->group(function () {
        Route::get('/dashboard', [KaryawanDashboardController::class, 'showDashboard'])->name('karyawan.dashboard');
        Route::post('/absen-masuk', [KaryawanDashboardController::class, 'absenMasuk'])->name('absen.masuk');
        Route::post('/absen-pulang', [KaryawanDashboardController::class, 'absenPulang'])->name('absen.pulang');

        //Laporan    
        Route::get('/export-excel', [KaryawanDashboardController::class, 'exportExcel'])->name('karyawan.laporan.excel');
        Route::get('/export-pdf', [KaryawanDashboardController::class, 'exportPdf'])->name('karyawan.laporan.pdf');
    });

    // Cuti
    Route::middleware(['auth'])->group(function () {
        Route::post('/cuti/submit', [CutiController::class, 'store'])->name('cuti.submit');
    });
});
