<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    // Tampilkan form lupa password
    public function showLinkRequestForm()
    {
        return view('auth.forgot_password');
    }

    // Kirim OTP ke email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak ditemukan di sistem.',
        ]);

        $email = $request->email;
        $user = DB::table('users')->where('email', $email)->first();

        // Generate OTP 6 digit
        $otp = rand(100000, 999999);
        $expiry = now()->addMinutes(5);

        // Simpan OTP ke database (atau session untuk sementara)
        DB::table('password_reset_otps')->updateOrInsert(
            ['email' => $email],
            [
                'otp' => $otp,
                'expires_at' => $expiry,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Simpan email di session untuk verifikasi nanti
        session(['reset_email' => $email]);

        // Kirim email (pakai Mail facade Laravel)
        try {
            Mail::raw("
                Halo, {$user->username}!

                Kode OTP untuk reset password akun Anda adalah: {$otp}

                Kode ini berlaku selama 5 menit.

                Jika Anda tidak meminta reset password, abaikan email ini.
            ", function ($message) use ($email) {
                $message->to($email)
                        ->subject('Kode OTP Reset Password E-Deslay')
                        ->from('noreply@edeslay.test', 'E-Deslay');
            });

            return back()->with('status', 'Kode OTP telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            // Fallback: tampilkan OTP di layar jika email gagal (untuk development)
            if (app()->environment('local')) {
                return back()->with('status', 'Kode OTP: ' . $otp . ' (Email gagal, mode development)')
                            ->with('debug_otp', $otp);
            }
            return back()->withErrors(['email' => 'Gagal mengirim kode OTP. Silakan coba lagi.']);
        }
    }

    // Tampilkan form verifikasi OTP
    public function showOtpForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.verify-otp');
    }

    // Verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $email = session('reset_email');
        $otpRecord = DB::table('password_reset_otps')
            ->where('email', $email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kadaluarsa.']);
        }

        // OTP valid, lanjut ke form reset password
        return redirect()->route('password.reset');
    }
}