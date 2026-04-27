<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->intended('/admin/dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Debug: Tampilkan apa yang dikirim
        Log::info('=== LOGIN ATTEMPT ===');
        Log::info('Username: ' . $request->username);
        
        // Validasi
        $request->validate([
            'username' => 'required|string|max:100',
        ]);

        // Cari user
        $user = DB::table('users')->where('username', $request->username)->first();
        
        // Debug: Tampilkan hasil query
        Log::info('User found: ' . ($user ? 'YES' : 'NO'));
        if ($user) {
            Log::info('User ID: ' . $user->id);
            Log::info('User Role: ' . $user->role);
        }

        if ($user) {
            // Login
            Auth::loginUsingId($user->id);
            
            // Debug: Cek apakah sudah login
            Log::info('Auth check after login: ' . (Auth::check() ? 'SUCCESS' : 'FAILED'));
            Log::info('Auth user ID: ' . (Auth::id() ?? 'NULL'));
            
            $request->session()->regenerate();
            
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username "' . $request->username . '" tidak ditemukan.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}