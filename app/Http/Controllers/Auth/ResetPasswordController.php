<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    public function showResetForm()
    {
        return view('auth.reset-password');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'User tidak ditemukan'
            ]);
        }

        if ($user->otp != $request->otp) {
            return back()->withErrors([
                'otp' => 'OTP salah'
            ]);
        }

        if (Carbon::now()->gt($user->otp_expired)) {
            return back()->withErrors([
                'otp' => 'OTP sudah expired'
            ]);
        }

        $user->password = Hash::make($request->password);

        $user->otp = null;
        $user->otp_expired = null;

        $user->save();

        return redirect('/login')->with(
            'success',
            'Password berhasil diubah'
        );
    }
}