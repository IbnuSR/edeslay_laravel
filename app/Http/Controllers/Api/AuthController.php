<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use App\Models\Saran;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password' => 'required'
        ]);

        $identifier = $request->identifier;

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

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah'
            ]);
        }

        // FOTO URL
        $fotoUrl = null;

        if ($user->foto) {
            $fotoUrl = url('storage/' . $user->foto);
        }

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'nama_lengkap' => $user->nama_lengkap,
                'email' => $user->email,
                'role' => $user->role,
                'foto_url' => $fotoUrl,
            ]
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

    // ================= GET USER =================
    public function getUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'nama_lengkap' => $user->nama_lengkap,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,

                // 🔥 FOTO URL
                'foto_url' => $user->foto
                    ? asset('storage/' . $user->foto)
                    : '',
            ]
        ]);
    }


    // ================= UPDATE PROFILE =================
    public function updateProfile(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'nama_lengkap' => 'required',
            'username' => 'required',
        ]);

        $user = User::find($request->id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        // UPDATE DATA
        $user->nama_lengkap = $request->nama_lengkap;
        $user->username = $request->username;

        // ================= FOTO =================
        if ($request->hasFile('foto')) {

            // HAPUS FOTO LAMA
            if (
                $user->foto &&
                File::exists(storage_path('app/public/' . $user->foto))
            ) {

                File::delete(storage_path('app/public/' . $user->foto));
            }

            $file = $request->file('foto');

            $filename =
                time() . '_' . $file->getClientOriginalName();

            $path = $file->storeAs(
                'profile',
                $filename,
                'public'
            );

            $user->foto = $path;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diupdate',

            'user' => [
                'id' => $user->id,
                'nama_lengkap' => $user->nama_lengkap,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,

                'foto_url' => $user->foto
                    ? asset('storage/' . $user->foto)
                    : '',
            ]
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'old_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        $user = User::find($request->id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        //  CEK PASSWORD LAMA
        $isPasswordValid = Hash::check(
            $request->old_password,
            $user->password
        );

        // JIKA PASSWORD LAMA SALAH
        if (!$isPasswordValid) {

            // fallback kalau database lama masih plaintext
            if ($request->old_password != $user->password) {

                return response()->json([
                    'success' => false,
                    'message' => 'Password lama salah'
                ]);
            }
        }

        // UPDATE PASSWORD BARU
        $user->password = Hash::make(
            $request->new_password
        );

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah'
        ]);
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'email' => 'required|email|unique:users,email'
        ]);

        $user = User::find($request->id);

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        // ================= EMAIL LAMA =================
        $emailLama = $user->email;

        // ================= UPDATE EMAIL USER =================
        $user->email = $request->email;

        $user->save();

        // ================= UPDATE EMAIL DI SARAN =================
        Saran::where(
            'email',
            $emailLama
        )->update([
                    'email' => $request->email
                ]);

        // ================= FOTO URL =================
        $fotoUrl = '';

        if ($user->foto) {

            $fotoUrl = asset(
                'storage/' . $user->foto
            );
        }

        // ================= RESPONSE =================
        return response()->json([
            'success' => true,
            'message' => 'Email berhasil diperbarui',

            'user' => [
                'id' => $user->id,
                'nama_lengkap' => $user->nama_lengkap,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
                'foto_url' => $fotoUrl,
            ]
        ]);
    }
    // ================= SAVE FCM TOKEN =================
    public function saveFcmToken(Request $request)
    {
        $request->validate([

            'user_id' => 'required',
            'fcm_token' => 'required',
        ]);

        $user = User::find($request->user_id);

        if (!$user) {

            return response()->json([

                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        $user->fcm_token = $request->fcm_token;

        $user->save();

        return response()->json([

            'success' => true,
            'message' => 'FCM token berhasil disimpan'
        ]);
    }
}


