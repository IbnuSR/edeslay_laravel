<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PengajuanSuratApiController;

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

// ================= RIWAYAT USER =================

Route::get(
    '/pengajuan-sktm/user/{id}',
    [PengajuanSuratApiController::class,
    'getSKTMByUser']
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