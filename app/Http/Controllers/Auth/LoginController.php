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
        // 1. Validasi input
        $request->validate([
            'username' => 'required|string|min:3',
            'password' => 'required|string|min:6',
        ], [
            'username.required' => 'Username wajib diisi',
            'username.min' => 'Username minimal 3 karakter',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        // 2. Cari user berdasarkan username
        $user = DB::table('users')->where('username', $request->username)->first();

        // 3. Cek username tidak ditemukan
        if (!$user) {
            return back()
                ->withErrors(['username' => 'Username tidak terdaftar'])
                ->withInput();
        }

        // 4. Cek password salah
        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['password' => 'Password yang Anda masukkan salah'])
                ->withInput();
        }

        // 5. Login & regenerasi session
        Auth::loginUsingId($user->id);
        $request->session()->regenerate();

        // 6. Redirect ke Admin Dashboard
        return redirect('/admin/dashboard')
            ->with('success', 'Selamat datang, ' . ($user->nama_lengkap ?? 'Administrator'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('info', 'Anda telah logout');
    }
}
