<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Saran;
use App\Models\User;

class SaranController extends Controller
{
    // ================= GET SEMUA SARAN USER =================
    public function getSaranUser($email)
    {
        $saran = Saran::where('email', $email)
            ->latest()
            ->get();

        foreach ($saran as $item) {

            if ($item->foto_sampul) {

                $item->foto_url =
                    url('storage/' . $item->foto_sampul);

            } else {

                $item->foto_url = null;
            }
        }

        return response()->json([
            'success' => true,
            'data' => $saran
        ]);
    }

    // ================= TAMBAH SARAN =================
    public function tambahSaran(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'judul' => 'required',
            'isi_saran' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        $fotoPath = null;
        $fotoType = null;

        // ================= FOTO =================
        if ($request->hasFile('foto')) {

            $file = $request->file('foto');

            $fotoPath = $file->store(
                'saran',
                'public'
            );

            $fotoType = $file->getClientOriginalExtension();
        }

        // ================= INSERT =================
        $saran = Saran::create([
            'nama' => $user->nama_lengkap,
            'judul' => $request->judul,
            'email' => $user->email,
            'pesan' => $request->isi_saran,
            'isi_saran' => $request->isi_saran,
            'tanggal_dikirim' => now(),
            'foto_sampul' => $fotoPath,
            'foto_type' => $fotoType,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Saran berhasil dikirim',
            'data' => $saran
        ]);
    }

    // ================= DETAIL SARAN =================
    public function detailSaran($id)
    {
        $saran = Saran::find($id);

        if (!$saran) {

            return response()->json([
                'success' => false,
                'message' => 'Saran tidak ditemukan'
            ]);
        }

        if ($saran->foto_sampul) {

            $saran->foto_url =
                url('storage/' . $saran->foto_sampul);

        } else {

            $saran->foto_url = null;
        }

        return response()->json([
            'success' => true,
            'data' => $saran
        ]);
    }

    // ================= EDIT SARAN =================
    public function updateSaran(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'judul' => 'required',
            'isi_saran' => 'required',
        ]);

        $saran = Saran::find($request->id);

        if (!$saran) {

            return response()->json([
                'success' => false,
                'message' => 'Saran tidak ditemukan'
            ]);
        }

        $fotoPath = $saran->foto_sampul;
        $fotoType = $saran->foto_type;

        // ================= UPDATE FOTO =================
        if ($request->hasFile('foto')) {

            $file = $request->file('foto');

            $fotoPath = $file->store(
                'saran',
                'public'
            );

            $fotoType = $file->getClientOriginalExtension();
        }

        $saran->update([
            'judul' => $request->judul,
            'pesan' => $request->isi_saran,
            'isi_saran' => $request->isi_saran,
            'foto_sampul' => $fotoPath,
            'foto_type' => $fotoType,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Saran berhasil diperbarui'
        ]);
    }

    // ================= HAPUS =================
    public function deleteSaran($id)
    {
        $saran = Saran::find($id);

        if (!$saran) {

            return response()->json([
                'success' => false,
                'message' => 'Saran tidak ditemukan'
            ]);
        }

        $saran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Saran berhasil dihapus'
        ]);
    }
}