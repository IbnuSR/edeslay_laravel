<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Handle logout request.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Logout user dari session Laravel
        Auth::logout();
        
        // Invalidate session untuk keamanan
        $request->session()->invalidate();
        
        // Regenerate CSRF token untuk mencegah session fixation
        $request->session()->regenerateToken();
        
        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')
            ->with('status', 'Anda telah berhasil logout.');
    }
}