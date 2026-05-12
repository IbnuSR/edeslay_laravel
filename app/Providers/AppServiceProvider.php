<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Asset;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ Share data profil ke SEMUA view secara global
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                
                $view->with('namaAdmin', $user->nama_lengkap ?? 'Administrator');
                $view->with('roleAdmin', $user->role ?? 'admin');
                $view->with('inisialAdmin', strtoupper(substr($user->nama_lengkap ?? 'A', 0, 1)));
                
                $fotoSrc = null;
                if (!empty($user->foto)) {
                    $fotoSrc = filter_var($user->foto, FILTER_VALIDATE_URL) 
                        ? $user->foto 
                        : asset('storage/' . $user->foto);
                }
                $view->with('fotoProfilSrc', $fotoSrc);
            }
        });
    }
}