<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sktm;

class PengajuanSuratApiController extends Controller
{
    // ================= STORE SKTM =================
    public function storeSKTM(Request $request)
    {
        try {

            $request->validate([

                'user_id' =>
                    'required',

                'nama_lengkap' =>
                    'required',

                'nik' =>
                    'required',

                'no_hp' =>
                    'required',

                'alamat' =>
                    'required',

                'tanggal_pengajuan' =>
                    'required',

                'jumlah_tanggungan' =>
                    'required',

                'status_ekonomi' =>
                    'required',

                'tujuan_sktm' =>
                    'required',

                'metode_pengambilan' =>
                    'required',

                'dokumen_scan' =>
                    'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $path = null;

            // ================= UPLOAD FOTO =================
            if ($request->hasFile('dokumen_scan')) {

                $file =
                    $request->file('dokumen_scan');

                $filename =
                    time() . '_' .
                    $file->getClientOriginalName();

                // BUAT FOLDER
                if (!file_exists(public_path('storage/sktm'))) {

                    mkdir(
                        public_path('storage/sktm'),
                        0777,
                        true
                    );
                }

                // MOVE FILE
                $file->move(
                    public_path('storage/sktm'),
                    $filename
                );

                $path =
                    'storage/sktm/' .
                    $filename;
            }

            // ================= SIMPAN DATABASE =================
            $sktm = new Sktm();

            $sktm->user_id =
                $request->user_id;

            $sktm->nama_lengkap =
                $request->nama_lengkap;

            $sktm->nik =
                $request->nik;

            $sktm->no_hp =
                $request->no_hp;

            $sktm->alamat =
                $request->alamat;

            $sktm->tanggal_pengajuan =
                $request->tanggal_pengajuan;

            $sktm->jumlah_tanggungan =
                $request->jumlah_tanggungan;

            $sktm->status_ekonomi =
                $request->status_ekonomi;

            // FIX DATABASE
            $sktm->tujuan_skmt =
                $request->tujuan_sktm;

            $sktm->metode_pengambilan =
                $request->metode_pengambilan;

            $sktm->dokumen_scan =
                $path;

            $sktm->status =
                'proses';

            $sktm->save();

            return response()->json([

                'success' => true,

                'message' =>
                    'Pengajuan berhasil dikirim',

                'data' => $sktm
            ]);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' =>
                    $e->getMessage()
            ], 500);
        }
    }

    // ================= RIWAYAT USER =================
    public function getSKTMByUser($userId)
    {
        $data = Sktm::where(
            'user_id',
            $userId
        )
            ->latest()
            ->get();

        return response()->json([

            'success' => true,

            'data' => $data
        ]);
    }

    // ================= GET ALL =================
    public function getSKTM()
    {
        $data = Sktm::latest()->get();

        return response()->json([

            'success' => true,

            'data' => $data
        ]);
    }
}