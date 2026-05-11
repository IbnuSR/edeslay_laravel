<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\KegiatanController as ApiKegiatanController;
use App\Http\Controllers\Api\PrestasiController as ApiPrestasiController;
use App\Http\Controllers\Api\PelayananController as ApiPelayananController;
use App\Http\Controllers\Api\StrukturController as ApiStrukturController;
use App\Http\Controllers\Api\InfografisController as ApiInfografisController;
use App\Http\Controllers\Api\PengajuanSuratController as ApiPengajuanSuratController;

/*
|--------------------------------------------------------------------------
| API Routes - Mobile App
|--------------------------------------------------------------------------
*/

// 🔥 PUBLIC ROUTES (Tanpa Auth / Token)

// Test Connection
Route::get('/test', function () {
    return response()->json([
        "status" => "success",
        "message" => "API Desa Banjardowo Online ✅",
        "timestamp" => now()
    ]);
});

// Auth Mobile API
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('api.otp.send');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('api.otp.resend');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('api.otp.verify');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('api.password.reset');

// Public Data: Kegiatan
Route::get('/kegiatan', [ApiKegiatanController::class, 'index'])->name('api.kegiatan.index');
Route::get('/kegiatan/{id}', [ApiKegiatanController::class, 'show'])->name('api.kegiatan.show');
Route::get('/kegiatan/kategori/{kategori}', [ApiKegiatanController::class, 'byKategori'])->name('api.kegiatan.kategori');

// Public Data: Prestasi
Route::get('/prestasi', [ApiPrestasiController::class, 'index'])->name('api.prestasi.index');
Route::get('/prestasi/{id}', [ApiPrestasiController::class, 'show'])->name('api.prestasi.show');

// Public Data: Pelayanan
Route::get('/pelayanan', [ApiPelayananController::class, 'index'])->name('api.pelayanan.index');

// Public Data: Struktur Organisasi
Route::get('/struktur', [ApiStrukturController::class, 'index'])->name('api.struktur.index');

// Public Data: Infografis / Statistik Penduduk
Route::get('/infografis', [ApiInfografisController::class, 'index'])->name('api.infografis.index');
Route::get('/infografis/detail', [ApiInfografisController::class, 'detail'])->name('api.infografis.detail');

// Public: Kirim Saran/Kritik
Route::post('/saran', [\App\Http\Controllers\Admin\SaranController::class, 'store'])->name('api.saran.store');

// Public: Info Jenis Surat yang Tersedia
Route::get('/surat/jenis', [ApiPengajuanSuratController::class, 'jenisSurat'])->name('api.surat.jenis');

// 🔥 PROTECTED ROUTES (Butuh Token Bearer - Auth:Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    
    // Get user data yang sedang login
    Route::get('/user', function (Request $request) {
        return response()->json([
            "status" => "success",
            "data" => $request->user()
        ]);
    })->name('api.user');
    
    // Logout (Hapus Token)
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    
    // Update Profile User Mobile
    Route::put('/user/profile', [AuthController::class, 'updateProfile'])->name('api.user.update');
    
    // ================= PENGAJUAN SURAT API (Protected) =================
    
    // Submit Pengajuan Surat Baru
    Route::post('/pengajuan/store', [ApiPengajuanSuratController::class, 'store'])->name('api.pengajuan.store');
    
    // Upload Dokumen Tambahan untuk Pengajuan
    Route::post('/pengajuan/{id}/upload', [ApiPengajuanSuratController::class, 'uploadDokumen'])->name('api.pengajuan.upload');
    
    // Cek Status Pengajuan (by ID)
    Route::get('/pengajuan/{jenis}/{id}/status', [ApiPengajuanSuratController::class, 'status'])->name('api.pengajuan.status');
    
    // Riwayat Semua Pengajuan User (by Auth User / NIK)
    Route::get('/pengajuan/riwayat', [ApiPengajuanSuratController::class, 'riwayat'])->name('api.pengajuan.riwayat');
    
    // Download Surat Jadi (PDF) - Jika Status Sudah 'selesai'
    Route::get('/pengajuan/{jenis}/{id}/download', [ApiPengajuanSuratController::class, 'download'])->name('api.pengajuan.download');
    
    // Hapus/Batalkan Pengajuan (Jika masih 'proses')
    Route::delete('/pengajuan/{jenis}/{id}', [ApiPengajuanSuratController::class, 'cancel'])->name('api.pengajuan.cancel');
    
    // ================= DATA PENDUDUK (Protected - Optional) =================
    // Jika ingin membatasi akses data penduduk hanya untuk user terauth
    Route::get('/penduduk/saya', function (Request $request) {
        $nik = $request->user()->nik;
        $data = \App\Models\Penduduk::where('nik', $nik)->first();
        return response()->json([
            "status" => $data ? "success" : "not_found",
            "data" => $data
        ]);
    })->name('api.penduduk.saya');

});

/*
|--------------------------------------------------------------------------
| FALLBACK ROUTE (Jika endpoint tidak ditemukan)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->json([
        "status" => "error",
        "message" => "API Endpoint tidak ditemukan ❌",
        "hint" => "Cek dokumentasi API atau hubungi admin desa"
    ], 404);
});