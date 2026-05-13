<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StrukturDesaDetailController extends Controller
{
    public function __invoke()
    {
        $strukturDesa = DB::table('struktur_desa')
            ->select('id', 'nama', 'jabatan', 'nip', 'foto', 'urutan')
            ->orderBy('urutan', 'asc')
            ->get()
            ->map(function ($item) {
                $item->foto_url = $item->foto ? asset('storage/' . $item->foto) : asset('assets/images/default-avatar.png');
                return $item;
            });

        return view('struktur_desa_detail', compact('strukturDesa'));
    }
}