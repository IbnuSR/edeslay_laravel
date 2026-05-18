<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanKtp;

class PengajuanKtpApiController extends Controller
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

                'jenis_permohonan' =>
                    'required',

                'alasan_permohonan' =>
                    'required',

                'metode_pengambilan' =>
                    'required',

                'dokumen_scan' =>
                    'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $path = null;

            // ================= UPLOAD FILE =================
            if ($request->hasFile('dokumen_scan')) {

                $file =
                    $request->file('dokumen_scan');

                $filename =
                    time() .
                    '_ktp.' .
                    $file->getClientOriginalExtension();

                $tujuan =
                    public_path(
                        'storage/ktp'
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
                    'storage/ktp/' .
                    $filename;
            }

            // ================= SIMPAN =================
            $data =
                new PengajuanKtp();

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

            $data->jenis_permohonan =
                $request->jenis_permohonan;

            $data->alasan_permohonan =
                $request->alasan_permohonan;

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
                    'Pengajuan KTP berhasil',

                'data' => $data
            ]);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' =>
                    $e->getMessage(),

                'line' =>
                    $e->getLine(),

                'file' =>
                    $e->getFile(),
            ], 500);
        }
    }

    // ================= GET BY USER =================
    public function getByUser($userId)
    {
        $data =
            PengajuanKtp::where(
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

    // ================= DETAIL =================
    public function detail($id)
    {
        $data =
            PengajuanKtp::find($id);

        return response()->json([

            'success' => true,

            'data' => $data
        ]);
    }
    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        try {

            $data =
                PengajuanKtp::find($id);

            if (!$data) {

                return response()->json([

                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $path =
                $data->dokumen_scan;

            // ================= UPLOAD FILE =================
            if ($request->hasFile('dokumen_scan')) {

                $file =
                    $request->file('dokumen_scan');

                $filename =
                    time() .
                    '_ktp.' .
                    $file->getClientOriginalExtension();

                $tujuan =
                    public_path(
                        'storage/ktp'
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
                    'storage/ktp/' .
                    $filename;
            }

            // ================= UPDATE DATA =================
            $data->nama_lengkap =
                $request->nama_lengkap;

            $data->nik =
                $request->nik;

            $data->no_hp =
                $request->no_hp;

            $data->alamat =
                $request->alamat;

            $data->jenis_permohonan =
                $request->jenis_permohonan;

            $data->alasan_permohonan =
                $request->alasan_permohonan;

            $data->metode_pengambilan =
                $request->metode_pengambilan;

            $data->dokumen_scan =
                $path;

            // ================= RESET =================
            $data->status =
                'proses';

            $data->keterangan_admin =
                null;

            $data->tanggal_pengajuan =
                now();

            $data->save();

            return response()->json([

                'success' => true,

                'message' =>
                    'Pengajuan berhasil diperbarui',

                'data' => $data
            ]);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' =>
                    $e->getMessage(),

                'line' =>
                    $e->getLine(),
            ], 500);
        }
    }
}