<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PrestasiDetailController extends Controller
{
    /**
     * Show prestasi detail page.
     */
    public function show($id)
    {
        // Ambil data prestasi berdasarkan ID
        $prestasi = DB::table('prestasi')
            ->select('id', 'judul', 'deskripsi', 'tanggal', 'foto', 'foto_type')
            ->where('id', $id)
            ->first();

        // Jika tidak ditemukan, redirect ke homepage
        if (!$prestasi) {
            return redirect()->route('home')->with('error', 'Prestasi tidak ditemukan.');
        }

        // Helper: Convert BLOB to base64 image URL
        $image_url = null;
        if ($prestasi->foto && $prestasi->foto_type) {
            // Cek apakah sudah base64 atau raw binary
            if (preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $prestasi->foto)) {
                $image_url = '' . $prestasi->foto_type . ';base64,' . $prestasi->foto;
            } else {
                $image_url = '' . $prestasi->foto_type . ';base64,' . base64_encode($prestasi->foto);
            }
        }

        // Format tanggal dengan Carbon
        $formatted_date = \Carbon\Carbon::parse($prestasi->tanggal)->isoFormat('D MMMM Y');

        // Kirim data ke View
        return view('prestasi_detail', compact(
            'prestasi',
            'image_url',
            'formatted_date'
        ));
    }
}