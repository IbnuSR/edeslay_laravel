<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        // Data profil
        $namaAdmin = $user->nama_lengkap ?? 'Administrator';
        $username = $user->username ?? '-';
        $email = $user->email ?? '-';
        $jenis_kelamin = $user->jenis_kelamin ?? '-';
        $no_telp = $user->no_telp ?? '-';
        $alamat = $user->alamat ?? '-';
        
        $fotoProfilSrc = !empty($user->foto) ? 'data:image/jpeg;base64,' . base64_encode($user->foto) : asset('assets/images/default.png');
        $coverSrc = !empty($user->cover) ? 'data:image/jpeg;base64,' . base64_encode($user->cover) : asset('assets/images/cover-default.jpg');

        return view('admin.profile', compact(
            'namaAdmin', 'username', 'email', 'jenis_kelamin', 'no_telp', 'alamat',
            'fotoProfilSrc', 'coverSrc'
        ));
    }
}