<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke Dashboard Admin
        if (Auth::check()) {
            return redirect('/admin/dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        // 2. Cari user
        $user = DB::table('users')->where('username', $request->username)->first();

        // 3. Cek username
        if (!$user) {
            return back()
                ->withErrors(['username' => 'Username tidak ditemukan'])
                ->withInput();
        }

        // 4. Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['password' => 'Password yang Anda masukkan salah'])
                ->withInput();
        }

        // 5. Login & session
        Auth::loginUsingId($user->id);
        $request->session()->regenerate();

        // 6. Redirect ke Admin Dashboard
        return redirect('/admin/dashboard')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // ✅ Redirect ke Dashboard Umum (bukan login)
        return redirect('/')->with('info', 'Anda telah logout');
    }
}