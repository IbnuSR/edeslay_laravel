<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanIzin;

class PengajuanIzinApiController extends Controller
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

                'nama_kegiatan' =>
                    'required',

                'lokasi_kegiatan' =>
                    'required',

                'tanggal_kegiatan' =>
                    'required|date',

                'waktu_kegiatan' =>
                    'required',

                'penanggung_jawab' =>
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
                    '_izin.' .
                    $file->getClientOriginalExtension();

                if (
                    !file_exists(
                        public_path(
                            'storage/izin'
                        )
                    )
                ) {

                    mkdir(
                        public_path(
                            'storage/izin'
                        ),
                        0777,
                        true
                    );
                }

                $file->move(
                    public_path(
                        'storage/izin'
                    ),
                    $filename
                );

                $path =
                    'storage/izin/' .
                    $filename;
            }

            // ================= SAVE =================
            $data =
                new PengajuanIzin();

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

            $data->nama_kegiatan =
                $request->nama_kegiatan;

            $data->lokasi_kegiatan =
                $request->lokasi_kegiatan;

            $data->tanggal_kegiatan =
                $request->tanggal_kegiatan;

            $data->waktu_kegiatan =
                $request->waktu_kegiatan;

            $data->penanggung_jawab =
                $request->penanggung_jawab;

            $data->dokumen_scan =
                $path;

            $data->metode_pengambilan =
                $request->metode_pengambilan;

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

    // ================= RIWAYAT =================
    public function riwayat($id)
    {
        $data =
            PengajuanIzin::where(
                'user_id',
                $id
            )
                ->latest()
                ->get();

        return response()->json([

            'success' => true,

            'data' => $data,
        ]);
    }
    // ================= UPDATE =================
    public function update(
        Request $request,
        $id
    ) {
        try {

            $data =
                PengajuanIzin::find($id);

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
                    '_izin.' .
                    $file->getClientOriginalExtension();

                if (
                    !file_exists(
                        public_path(
                            'storage/izin'
                        )
                    )
                ) {

                    mkdir(
                        public_path(
                            'storage/izin'
                        ),
                        0777,
                        true
                    );
                }

                $file->move(
                    public_path(
                        'storage/izin'
                    ),
                    $filename
                );

                $path =
                    'storage/izin/' .
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

            $data->nama_kegiatan =
                $request->nama_kegiatan;

            $data->lokasi_kegiatan =
                $request->lokasi_kegiatan;

            $data->tanggal_kegiatan =
                $request->tanggal_kegiatan;

            $data->waktu_kegiatan =
                $request->waktu_kegiatan;

            $data->penanggung_jawab =
                $request->penanggung_jawab;

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