<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

// Perhatikan ini: extends Controller (menghubungkan ke induknya)
class HomeController extends Controller
{
    public function __invoke()
    {
        // Logic ambil data dari database (sama seperti sebelumnya)
        $kegiatanList = DB::table('kegiatan')
            ->select('id', 'judul', 'deskripsi', 'tanggal', 'foto', 'foto_type')
            ->orderBy('tanggal', 'desc')
            ->get();

        $prestasiList = DB::table('prestasi')
            ->select('id', 'judul', 'deskripsi', 'tanggal', 'foto', 'foto_type')
            ->orderBy('tanggal', 'desc')
            ->get();

        $strukturDesa = DB::table('struktur_desa')
            ->select('jabatan', 'nama')
            ->orderBy('id', 'asc')
            ->get();

        // Helper gambar
        $processImages = function($items) {
            return $items->map(function($item) {
                if ($item->foto && $item->foto_type) {
                    $item->image_url = '' . $item->foto_type . ';base64,' . base64_encode($item->foto);
                } else {
                    $item->image_url = 'https://via.placeholder.com/400x300?text=No+Image';
                }
                return $item;
            });
        };

        $kegiatanList = $processImages($kegiatanList);
        $prestasiList = $processImages($prestasiList);

        return view('dashboard_umum', compact(
            'kegiatanList',
            'prestasiList',
            'strukturDesa'
        ));
    }
}