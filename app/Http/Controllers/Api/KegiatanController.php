<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    // ================= GET SEMUA =================
    public function getKegiatan()
    {
        $kegiatan = Kegiatan::latest()->get();

        foreach ($kegiatan as $item) {

            $item->foto_url = $item->foto
                ? url('storage/' . $item->foto)
                : null;
        }

        return response()->json([
            'success' => true,
            'data' => $kegiatan
        ]);
    }

    // ================= DETAIL =================
    public function detailKegiatan($id)
    {
        $kegiatan = Kegiatan::find($id);

        if (!$kegiatan) {

            return response()->json([
                'success' => false,
                'message' => 'Kegiatan tidak ditemukan'
            ]);
        }

        $kegiatan->foto_url = $kegiatan->foto
            ? url('storage/' . $kegiatan->foto)
            : null;

        return response()->json([
            'success' => true,
            'data' => $kegiatan
        ]);
    }
}