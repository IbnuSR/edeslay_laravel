<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Infografis;

class DashboardUmumController extends Controller
{
    public function __invoke()
    {
        // =====================================================================
        // 1. AMBIL DATA KEGIATAN (Limit 6 untuk slider)
        // =====================================================================
        $kegiatanList = DB::table('kegiatan')
            ->select('id', 'judul', 'deskripsi', 'tanggal', 'foto', 'foto_type')
            ->orderBy('tanggal', 'desc')
            ->limit(6)
            ->get()
            ->map(function ($item) {
                if ($item->foto && $item->foto_type) {
                    if (preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $item->foto)) {
                        $item->image_url = $item->foto_type . ';base64,' . $item->foto;
                    } else {
                        $item->image_url = $item->foto_type . ';base64,' . base64_encode($item->foto);
                    }
                } else {
                    $item->image_url = 'https://via.placeholder.com/400x300?text=No+Image';
                }
                return $item;
            });

        // =====================================================================
        // 2. AMBIL DATA PRESTASI (Limit 6 untuk slider)
        // =====================================================================
        $prestasiList = DB::table('prestasi')
            ->select('id', 'judul', 'deskripsi', 'tanggal', 'foto', 'foto_type')
            ->orderBy('tanggal', 'desc')
            ->limit(6)
            ->get()
            ->map(function ($item) {
                if ($item->foto && $item->foto_type) {
                    if (preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $item->foto)) {
                        $item->image_url = $item->foto_type . ';base64,' . $item->foto;
                    } else {
                        $item->image_url = $item->foto_type . ';base64,' . base64_encode($item->foto);
                    }
                } else {
                    $item->image_url = 'https://via.placeholder.com/400x300?text=No+Image';
                }
                return $item;
            });

        // =====================================================================
        // 3. AMBIL DATA STRUKTUR DESA
        // =====================================================================
        $strukturDesa = DB::table('struktur_desa')
            ->select('jabatan', 'nama')
            ->orderBy('id', 'asc')
            ->get();

        // =====================================================================
        // 4. 🔄 AMBIL DATA INFOGRAFIS (HYBRID: DB + HARDCODE FALLBACK)
        // =====================================================================
        
        // 4a. Ambil semua data dari tabel infografis
        $dbInfografis = Infografis::pluck('deskripsi', 'judul')->toArray();
        
        // Helper function: ambil nilai dari DB atau pakai default
        $getValue = function($key, $default) use ($dbInfografis) {
            // Cari di database dengan berbagai variasi judul
            foreach ($dbInfografis as $judul => $nilai) {
                if (stripos($judul, $key) !== false) {
                    // Extract angka dari deskripsi jika ada
                    if (preg_match('/[\d\.]+/', $nilai, $matches)) {
                        return (int) str_replace('.', '', $matches[0]);
                    }
                    return $default;
                }
            }
            return $default;
        };

        // 4b. Susun struktur nested array (sesuai view lama)
        $infografis = [
            // Dasar
            'total_penduduk' => $getValue('total penduduk', 4456),
            'kepala_keluarga' => $getValue('kepala keluarga', 1250),
            'laki_laki' => $getValue('laki-laki', 2200),
            'perempuan' => $getValue('perempuan', 2256),
            
            // Perkawinan
            'perkawinan' => [
                'belum_kawin' => $getValue('belum kawin', 1200),
                'kawin' => $getValue('kawin', 2800),
                'cerai_hidup' => $getValue('cerai hidup', 150),
                'cerai_mati' => $getValue('cerai mati', 200),
                'kawin_tercatat' => $getValue('kawin tercatat', 2500),
                'kawin_tidak_tercatat' => $getValue('kawin tidak tercatat', 300),
            ],
            
            // Kelompok Umur (Pyramid) - Hardcode dulu, nanti bisa dikembangkan
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
            
            // Pendidikan
            'pendidikan' => [
                'tidak_belum_sekolah' => $getValue('tidak sekolah', 931),
                'belum_tamat_sd' => $getValue('belum tamat sd', 249),
                'tamat_sd' => $getValue('tamat sd', 1533),
                'sltp_sederajat' => $getValue('sltp', 708),
                'slta_sederajat' => $getValue('slta', 674),
                'diploma_i_ii' => $getValue('diploma 1', 16),
                'diploma_iii_sarjana_muda' => $getValue('diploma 3', 32),
                'diploma_iv_strata_i' => $getValue('sarjana', 302),
                'strata_ii' => $getValue('s2', 11),
                'strata_iii' => $getValue('s3', 0),
            ],
            
            // Pekerjaan
            'pekerjaan' => [
                'belum_tidak_bekerja' => $getValue('tidak bekerja', 1850),
                'pelajar_mahasiswa' => $getValue('pelajar', 680),
                'pegawai_negeri' => $getValue('pegawai negeri', 320),
                'karyawan_swasta' => $getValue('karyawan swasta', 550),
                'petani_pekebun' => $getValue('petani', 420),
                'pedagang' => $getValue('pedagang', 280),
                'lainnya' => $getValue('lainnya', 356),
            ]
        ];

        // =====================================================================
        // 5. RETURN VIEW
        // =====================================================================
        return view('dashboard_umum', compact(
            'kegiatanList',
            'prestasiList',
            'strukturDesa',
            'infografis'  // ← Struktur nested array (compatible dengan view lama!)
        ));
    }
}