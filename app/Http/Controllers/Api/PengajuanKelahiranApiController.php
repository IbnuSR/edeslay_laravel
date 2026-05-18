<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanKelahiran;

class PengajuanKelahiranApiController extends Controller
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

                'nama_bayi' =>
                    'required',

                'tempat_lahir_bayi' =>
                    'required',

                'tanggal_lahir_bayi' =>
                    'required',

                'jenis_kelamin_bayi' =>
                    'required',

                'waktu_lahir' =>
                    'required',

                'nama_ayah' =>
                    'required',

                'nama_ibu' =>
                    'required',

                'nik_ayah' =>
                    'required|digits:16',

                'nik_ibu' =>
                    'required|digits:16',

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
                    '_kelahiran_' .
                    $file->getClientOriginalName();

                if (
                    !file_exists(
                        public_path(
                            'storage/kelahiran'
                        )
                    )
                ) {

                    mkdir(
                        public_path(
                            'storage/kelahiran'
                        ),
                        0777,
                        true
                    );
                }

                $file->move(
                    public_path(
                        'storage/kelahiran'
                    ),
                    $filename
                );

                $path =
                    'storage/kelahiran/' .
                    $filename;
            }

            // ================= SAVE =================
            $data =
                new PengajuanKelahiran();

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

            $data->nama_bayi =
                $request->nama_bayi;

            $data->tempat_lahir_bayi =
                $request->tempat_lahir_bayi;

            $data->tanggal_lahir_bayi =
                $request->tanggal_lahir_bayi;

            $data->jenis_kelamin_bayi =
                $request->jenis_kelamin_bayi;

            $data->waktu_lahir =
                $request->waktu_lahir;

            $data->nama_ayah =
                $request->nama_ayah;

            $data->nama_ibu =
                $request->nama_ibu;

            $data->nik_ayah =
                $request->nik_ayah;

            $data->nik_ibu =
                $request->nik_ibu;

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
                    'Pengajuan kelahiran berhasil',

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

    // ================= RIWAYAT USER =================
    public function riwayat($id)
    {
        $data =
            PengajuanKelahiran::where(
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
                PengajuanKelahiran::findOrFail($id);

            $path =
                $data->dokumen_scan;

            // ================= UPLOAD FILE =================
            if ($request->hasFile('dokumen_scan')) {

                $file =
                    $request->file('dokumen_scan');

                $filename =
                    time() .
                    '_kelahiran.' .
                    $file->getClientOriginalExtension();

                $tujuan =
                    public_path(
                        'storage/kelahiran'
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
                    'storage/kelahiran/' .
                    $filename;
            }

            // ================= UPDATE =================
            $data->update([

                'nama_lengkap' =>
                    $request->nama_lengkap,

                'nik' =>
                    $request->nik,

                'no_hp' =>
                    $request->no_hp,

                'alamat' =>
                    $request->alamat,

                'nama_bayi' =>
                    $request->nama_bayi,

                'tempat_lahir_bayi' =>
                    $request->tempat_lahir_bayi,

                'tanggal_lahir_bayi' =>
                    $request->tanggal_lahir_bayi,

                'jenis_kelamin_bayi' =>
                    $request->jenis_kelamin_bayi,

                'waktu_lahir' =>
                    $request->waktu_lahir,

                'nama_ayah' =>
                    $request->nama_ayah,

                'nama_ibu' =>
                    $request->nama_ibu,

                'nik_ayah' =>
                    $request->nik_ayah,

                'nik_ibu' =>
                    $request->nik_ibu,

                'dokumen_scan' =>
                    $path,

                'status' =>
                    'proses',

                'tanggal_pengajuan' =>
                    now(),

                'updated_at' =>
                    now(),
            ]);

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