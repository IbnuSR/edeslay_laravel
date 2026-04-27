<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil user yang sedang login
        $user = Auth::user();

        // Cek apakah role-nya 'admin' (trim untuk hapus spasi)
        if (trim($user->role) === 'admin') {
            return $next($request);
        }

        // Jika bukan admin
        return redirect()->route('login')->with('error', 'Akses ditolak. Anda tidak memiliki akses sebagai admin.');
    }
}