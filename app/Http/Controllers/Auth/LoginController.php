<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) return redirect()->intended('/admin/dashboard');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate(['username' => 'required|string']);
        $user = DB::table('users')->where('username', $request->username)->first();
        
        if (!$user) return back()->withErrors(['username' => 'Username tidak ditemukan'])->onlyInput('username');
        
        Auth::loginUsingId($user->id);
        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}