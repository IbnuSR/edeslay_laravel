<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanKematian;

class PengajuanKematianApiController extends Controller
{

    // ================= STORE =================
    public function store(Request $request)
    {
        try {

            $request->validate([

                'user_id' =>
                    'required',

                'nama_pelapor' =>
                    'required',

                'nik_pelapor' =>
                    'required',

                'no_hp' =>
                    'required',

                'alamat' =>
                    'required',

                'tanggal_pengajuan' =>
                    'required',

                'nama_almarhum' =>
                    'required',

                'nik_almarhum' =>
                    'required',

                'tempat_kematian' =>
                    'required',

                'tanggal_kematian' =>
                    'required|date',

                'sebab_kematian' =>
                    'required',

                'hubungan_pelapor' =>
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
                    $request->file(
                        'dokumen_scan'
                    );

                $filename =
                    time() .
                    '_kematian.' .
                    $file->getClientOriginalExtension();

                if (
                    !file_exists(
                        public_path(
                            'storage/kematian'
                        )
                    )
                ) {

                    mkdir(
                        public_path(
                            'storage/kematian'
                        ),
                        0777,
                        true
                    );
                }

                $file->move(
                    public_path(
                        'storage/kematian'
                    ),
                    $filename
                );

                $path =
                    'storage/kematian/' .
                    $filename;
            }

            // ================= SAVE =================
            $data =
                new PengajuanKematian();

            $data->user_id =
                $request->user_id;

            $data->nama_pelapor =
                $request->nama_pelapor;

            $data->nik_pelapor =
                $request->nik_pelapor;

            $data->no_hp =
                $request->no_hp;

            $data->alamat =
                $request->alamat;

            $data->tanggal_pengajuan =
                $request->tanggal_pengajuan;

            $data->nama_almarhum =
                $request->nama_almarhum;

            $data->nik_almarhum =
                $request->nik_almarhum;

            $data->tempat_kematian =
                $request->tempat_kematian;

            $data->tanggal_kematian =
                $request->tanggal_kematian;

            $data->sebab_kematian =
                $request->sebab_kematian;

            $data->hubungan_pelapor =
                $request->hubungan_pelapor;

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
            ]);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' =>
                    $e->getMessage(),
            ], 500);
        }
    }

    // ================= RIWAYAT USER =================
    public function riwayat($id)
    {
        $data =
            PengajuanKematian::where(
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
                PengajuanKematian::find($id);

            if (!$data) {

                return response()->json([

                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $path =
                $data->dokumen_scan;

            // ================= UPLOAD =================
            if ($request->hasFile('dokumen_scan')) {

                $file =
                    $request->file(
                        'dokumen_scan'
                    );

                $filename =
                    time() .
                    '_kematian.' .
                    $file->getClientOriginalExtension();

                if (
                    !file_exists(
                        public_path(
                            'storage/kematian'
                        )
                    )
                ) {

                    mkdir(
                        public_path(
                            'storage/kematian'
                        ),
                        0777,
                        true
                    );
                }

                $file->move(
                    public_path(
                        'storage/kematian'
                    ),
                    $filename
                );

                $path =
                    'storage/kematian/' .
                    $filename;
            }

            // ================= UPDATE DATA =================
            $data->nama_pelapor =
                $request->nama_pelapor;

            $data->nik_pelapor =
                $request->nik_pelapor;

            $data->no_hp =
                $request->no_hp;

            $data->alamat =
                $request->alamat;

            $data->nama_almarhum =
                $request->nama_almarhum;

            $data->nik_almarhum =
                $request->nik_almarhum;

            $data->tempat_kematian =
                $request->tempat_kematian;

            $data->tanggal_kematian =
                $request->tanggal_kematian;

            $data->sebab_kematian =
                $request->sebab_kematian;

            $data->hubungan_pelapor =
                $request->hubungan_pelapor;

            $data->dokumen_scan =
                $path;

            // ================= RESET =================
            $data->status =
                'proses';

            $data->alasan_tolak =
                null;

            $data->keterangan_admin =
                null;

            // ================= UPDATE TANGGAL =================
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
                    $e->getMessage(),
            ], 500);
        }
    }
}