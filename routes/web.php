<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
//use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\KegiatanDetailController;
use App\Http\Controllers\PrestasiDetailController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\PelayananController;
use App\Http\Controllers\Admin\PrestasiController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SaranController;
use App\Http\Controllers\Admin\StrukturController;
use App\Http\Controllers\DashboardUmumController;
use App\Http\Controllers\Admin\InfografisController;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail; 

/*
|--------------------------------------------------------------------------
| DEBUG ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/debug-check', function () {
    echo "<h2>DEBUG INFO</h2>";
    echo "<p><strong>Auth Check:</strong> " . (Auth::check() ? 'LOGIN' : 'NO LOGIN') . "</p>";
    echo "<p><strong>User ID:</strong> " . (Auth::id() ?? 'NULL') . "</p>";

    if (Auth::user()) {
        echo "<p><strong>Username:</strong> " . Auth::user()->username . "</p>";
        echo "<p><strong>Role:</strong> " . Auth::user()->role . "</p>";
    }
});

Route::get('/login-otomatis', function () {
    $user = DB::table('users')->where('username', 'admin')->first();
    if ($user) {
        Auth::loginUsingId($user->id);
        return redirect('/admin/dashboard');
    }
    return 'User admin tidak ditemukan';
});

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardUmumController::class, '__invoke'])->name('home');
Route::get('/kegiatan/{id}', [KegiatanDetailController::class, 'show'])->name('kegiatan.detail');
Route::get('/prestasi/{id}', [PrestasiDetailController::class, 'show'])->name('prestasi.detail');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    Route::get('/verify-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('password.verify');
    Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.otp.verify');
    //Route::get('/reset-password', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    //Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

// ================= ADMIN ROUTES =================
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ================= DASHBOARD =================
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // ================= PROFILE =================
        Route::get('/profile', [ProfileController::class, 'show'])
            ->name('profile');

        Route::get('/profile/edit', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

       
        // ================= KEGIATAN =================
        Route::get('/kegiatan', [KegiatanController::class, 'index'])
            ->name('kegiatan.index');

        Route::post('/kegiatan', [KegiatanController::class, 'store'])
            ->name('kegiatan.store');

        Route::get('/kegiatan/{id}', [KegiatanController::class, 'show'])
            ->whereNumber('id')
            ->name('kegiatan.show');

        Route::get('/kegiatan/{id}/edit', [KegiatanController::class, 'edit'])
            ->whereNumber('id')
            ->name('kegiatan.edit');

        Route::put('/kegiatan/{id}', [KegiatanController::class, 'update'])
            ->whereNumber('id')
            ->name('kegiatan.update');

        Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy'])
            ->whereNumber('id')
            ->name('kegiatan.destroy');

        // ================= PRESTASI =================
Route::get('/prestasi', [PrestasiController::class, 'index'])
    ->name('prestasi.index');

Route::post('/prestasi', [PrestasiController::class, 'store'])
    ->name('prestasi.store');

Route::get('/prestasi/{id}', [PrestasiController::class, 'show'])
    ->whereNumber('id')
    ->name('prestasi.show');

Route::get('/prestasi/{id}/edit', [PrestasiController::class, 'edit'])
    ->whereNumber('id')
    ->name('prestasi.edit');

Route::put('/prestasi/{id}', [PrestasiController::class, 'update'])
    ->whereNumber('id')
    ->name('prestasi.update');

Route::delete('/prestasi/{id}', [PrestasiController::class, 'destroy'])
    ->whereNumber('id')
    ->name('prestasi.destroy');

        // ================= PELAYANAN =================
Route::get('/pelayanan', [PelayananController::class, 'index'])
    ->name('pelayanan.index');

Route::post('/pelayanan', [PelayananController::class, 'store'])
    ->name('pelayanan.store');

Route::get('/pelayanan/{id}', [PelayananController::class, 'show'])
    ->whereNumber('id')
    ->name('pelayanan.show');

Route::get('/pelayanan/{id}/edit', [PelayananController::class, 'edit'])
    ->whereNumber('id')
    ->name('pelayanan.edit');

Route::put('/pelayanan/{id}', [PelayananController::class, 'update'])
    ->whereNumber('id')
    ->name('pelayanan.update');

Route::delete('/pelayanan/{id}', [PelayananController::class, 'destroy'])
    ->whereNumber('id')
    ->name('pelayanan.destroy');

        // ================= SARAN (ADMIN ONLY) =================
        Route::get('/saran', [SaranController::class, 'index'])
            ->name('saran.index');

        Route::delete('/saran/{id}', [SaranController::class, 'destroy'])
            ->whereNumber('id')
            ->name('saran.destroy');


        // ================= STRUKTUR =================
        Route::get('/struktur', [StrukturController::class, 'index'])
            ->name('struktur.index');

        Route::post('/struktur', [StrukturController::class, 'store'])
            ->name('struktur.store');
    });

 /*
|--------------------------------------------------------------------------
| PUBLIC API ROUTES (Untuk Mobile App - Tanpa CSRF)
|--------------------------------------------------------------------------
*/

// Mobile app bisa kirim saran tanpa login & tanpa CSRF
Route::post('/api/saran', [SaranController::class, 'store'])
    ->name('api.saran.store');



/*
|--------------------------------------------------------------------------
| FORCE LOGOUT
|--------------------------------------------------------------------------
*/

Route::get('/force-logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| API MOBILE
|--------------------------------------------------------------------------
*/
Route::get('/test-email', function () {
    try {
        Mail::raw('TES EMAIL LARAVEL', function ($message) {
            $message->to('edeslayapp@gmail.com')
                    ->subject('TES SMTP');
        });

        return "EMAIL TERKIRIM";
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});

