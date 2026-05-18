<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanNikah;

class PengajuanNikahApiController extends Controller
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
                    'required',

                'no_hp' =>
                    'required',

                'alamat' =>
                    'required',

                'tanggal_pengajuan' =>
                    'required',

                'nama_suami' =>
                    'required',

                'nama_istri' =>
                    'required',

                'nik_suami' =>
                    'required',

                'nik_istri' =>
                    'required',

                'alamat_masing2' =>
                    'required',

                'tanggal_rencana' =>
                    'required',

                'lokasi_nikah' =>
                    'required',

                'nama_pj' =>
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
                    time() .
                    '_nikah.' .
                    $file->getClientOriginalExtension();

                if (
                    !file_exists(
                        public_path(
                            'storage/nikah'
                        )
                    )
                ) {

                    mkdir(
                        public_path(
                            'storage/nikah'
                        ),
                        0777,
                        true
                    );
                }

                $file->move(
                    public_path(
                        'storage/nikah'
                    ),
                    $filename
                );

                $path =
                    'storage/nikah/' .
                    $filename;
            }

            // ================= SIMPAN =================
            PengajuanNikah::create([

                'user_id' =>
                    $request->user_id,

                'nama_lengkap' =>
                    $request->nama_lengkap,

                'nik' =>
                    $request->nik,

                'no_hp' =>
                    $request->no_hp,

                'alamat' =>
                    $request->alamat,

                'tanggal_pengajuan' =>
                    $request->tanggal_pengajuan,

                'nama_suami' =>
                    $request->nama_suami,

                'nama_istri' =>
                    $request->nama_istri,

                'nik_suami' =>
                    $request->nik_suami,

                'nik_istri' =>
                    $request->nik_istri,

                'alamat_masing2' =>
                    $request->alamat_masing2,

                'tanggal_rencana' =>
                    $request->tanggal_rencana,

                'lokasi_nikah' =>
                    $request->lokasi_nikah,

                'nama_pj' =>
                    $request->nama_pj,

                'dokumen_scan' =>
                    $path,

                'metode_pengambilan' =>
                    $request->metode_pengambilan,

                'status' =>
                    'proses',
            ]);

            return response()->json([

                'success' => true,

                'message' =>
                    'Pengajuan nikah berhasil dikirim',
            ]);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' =>
                    $e->getMessage()
            ], 500);
        }
    }

    // ================= RIWAYAT =================
    public function riwayat($id)
    {
        $data =
            PengajuanNikah::where(
                'user_id',
                $id
            )->latest()->get();

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
                PengajuanNikah::find($id);

            if (!$data) {

                return response()->json([

                    'success' => false,

                    'message' =>
                        'Data tidak ditemukan'
                ]);
            }

            $path =
                $data->dokumen_scan;

            // ================= UPLOAD =================
            if ($request->hasFile('dokumen_scan')) {

                $file =
                    $request->file('dokumen_scan');

                $filename =
                    time() .
                    '_nikah.' .
                    $file->getClientOriginalExtension();

                if (
                    !file_exists(
                        public_path(
                            'storage/nikah'
                        )
                    )
                ) {

                    mkdir(
                        public_path(
                            'storage/nikah'
                        ),
                        0777,
                        true
                    );
                }

                $file->move(
                    public_path(
                        'storage/nikah'
                    ),
                    $filename
                );

                $path =
                    'storage/nikah/' .
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

            $data->nama_suami =
                $request->nama_suami;

            $data->nama_istri =
                $request->nama_istri;

            $data->nik_suami =
                $request->nik_suami;

            $data->nik_istri =
                $request->nik_istri;

            $data->alamat_masing2 =
                $request->alamat_masing2;

            $data->tanggal_rencana =
                $request->tanggal_rencana;

            $data->lokasi_nikah =
                $request->lokasi_nikah;

            $data->nama_pj =
                $request->nama_pj;

            $data->dokumen_scan =
                $path;

            // ================= RESET =================
            $data->status =
                'proses';

            $data->alasan_tolak =
                null;

            $data->keterangan_admin =
                null;

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