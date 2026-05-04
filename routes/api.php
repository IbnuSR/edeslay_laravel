<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

// TEST API
Route::get('/test-auth', function () {
    return response()->json([
        "message" => "AUTH OK"
    ]);
});

// 🔥 AUTH MOBILE API
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/resend-otp', [AuthController::class, 'sendOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);