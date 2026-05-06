<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
                // ✅ LOGIKA PINTAR: Cek apakah foto berupa path file atau base64/BLOB
                if ($item->foto) {
                    // Jika foto mengandung '/' atau '.' dan tidak base64, anggap sebagai path file
                    if ((strpos($item->foto, '/') !== false || strpos($item->foto, '.') !== false) 
                        && !preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $item->foto)) {
                        // ✅ Gunakan Storage::url() untuk file path
                        $item->image_url = Storage::url($item->foto);
                    } 
                    // Jika foto berupa base64 string atau BLOB
                    elseif ($item->foto_type) {
                        if (preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $item->foto)) {
                            $item->image_url = $item->foto_type . ';base64,' . $item->foto;
                        } else {
                            $item->image_url = $item->foto_type . ';base64,' . base64_encode($item->foto);
                        }
                    } else {
                        $item->image_url = 'https://via.placeholder.com/400x300?text=No+Image';
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
                // ✅ LOGIKA PINTAR: Sama seperti kegiatan
                if ($item->foto) {
                    if ((strpos($item->foto, '/') !== false || strpos($item->foto, '.') !== false) 
                        && !preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $item->foto)) {
                        $item->image_url = Storage::url($item->foto);
                    } 
                    elseif ($item->foto_type) {
                        if (preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $item->foto)) {
                            $item->image_url = $item->foto_type . ';base64,' . $item->foto;
                        } else {
                            $item->image_url = $item->foto_type . ';base64,' . base64_encode($item->foto);
                        }
                    } else {
                        $item->image_url = 'https://via.placeholder.com/400x300?text=No+Image';
                    }
                } else {
                    $item->image_url = 'https://via.placeholder.com/400x300?text=No+Image';
                }
                return $item;
            });

        // =====================================================================
        // 3. AMBIL DATA STRUKTUR DESA (TETAP SAMA)
        // =====================================================================
        $strukturDesa = DB::table('struktur_desa')
            ->select('jabatan', 'nama')
            ->orderBy('id', 'asc')
            ->get();

        // =====================================================================
        // 4. INFOGRAFIS (UPDATED: TAMBAH ICON)
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

        // 4b. Susun struktur nested array (DENGAN ICON)
        $infografis = [
    // Dasar - ✅ DENGAN ICON (PAKAI FILE YANG KAMU SEBUTKAN)
    'total_penduduk' => [
        'value' => $getValue('total penduduk', 4456),
        'icon' => asset('assets/icons/penduduk.png'),  // ✅ File: penduduk.png
    ],
    'kepala_keluarga' => [
        'value' => $getValue('kepala keluarga', 1250),
        'icon' => asset('assets/icons/family.png'),    // ✅ File: family.png
    ],
    'laki_laki' => [
        'value' => $getValue('laki-laki', 2200),
        'icon' => asset('assets/icons/male.png'),      // ✅ File: male.png
    ],
    'perempuan' => [
        'value' => $getValue('perempuan', 2256),
        'icon' => asset('assets/icons/female.png'),    // ✅ File: female.png
    ],
    
            
           // ===== PERKAWINAN (✅ DENGAN ICON) =====
'perkawinan' => [
    'belum_kawin' => [
        'value' => $getValue('belum kawin', 1200),
        'icon' => asset('assets/icons/bk.png'),  // ✅ belum kawin
    ],
    'kawin' => [
        'value' => $getValue('kawin', 2800),
        'icon' => asset('assets/icons/k.png'),   // ✅ kawin
    ],
    'cerai_hidup' => [
        'value' => $getValue('cerai hidup', 150),
        'icon' => asset('assets/icons/ch.png'),  // ✅ cerai hidup
    ],
    'cerai_mati' => [
        'value' => $getValue('cerai mati', 200),
        'icon' => asset('assets/icons/cm.png'),  // ✅ cerai mati
    ],
    'kawin_tercatat' => [
        'value' => $getValue('kawin tercatat', 2500),
        'icon' => asset('assets/icons/kt.png'),  // ✅ kawin tercatat
    ],
    'kawin_tidak_tercatat' => [
        'value' => $getValue('kawin tidak tercatat', 300),
        'icon' => asset('assets/icons/ktt.png'), // ✅ kawin tidak tercatat
    ],
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
            
            // ===== PEKERJAAN (✅ DENGAN ICON) =====
'pekerjaan' => [
    'belum_tidak_bekerja' => [
        'value' => $getValue('tidak bekerja', 1850),
        'icon' => asset('assets/icons/bb.png'), // bb = Belum Bekerja
    ],
    'pelajar_mahasiswa' => [
        'value' => $getValue('pelajar', 680),
        'icon' => asset('assets/icons/m.png'),  // m = Mahasiswa/Pelajar
    ],
    'pegawai_negeri' => [
        'value' => $getValue('pegawai negeri', 320),
        'icon' => asset('assets/icons/pn.png'), // pn = Pegawai Negeri
    ],
    'karyawan_swasta' => [
        'value' => $getValue('karyawan swasta', 550),
        'icon' => asset('assets/icons/ps.png'), // ps = Pegawai Swasta
    ],
    'petani_pekebun' => [
        'value' => $getValue('petani', 420),
        'icon' => asset('assets/icons/p.png'),  // p = Petani
    ],
    'pedagang' => [
        'value' => $getValue('pedagang', 280),
        'icon' => asset('assets/icons/D.png'),  // D = Dagang
    ],
],
        ];

        // =====================================================================
        // 5. RETURN VIEW
        // =====================================================================
        return view('dashboard_umum', compact(
            'kegiatanList',
            'prestasiList',
            'strukturDesa',
            'infografis'
        ));
    }
}