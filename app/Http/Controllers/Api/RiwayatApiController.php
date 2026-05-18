<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Domisili;
use App\Models\Sktm;
use App\Models\PengajuanKtp;
use App\Models\PengajuanKelahiran;
use App\Models\PengajuanPenghasilan;
use App\Models\PengajuanKematian;
use App\Models\PengajuanIzin;
use App\Models\PengajuanNikah;
use App\Models\PengajuanDomisili;
use App\Models\PengajuanSurat;


class RiwayatApiController extends Controller
{
    // ================= RIWAYAT =================
    public function index($userId)
    {
        $semua = [];

        // ================= DOMISILI =================
        $domisili = Domisili::where(
            'user_id',
            $userId
        )->latest()->get();

        foreach ($domisili as $item) {

            $semua[] = [

                'id' => $item->id,
                'jenis' => 'Surat Domisili',
                'tanggal' => $item->tanggal_pengajuan,
                'status' => $item->status,
                'alasan' => $item->keterangan_admin ?? '',
                'warna' => '#4CAF50',
                'icon' => 'home',
            ];
        }

        // ================= SKTM =================
        $sktm = Sktm::where(
            'user_id',
            $userId
        )->latest()->get();

        foreach ($sktm as $item) {

            $semua[] = [

                'id' => $item->id,
                'jenis' =>
                    'Surat Keterangan Tidak Mampu',

                'tanggal' =>
                    $item->tanggal_pengajuan,

                'status' =>
                    $item->status,

                'alasan' =>
                    $item->keterangan_admin ?? '',

                'warna' => '#7E57C2',
                'icon' => 'description',
            ];
        }

        // ================= KTP =================
        $ktp = PengajuanKtp::where(
            'user_id',
            $userId
        )->latest()->get();

        foreach ($ktp as $item) {

            $semua[] = [

                'id' => $item->id,
                'jenis' => 'Pengantar KTP',
                'tanggal' => $item->tanggal_pengajuan,
                'status' => $item->status,
                'alasan' => $item->keterangan_admin ?? '',
                'warna' => '#2979FF',
                'icon' => 'badge',
            ];
        }

        // ================= KELAHIRAN =================
        $kelahiran =
            PengajuanKelahiran::where(
                'user_id',
                $userId
            )->latest()->get();

        foreach ($kelahiran as $item) {

            $semua[] = [

                'id' => $item->id,
                'jenis' => 'Surat Kelahiran',
                'tanggal' => $item->tanggal_pengajuan,
                'status' => $item->status,
                'alasan' => $item->keterangan_admin ?? '',
                'warna' => '#FF5C8D',
                'icon' => 'child',
            ];
        }

        // ================= PENGHASILAN =================
        $penghasilan =
            PengajuanPenghasilan::where(
                'user_id',
                $userId
            )->latest()->get();

        foreach ($penghasilan as $item) {

            $semua[] = [

                'id' => $item->id,
                'jenis' => 'Surat Penghasilan',
                'tanggal' => $item->tanggal_pengajuan,
                'status' => $item->status,
                'alasan' => $item->keterangan_admin ?? '',
                'warna' => '#00ACC1',
                'icon' => 'money',
            ];
        }

        // ================= KEMATIAN =================
        $kematian =
            PengajuanKematian::where(
                'user_id',
                $userId
            )->latest()->get();

        foreach ($kematian as $item) {

            $semua[] = [

                'id' => $item->id,
                'jenis' => 'Surat Kematian',
                'tanggal' => $item->tanggal_pengajuan,
                'status' => $item->status,
                'alasan' => $item->keterangan_admin ?? '',
                'warna' => '#EF5350',
                'icon' => 'favorite',
            ];
        }

        // ================= IZIN =================
        $izin = PengajuanIzin::where(
            'user_id',
            $userId
        )->latest()->get();

        foreach ($izin as $item) {

            $semua[] = [

                'id' => $item->id,
                'jenis' => 'Surat Izin',
                'tanggal' => $item->tanggal_pengajuan,
                'status' => $item->status,
                'alasan' => $item->keterangan_admin ?? '',
                'warna' => '#FFA726',
                'icon' => 'event',
            ];
        }

        // ================= NIKAH =================
        $nikah = PengajuanNikah::where(
            'user_id',
            $userId
        )->latest()->get();

        foreach ($nikah as $item) {

            $semua[] = [

                'id' => $item->id,
                'jenis' => 'Surat Nikah',
                'tanggal' => $item->tanggal_pengajuan,
                'status' => $item->status,
                'alasan' => $item->keterangan_admin ?? '',
                'warna' => '#EC407A',
                'icon' => 'love',
            ];
        }

        // ================= SORT =================
        usort($semua, function ($a, $b) {

            return strtotime(
                $b['tanggal']
            ) - strtotime(
                $a['tanggal']
            );
        });

        return response()->json([

            'success' => true,
            'data' => $semua
        ]);
    }

    // ================= DELETE =================
    public function delete($jenis, $id)
    {
        switch ($jenis) {

            case 'domisili':
                Domisili::find($id)?->delete();
                break;

            case 'sktm':
                Sktm::find($id)?->delete();
                break;

            case 'ktp':
                PengajuanKtp::find($id)?->delete();
                break;

            case 'kelahiran':
                PengajuanKelahiran::find($id)?->delete();
                break;

            case 'penghasilan':
                PengajuanPenghasilan::find($id)?->delete();
                break;

            case 'kematian':
                PengajuanKematian::find($id)?->delete();
                break;

            case 'izin':
                PengajuanIzin::find($id)?->delete();
                break;

            case 'nikah':
                PengajuanNikah::find($id)?->delete();
                break;
        }

        return response()->json([

            'success' => true,
            'message' => 'Riwayat berhasil dihapus'
        ]);
    }
    // ================= DETAIL =================
    public function detail($jenis, $id)
    {
        switch ($jenis) {

            case 'domisili':
                $data = Domisili::find($id);
                break;

            case 'sktm':
                $data = Sktm::find($id);
                break;

            case 'ktp':
                $data = PengajuanKtp::find($id);
                break;

            case 'kelahiran':
                $data = PengajuanKelahiran::find($id);
                break;

            case 'penghasilan':
                $data = PengajuanPenghasilan::find($id);
                break;

            case 'kematian':
                $data = PengajuanKematian::find($id);
                break;

            case 'izin':
                $data = PengajuanIzin::find($id);
                break;

            case 'nikah':
                $data = PengajuanNikah::find($id);
                break;

            default:

                return response()->json([
                    'success' => false,
                    'message' => 'Jenis tidak ditemukan'
                ]);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}