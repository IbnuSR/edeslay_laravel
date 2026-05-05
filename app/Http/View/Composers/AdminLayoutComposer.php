<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AdminLayoutComposer
{
    /**
     * Create a new profile service instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            $fotoProfilSrc = null;
            if (!empty($user->foto)) {
                $fotoProfilSrc = filter_var($user->foto, FILTER_VALIDATE_URL) 
                    ? $user->foto 
                    : asset('storage/' . $user->foto);
            }

            $view->with([
                'currentUser' => $user,
                'fotoProfilSrc' => $fotoProfilSrc,
                'namaAdmin' => $user->nama_lengkap ?? 'Administrator',
                'roleAdmin' => $user->role ?? 'admin',
                'inisialAdmin' => strtoupper(substr($user->nama_lengkap ?? 'A', 0, 1)),
            ]);
        }
    }
}