<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KegiatanDetailController extends Controller
{
    /**
     * Show kegiatan detail page.
     */
    public function show($id)
    {
        // Ambil data kegiatan berdasarkan ID
        $kegiatan = DB::table('kegiatan')
            ->select('id', 'judul', 'deskripsi', 'tanggal', 'foto', 'foto_type')
            ->where('id', $id)
            ->first();

        // Jika tidak ditemukan, redirect ke homepage
        if (!$kegiatan) {
            return redirect()->route('home')->with('error', 'Kegiatan tidak ditemukan.');
        }

        // Helper: Convert BLOB to base64 image URL
        $image_url = null;
        if ($kegiatan->foto && $kegiatan->foto_type) {
            // Cek apakah sudah base64 atau raw binary
            if (preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $kegiatan->foto)) {
                $image_url = 'data:' . $kegiatan->foto_type . ';base64,' . $kegiatan->foto;
            } else {
                $image_url = 'data:' . $kegiatan->foto_type . ';base64,' . base64_encode($kegiatan->foto);
            }
        }

        // Format tanggal dengan Carbon
        $formatted_date = \Carbon\Carbon::parse($kegiatan->tanggal)->isoFormat('D MMMM Y');

        // Kirim data ke View
        return view('kegiatan_detail', compact(
            'kegiatan',
            'image_url',
            'formatted_date'
        ));
    }
}