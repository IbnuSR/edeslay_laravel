<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PengajuanSuratApiController;
use App\Http\Controllers\Api\PengajuanPenghasilanApiController;
use App\Http\Controllers\Api\PengajuanKelahiranApiController;
use App\Http\Controllers\Api\PengajuanKtpApiController;
use App\Http\Controllers\Api\PengajuanKematianApiController;
use App\Http\Controllers\Api\PengajuanIzinApiController;
use App\Http\Controllers\Api\PengajuanNikahApiController;
use App\Http\Controllers\Api\RiwayatApiController;

// =========================================================
// CONTROLLER API MOBILE
// =========================================================

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KegiatanController;
use App\Http\Controllers\Api\SaranController;

// =========================================================
// API MOBILE + WEB TERPADU
// =========================================================

// ================= TEST API =================

Route::get('/test', function () {
    return response()->json([
        "status" => "success",
        "message" => "API Desa Online ✅",
        "timestamp" => now()
    ]);
});

// =========================================================
// AUTH MOBILE
// =========================================================

Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/send-otp', [AuthController::class, 'sendOtp']);

Route::post('/resend-otp', [AuthController::class, 'sendOtp']);

Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::post(
    '/save-fcm-token',
    [AuthController::class, 'saveFcmToken']
);

// =========================================================
// USER PROFILE MOBILE
// =========================================================

Route::get('/user/{id}', [AuthController::class, 'getUser']);

Route::post('/update-profile', [AuthController::class, 'updateProfile']);

Route::post('/change-password', [AuthController::class, 'changePassword']);

Route::post('/update-email', [AuthController::class, 'updateEmail']);

// =========================================================
// SARAN MOBILE
// =========================================================

Route::get('/saran/{email}', [SaranController::class, 'getSaranUser']);

Route::post('/tambah-saran', [SaranController::class, 'tambahSaran']);

Route::get('/detail-saran/{id}', [SaranController::class, 'detailSaran']);

Route::post('/update-saran', [SaranController::class, 'updateSaran']);

Route::delete('/delete-saran/{id}', [SaranController::class, 'deleteSaran']);

// =========================================================
// KEGIATAN MOBILE
// =========================================================

Route::get('/kegiatan', [KegiatanController::class, 'getKegiatan']);

Route::get('/detail-kegiatan/{id}', [KegiatanController::class, 'detailKegiatan']);

// =========================================================
// SKTM MOBILE
// =========================================================

// ================= SKTM =================

Route::post(
    '/pengajuan-sktm',
    [PengajuanSuratApiController::class, 'storeSKTM']
);

Route::get(
    '/pengajuan-sktm',
    [PengajuanSuratApiController::class, 'getSKTM']
);

Route::post(
    '/update-sktm/{id}',
    [PengajuanSuratApiController::class, 'updateSKTM']
);
// ================= DOMISILI =================

Route::post(
    '/pengajuan-domisili',
    [PengajuanSuratApiController::class, 'storeDomisili']
);

Route::get(
    '/pengajuan-domisili/user/{id}',
    [PengajuanSuratApiController::class, 'getDomisiliByUser']
);

Route::post(
    '/update-domisili/{id}',
    [PengajuanSuratApiController::class, 'updateDomisili']
);

// ================= PENGHASILAN =================

Route::post(
    '/pengajuan-penghasilan',
    [PengajuanPenghasilanApiController::class, 'store']
);

Route::get(
    '/pengajuan-penghasilan',
    [PengajuanPenghasilanApiController::class, 'getAll']
);

Route::get(
    '/pengajuan-penghasilan/{id}',
    [PengajuanPenghasilanApiController::class, 'detail']
);

Route::post(
    '/penghasilan/update/{id}',
    [PengajuanPenghasilanApiController::class, 'update']
);

// ================= KELAHIRAN =================
Route::post(
    '/pengajuan-kelahiran',
    [PengajuanKelahiranApiController::class, 'store']
);

Route::get(
    '/pengajuan-kelahiran/user/{id}',
    [PengajuanKelahiranApiController::class, 'riwayat']
);

Route::post(
    '/kelahiran/update/{id}',
    [PengajuanKelahiranApiController::class, 'update']
);


// ================= PENGANTAR KTP =================
Route::post(
    '/pengajuan-ktp',
    [PengajuanKtpApiController::class, 'store']
);

Route::get(
    '/pengajuan-ktp/{userId}',
    [PengajuanKtpApiController::class, 'getByUser']
);

Route::get(
    '/pengajuan-ktp-detail/{id}',
    [PengajuanKtpApiController::class, 'detail']
);

Route::post(
    '/ktp/update/{id}',
    [PengajuanKtpApiController::class, 'update']
);

// ================= KEMATIAN =================
Route::post(
    '/pengajuan-kematian',
    [PengajuanKematianApiController::class, 'store']
);

Route::get(
    '/pengajuan-kematian/user/{id}',
    [PengajuanKematianApiController::class, 'riwayat']
);

Route::post(
    '/kematian/update/{id}',
    [PengajuanKematianApiController::class, 'update']
);

// ================= IZIN =================
Route::post(
    '/pengajuan-izin',
    [PengajuanIzinApiController::class, 'store']
);

Route::get(
    '/pengajuan-izin/user/{id}',
    [PengajuanIzinApiController::class, 'riwayat']
);

Route::post(
    '/izin/update/{id}',
    [PengajuanIzinApiController::class, 'update']
);


// ================= NIKAH =================
Route::post(
    'pengajuan-nikah',
    [PengajuanNikahApiController::class, 'store']
);

Route::get(
    'pengajuan-nikah/user/{id}',
    [PengajuanNikahApiController::class, 'riwayat']
);

Route::post(
    '/nikah/update/{id}',
    [PengajuanNikahApiController::class, 'update']
);

// ================= RIWAYAT USER =================

Route::get(
    '/riwayat/{userId}',
    [RiwayatApiController::class, 'index']
);

Route::delete(
    '/riwayat/{jenis}/{id}',
    [RiwayatApiController::class, 'delete']
);

Route::get(
    '/pengajuan-penghasilan/user/{id}',
    [PengajuanPenghasilanApiController::class, 'getByUser']
);

Route::get(
    '/riwayat/{jenis}/{id}',
    [RiwayatApiController::class, 'detail']
);

// =========================================================
// API WEBSITE YANG SUDAH ADA
// =========================================================

// Saran Publik Website
Route::post('/saran', [\App\Http\Controllers\Admin\SaranController::class, 'store']);

// =========================================================
// PROTECTED ROUTES SANCTUM
// =========================================================

Route::middleware('auth:sanctum')->group(function () {

    // USER LOGIN
    Route::get('/user', function (Request $request) {

        return response()->json([
            "status" => "success",
            "data" => $request->user()
        ]);

    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

});

// =========================================================
// FALLBACK API
// =========================================================

Route::fallback(function () {

    return response()->json([
        "status" => "error",
        "message" => "API Endpoint tidak ditemukan ❌"
    ], 404);

});