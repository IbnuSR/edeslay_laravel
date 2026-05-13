<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KegiatanListController extends Controller
{
    public function index()
    {
        $kegiatanList = DB::table('kegiatan')
            ->select('id', 'judul', 'deskripsi', 'tanggal', 'foto', 'foto_type')
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($item) {
                if ($item->foto) {
                    if ((strpos($item->foto, '/') !== false || strpos($item->foto, '.') !== false) 
                        && !preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $item->foto)) {
                        $item->image_url = Storage::url($item->foto);
                    } elseif ($item->foto_type) {
                        if (preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $item->foto)) {
                            $item->image_url = $item->foto_type . ';base64,' . $item->foto;
                        } else {
                            $item->image_url = $item->foto_type . ';base64,' . base64_encode($item->foto);
                        }
                    } else {
                        $item->image_url = 'https://via.placeholder.com/400x300?text=No+Image';
                    }
                } else {
                    $item->image_url = 'https://via.placeholder.com/400x300?text=No+Image';
                }
                return $item;
            });

        return view('kegiatan_list', compact('kegiatanList'));
    }
}