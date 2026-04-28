<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardUmumController extends Controller
{
    public function __invoke()
    {
        // 1. Ambil data kegiatan (limit 6 untuk slider)
        $kegiatanList = DB::table('kegiatan')
            ->select('id', 'judul', 'deskripsi', 'tanggal', 'foto', 'foto_type')
            ->orderBy('tanggal', 'desc')
            ->limit(6)
            ->get()
            ->map(function($item) {
                if ($item->foto && $item->foto_type) {
                    if (preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $item->foto)) {
                        $item->image_url = '' . $item->foto_type . ';base64,' . $item->foto;
                    } else {
                        $item->image_url = '' . $item->foto_type . ';base64,' . base64_encode($item->foto);
                    }
                } else {
                    $item->image_url = 'https://via.placeholder.com/400x300?text=No+Image';
                }
                return $item;
            });

        // 2. Ambil data prestasi (limit 6 untuk slider)
        $prestasiList = DB::table('prestasi')
            ->select('id', 'judul', 'deskripsi', 'tanggal', 'foto', 'foto_type')
            ->orderBy('tanggal', 'desc')
            ->limit(6)
            ->get()
            ->map(function($item) {
                if ($item->foto && $item->foto_type) {
                    if (preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $item->foto)) {
                        $item->image_url = '' . $item->foto_type . ';base64,' . $item->foto;
                    } else {
                        $item->image_url = '' . $item->foto_type . ';base64,' . base64_encode($item->foto);
                    }
                } else {
                    $item->image_url = 'https://via.placeholder.com/400x300?text=No+Image';
                }
                return $item;
            });

        // 3. Ambil data struktur desa
        $strukturDesa = DB::table('struktur_desa')
            ->select('jabatan', 'nama')
            ->orderBy('id', 'asc')
            ->get();

        // 4. Statistik Dasar
        $totalPenduduk = 4456;
        $totalKepalaKeluarga = 1250;
        $totalLakiLaki = 2200;
        $totalPerempuan = 2256;

        // 5. Data Infografis Lengkap
        $infografis = [
            'total_penduduk' => $totalPenduduk,
            'kepala_keluarga' => $totalKepalaKeluarga,
            'laki_laki' => $totalLakiLaki,
            'perempuan' => $totalPerempuan,
            'perkawinan' => [
                'belum_kawin' => 1200,
                'kawin' => 2800,
                'cerai_hidup' => 150,
                'cerai_mati' => 200,
                'kawin_tercatat' => 2500,
                'kawin_tidak_tercatat' => 300,
            ],
            'kelompok_umur' => [
                '0-4' => ['laki' => 122, 'perempuan' => 111],
                '5-9' => ['laki' => 181, 'perempuan' => 211],
                '10-14' => ['laki' => 225, 'perempuan' => 205],
                '15-19' => ['laki' => 217, 'perempuan' => 204],
                '20-24' => ['laki' => 180, 'perempuan' => 191],
                '25-29' => ['laki' => 174, 'perempuan' => 172],
                '30-34' => ['laki' => 156, 'perempuan' => 164],
                '35-39' => ['laki' => 167, 'perempuan' => 161],
                '40-44' => ['laki' => 173, 'perempuan' => 177],
                '45-49' => ['laki' => 140, 'perempuan' => 147],
                '50-54' => ['laki' => 123, 'perempuan' => 105],
                '55-59' => ['laki' => 81, 'perempuan' => 99],
                '60-64' => ['laki' => 80, 'perempuan' => 61],
                '65-69' => ['laki' => 56, 'perempuan' => 57],
                '70-74' => ['laki' => 31, 'perempuan' => 30],
                '75-79' => ['laki' => 30, 'perempuan' => 52],
                '80-84' => ['laki' => 26, 'perempuan' => 0],
                '85+' => ['laki' => 0, 'perempuan' => 0],
            ],
            'pendidikan' => [
                'tidak_belum_sekolah' => 931,
                'belum_tamat_sd' => 249,
                'tamat_sd' => 1533,
                'sltp_sederajat' => 708,
                'slta_sederajat' => 674,
                'diploma_i_ii' => 16,
                'diploma_iii_sarjana_muda' => 32,
                'diploma_iv_strata_i' => 302,
                'strata_ii' => 11,
                'strata_iii' => 0,
            ],
            'pekerjaan' => [
                'belum_tidak_bekerja' => 1850,
                'pelajar_mahasiswa' => 680,
                'pegawai_negeri' => 320,
                'karyawan_swasta' => 550,
                'petani_pekebun' => 420,
                'pedagang' => 280,
                'lainnya' => 356,
            ]
        ];

        return view('dashboard_umum', compact(
            'kegiatanList',
            'prestasiList',
            'strukturDesa',
            'infografis'
        ));
    }
}