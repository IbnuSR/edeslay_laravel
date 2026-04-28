<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KegiatanDetailController;        
use App\Http\Controllers\PrestasiDetailController; 
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\PelayananController;
use App\Http\Controllers\Admin\PrestasiController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SaranController;
use App\Http\Controllers\Admin\StrukturController;

// ============================================================================
// 🔧 DEBUG ROUTES (Hapus setelah login berhasil)
// ============================================================================

// Debug: Cek session & auth status
Route::get('/debug-check', function() {
    echo "<h2>DEBUG INFO</h2>";
    echo "<p><strong>Auth Check:</strong> " . (Auth::check() ? '✅ LOGGED IN' : '❌ NOT LOGGED IN') . "</p>";
    echo "<p><strong>Auth User ID:</strong> " . (Auth::id() ?? 'NULL') . "</p>";
    
    if (Auth::user()) {
        echo "<p><strong>Username:</strong> " . Auth::user()->username . "</p>";
        echo "<p><strong>Role:</strong> " . Auth::user()->role . "</p>";
    }
    
    echo "<hr><a href='/login'>← Back to Login</a>";
});

// Debug: Login otomatis sebagai admin (TESTING SAJA)
Route::get('/login-otomatis', function() {
    $user = DB::table('users')->where('username', 'admin')->first();
    if ($user) {
        Auth::loginUsingId($user->id);
        return redirect('/admin/dashboard');
    }
    return 'User admin tidak ditemukan';
});

// ============================================================================
// 🌐 PUBLIC ROUTES
// ============================================================================

Route::get('/', [HomeController::class, '__invoke'])->name('home');
Route::get('/kegiatan/{id}', [KegiatanDetailController::class, 'show'])->name('kegiatan.detail');
Route::get('/prestasi/{id}', [PrestasiDetailController::class, 'show'])->name('prestasi.detail');

// ============================================================================
// 🔐 AUTH ROUTES
// ============================================================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    
    // Forgot Password Flow
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    Route::get('/verify-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('password.verify');
    Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.otp.verify');
    Route::get('/reset-password', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

// ============================================================================
// 👨‍💼 ADMIN ROUTES (HANYA PAKAI 'auth' MIDDLEWARE)
// ============================================================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // CRUD Kegiatan
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan');
    Route::post('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.store');
    
    // CRUD Prestasi
    Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi');
    Route::post('/prestasi', [PrestasiController::class, 'index'])->name('prestasi.store');
    
    // CRUD Pelayanan
    Route::get('/pelayanan', [PelayananController::class, 'index'])->name('pelayanan');
    Route::post('/pelayanan', [PelayananController::class, 'index'])->name('pelayanan.store');
    
    // CRUD Saran
    Route::get('/saran', [SaranController::class, 'index'])->name('saran');
    Route::post('/saran', [SaranController::class, 'index'])->name('saran.store');
    
    // CRUD Struktur
    Route::get('/struktur', [StrukturController::class, 'index'])->name('struktur');
    Route::post('/struktur', [StrukturController::class, 'index'])->name('struktur.store');
    
    // ✅ TIDAK ADA LAGI ROUTE CLOSURE YANG MENIMPA DI SINI!
});