<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password' => 'required'
        ]);

        $identifier = $request->identifier;

        // cek apakah email atau username
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $identifier)->first();
        } else {
            $user = User::where('username', $identifier)->first();
        }

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        // sementara tanpa hash (sesuai kamu tadi)
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah'
            ]);
        }

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function sendOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email tidak ditemukan'
                ]);
            }

            $otp = rand(100000, 999999);

            $user->otp = $otp;
            $user->otp_expired = Carbon::now()->addMinutes(5);
            $user->save();

            try {
                Mail::to($user->email)->send(new OtpMail($otp));
            } catch (\Exception $e) {
                \Log::error("MAIL ERROR: " . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'OTP berhasil dibuat'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        if ($user->otp != $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'OTP salah'
            ]);
        }

        if (Carbon::now()->gt($user->otp_expired)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP sudah expired'
            ]);
        }



        return response()->json([
            'success' => true,
            'message' => 'OTP valid'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'new_password' => 'required|min:6'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        // VALIDASI OTP
        if ($user->otp != $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'OTP salah'
            ]);
        }

        if (Carbon::now()->gt($user->otp_expired)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP expired'
            ]);
        }

        // UPDATE PASSWORD
        $user->password = Hash::make($request->new_password);

        // HAPUS OTP (biar tidak bisa dipakai lagi)
        $user->otp = null;
        $user->otp_expired = null;

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah'
        ]);
    }
    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'name' => $request->nama_lengkap, // 🔥 penting
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'masyarakat'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'user' => $user
        ]);
    }
}