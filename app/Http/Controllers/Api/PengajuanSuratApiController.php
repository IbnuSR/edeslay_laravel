<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sktm;
use App\Models\Domisili;
use App\Models\Penghasilan;

class PengajuanSuratApiController extends Controller
{
    // =========================================================
    // STORE SKTM
    // =========================================================
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

            // =====================================================
            // UPLOAD FOTO
            // =====================================================

            if ($request->hasFile('dokumen_scan')) {

                $file =
                    $request->file('dokumen_scan');

                $filename =
                    time() . '_' .
                    $file->getClientOriginalName();

                if (!file_exists(public_path('storage/sktm'))) {

                    mkdir(
                        public_path('storage/sktm'),
                        0777,
                        true
                    );
                }

                $file->move(
                    public_path('storage/sktm'),
                    $filename
                );

                $path =
                    'storage/sktm/' .
                    $filename;
            }

            // =====================================================
            // SIMPAN DATABASE
            // =====================================================

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

    // =========================================================
    // RIWAYAT SKTM USER
    // =========================================================
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

    // =========================================================
    // GET ALL SKTM
    // =========================================================
    public function getSKTM()
    {
        $data = Sktm::latest()->get();

        return response()->json([

            'success' => true,

            'data' => $data
        ]);
    }

    public function updateSKTM(Request $request, $id)
    {
        try {

            $sktm = Sktm::find($id);

            if (!$sktm) {

                return response()->json([

                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $path = $sktm->dokumen_scan;

            // ================= UPLOAD FILE BARU =================
            if ($request->hasFile('dokumen_scan')) {

                $file =
                    $request->file('dokumen_scan');

                $filename =
                    time() . '_' .
                    $file->getClientOriginalName();

                if (!file_exists(public_path('storage/sktm'))) {

                    mkdir(
                        public_path('storage/sktm'),
                        0777,
                        true
                    );
                }

                $file->move(
                    public_path('storage/sktm'),
                    $filename
                );

                $path =
                    'storage/sktm/' .
                    $filename;
            }

            // ================= UPDATE =================
            $sktm->nama_lengkap =
                $request->nama_lengkap;

            $sktm->nik =
                $request->nik;

            $sktm->no_hp =
                $request->no_hp;

            $sktm->alamat =
                $request->alamat;

            $sktm->jumlah_tanggungan =
                $request->jumlah_tanggungan;

            $sktm->status_ekonomi =
                $request->status_ekonomi;

            $sktm->tujuan_skmt =
                $request->tujuan_sktm;

            $sktm->dokumen_scan =
                $path;

            // RESET STATUS
            $sktm->status =
                'proses';

            // UPDATE TANGGAL
            $sktm->tanggal_pengajuan =
                now();

            // HAPUS PESAN ADMIN
            $sktm->keterangan_admin =
                null;
            $sktm->save();

            return response()->json([

                'success' => true,

                'message' =>
                    'Data berhasil diperbarui',

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

    // =========================================================
// STORE DOMISILI
// =========================================================
    public function storeDomisili(Request $request)
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

                'tempat_tinggal' =>
                    'required',

                'keperluan' =>
                    'required',

                'metode_pengambilan' =>
                    'required',

                'dokumen_scan' =>
                    'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $path = null;

            // =====================================================
            // UPLOAD FOTO
            // =====================================================

            if ($request->hasFile('dokumen_scan')) {

                $file =
                    $request->file('dokumen_scan');

                $filename =
                    time() . '_' .
                    $file->getClientOriginalName();

                // BUAT FOLDER
                if (
                    !file_exists(
                        public_path('storage/domisili')
                    )
                ) {

                    mkdir(
                        public_path('storage/domisili'),
                        0777,
                        true
                    );
                }

                // MOVE FILE
                $file->move(
                    public_path('storage/domisili'),
                    $filename
                );

                $path =
                    'storage/domisili/' .
                    $filename;
            }

            // =====================================================
            // SIMPAN DATABASE
            // =====================================================

            $domisili = new Domisili();

            $domisili->user_id =
                $request->user_id;

            $domisili->nama_lengkap =
                $request->nama_lengkap;

            $domisili->nik =
                $request->nik;

            $domisili->no_hp =
                $request->no_hp;

            $domisili->alamat =
                $request->alamat;

            $domisili->tanggal_pengajuan =
                $request->tanggal_pengajuan;

            $domisili->tempat_tinggal =
                $request->tempat_tinggal;

            $domisili->keperluan =
                $request->keperluan;

            $domisili->metode_pengambilan =
                $request->metode_pengambilan;

            $domisili->dokumen_scan =
                $path;

            $domisili->status =
                'proses';

            $domisili->save();

            return response()->json([

                'success' => true,

                'message' =>
                    'Pengajuan domisili berhasil',

                'data' => $domisili
            ]);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' =>
                    $e->getMessage()

            ], 500);
        }
    }

    // =========================================================
    // RIWAYAT DOMISILI USER
    // =========================================================
    public function getDomisiliByUser($userId)
    {
        $data = Domisili::where(
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
    // =========================================================
// UPDATE DOMISILI
// =========================================================
    public function updateDomisili(Request $request, $id)
    {
        try {

            $domisili = Domisili::find($id);

            if (!$domisili) {

                return response()->json([

                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $path = $domisili->dokumen_scan;

            // ================= UPLOAD FILE BARU =================
            if ($request->hasFile('dokumen_scan')) {

                $file =
                    $request->file('dokumen_scan');

                $filename =
                    time() . '_' .
                    $file->getClientOriginalName();

                if (!file_exists(public_path('storage/domisili'))) {

                    mkdir(
                        public_path('storage/domisili'),
                        0777,
                        true
                    );
                }

                $file->move(
                    public_path('storage/domisili'),
                    $filename
                );

                $path =
                    'storage/domisili/' .
                    $filename;
            }

            // ================= UPDATE =================
            $domisili->nama_lengkap =
                $request->nama_lengkap;

            $domisili->nik =
                $request->nik;

            $domisili->no_hp =
                $request->no_hp;

            $domisili->alamat =
                $request->alamat;

            $domisili->tempat_tinggal =
                $request->tempat_tinggal;

            $domisili->keperluan =
                $request->keperluan;

            $domisili->metode_pengambilan =
                $request->metode_pengambilan;

            $domisili->dokumen_scan =
                $path;

            // RESET STATUS
            $domisili->status =
                'proses';

            // UPDATE TANGGAL
            $domisili->tanggal_pengajuan =
                now();

            // HAPUS PESAN ADMIN
            $domisili->keterangan_admin =
                null;

            $domisili->save();

            return response()->json([

                'success' => true,

                'message' =>
                    'Data berhasil diperbarui',

                'data' => $domisili
            ]);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' =>
                    $e->getMessage()

            ], 500);
        }
    }
}