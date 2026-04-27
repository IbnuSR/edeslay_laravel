<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    // Tampilkan form reset password
    public function showResetForm()
    {
        // Hanya bisa akses jika email sudah diverifikasi via OTP
        if (!session('reset_email')) {
            return redirect()->route('password.request')
                ->with('error', 'Silakan verifikasi email terlebih dahulu.');
        }
        return view('auth.reset-password');
    }

    // Proses reset password
    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $email = session('reset_email');

        // Update password (pakai MD5 sesuai database kamu)
        $updated = DB::table('users')
            ->where('email', $email)
            ->update([
                'password' => md5($request->password), // MD5 sesuai native code kamu
                'updated_at' => now(),
            ]);

        if ($updated) {
            // Hapus session & OTP
            session()->forget(['reset_email']);
            DB::table('password_reset_otps')->where('email', $email)->delete();

            return redirect()->route('login')
                ->with('status', 'Password berhasil direset. Silakan login dengan password baru.');
        }

        return back()->withErrors(['error' => 'Gagal mereset password. Silakan coba lagi.']);
    }
}