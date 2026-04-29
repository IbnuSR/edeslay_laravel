<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InfografisController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $data = [
            'action' => 'list',
            'namaAdmin' => $user->nama_lengkap,
            'roleAdmin' => $user->role,
        ];

        $data['infografisList'] = DB::table('infografis')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.infografis', $data);
    }

    public function store(Request $request)
    {
        DB::table('infografis')->insert([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.infografis.index')
            ->with('success', 'Berhasil ditambahkan');
    }
}