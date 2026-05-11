<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes - Mobile App
|--------------------------------------------------------------------------
*/

// 🔥 PUBLIC ROUTES (Tanpa Auth)
Route::get('/test-auth', function () {
    return response()->json(["message" => "AUTH OK"]);
});

// Auth Mobile API
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/resend-otp', [AuthController::class, 'sendOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// 🔥 PROTECTED ROUTES (Butuh Token)
Route::middleware('auth:sanctum')->group(function () {
    
    // Get user data yang sedang login
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // ✅ CONTOH: API Data Penduduk untuk Mobile
    // Route::get('/penduduk', function (Request $request) {
    //     return response()->json(\App\Models\Penduduk::paginate(10));
    // });
    
});