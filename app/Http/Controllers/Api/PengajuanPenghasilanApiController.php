<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPenghasilan;

class PengajuanPenghasilanApiController extends Controller
{
    // ================= STORE =================
    public function store(Request $request)
    {
        try {

            $request->validate([

                'user_id' =>
                    'required',

                'nama_lengkap' =>
                    'required',

                'nik' =>
                    'required|digits:16',

                'no_hp' =>
                    'required|min:10|max:13',

                'alamat' =>
                    'required',

                'tanggal_pengajuan' =>
                    'required',

                'pekerjaan' =>
                    'required',

                'jumlah_penghasilan' =>
                    'required',

                'jumlah_tanggungan' =>
                    'required|integer',

                'tujuan_pengajuan' =>
                    'required',

                'metode_pengambilan' =>
                    'required',

                'dokumen_scan' =>
                    'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $path = null;

            // ================= UPLOAD =================
            if ($request->hasFile('dokumen_scan')) {

                $file =
                    $request->file('dokumen_scan');

                $filename =
                    time() . '_penghasilan_' .
                    $file->getClientOriginalName();

                if (
                    !file_exists(
                        public_path(
                            'storage/penghasilan'
                        )
                    )
                ) {

                    mkdir(
                        public_path(
                            'storage/penghasilan'
                        ),
                        0777,
                        true
                    );
                }

                $file->move(
                    public_path(
                        'storage/penghasilan'
                    ),
                    $filename
                );

                $path =
                    'storage/penghasilan/' .
                    $filename;
            }

            // ================= SIMPAN =================
            $data =
                new PengajuanPenghasilan();

            $data->user_id =
                $request->user_id;

            $data->nama_lengkap =
                $request->nama_lengkap;

            $data->nik =
                $request->nik;

            $data->no_hp =
                $request->no_hp;

            $data->alamat =
                $request->alamat;

            $data->tanggal_pengajuan =
                $request->tanggal_pengajuan;

            $data->pekerjaan =
                $request->pekerjaan;

            $data->jumlah_penghasilan =
                $request->jumlah_penghasilan;

            $data->jumlah_tanggungan =
                $request->jumlah_tanggungan;

            $data->tujuan_pengajuan =
                $request->tujuan_pengajuan;

            $data->metode_pengambilan =
                $request->metode_pengambilan;

            $data->dokumen_scan =
                $path;

            $data->status =
                'proses';

            $data->save();

            return response()->json([

                'success' => true,

                'message' =>
                    'Pengajuan berhasil dikirim',

                'data' => $data
            ]);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' =>
                    $e->getMessage()
            ], 500);
        }
    }

    // ================= GET ALL =================
    public function getAll()
    {
        $data =
            PengajuanPenghasilan::latest()
                ->get();

        return response()->json([

            'success' => true,

            'data' => $data
        ]);
    }

    // ================= DETAIL =================
    public function detail($id)
    {
        $data =
            PengajuanPenghasilan::find($id);

        return response()->json([

            'success' => true,

            'data' => $data
        ]);
    }
    // ================= GET BY USER =================
    public function getByUser($id)
    {
        $data =
            PengajuanPenghasilan::where(
                'user_id',
                $id
            )
                ->latest()
                ->get();

        return response()->json([

            'success' => true,
            'data' => $data
        ]);
    }
    // ================= UPDATE =================
    public function update(
        Request $request,
        $id
    ) {
        try {

            $data =
                PengajuanPenghasilan::find($id);

            if (!$data) {

                return response()->json([

                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $path =
                $data->dokumen_scan;

            // ================= UPLOAD BARU =================
            if ($request->hasFile('dokumen_scan')) {

                $file =
                    $request->file('dokumen_scan');

                $filename =
                    time() .
                    '_penghasilan.' .
                    $file->getClientOriginalExtension();

                $tujuan =
                    public_path(
                        'storage/penghasilan'
                    );

                if (!file_exists($tujuan)) {

                    mkdir(
                        $tujuan,
                        0777,
                        true
                    );
                }

                $file->move(
                    $tujuan,
                    $filename
                );

                $path =
                    'storage/penghasilan/' .
                    $filename;
            }

            // ================= UPDATE =================
            $data->nama_lengkap =
                $request->nama_lengkap;

            $data->nik =
                $request->nik;

            $data->no_hp =
                $request->no_hp;

            $data->alamat =
                $request->alamat;

            $data->pekerjaan =
                $request->pekerjaan;

            $data->jumlah_penghasilan =
                $request->jumlah_penghasilan;

            $data->jumlah_tanggungan =
                $request->jumlah_tanggungan;

            $data->tujuan_pengajuan =
                $request->tujuan_pengajuan;

            $data->dokumen_scan =
                $path;

            // RESET STATUS
            $data->status =
                'proses';

            $data->alasan_tolak =
                null;

            $data->keterangan_admin =
                null;

            // UPDATE TANGGAL
            $data->tanggal_pengajuan =
                now();

            $data->save();

            return response()->json([

                'success' => true,

                'message' =>
                    'Data berhasil diperbarui',

                'data' => $data
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