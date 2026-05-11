<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use App\Models\Infografis;
use App\Models\Penduduk; // ← TAMBAHKAN INI

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
        // 2. AMBIL DATA PRESTASI (Limit 6 untuk slider)
        // =====================================================================
        $prestasiList = DB::table('prestasi')
            ->select('id', 'judul', 'deskripsi', 'tanggal', 'foto', 'foto_type')
            ->orderBy('tanggal', 'desc')
            ->limit(6)
            ->get()
            ->map(function ($item) {
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
        // 3. AMBIL DATA STRUKTUR DESA
        // =====================================================================
        $strukturDesa = DB::table('struktur_desa')
            ->select('jabatan', 'nama')
            ->orderBy('id', 'asc')
            ->get();

        // =====================================================================
        // 4. INFOGRAFIS - INTEGRASI DATA PENDUDUK + FALLBACK
        // =====================================================================
        
        // 4a. Cek apakah tabel penduduk ada dan ada datanya
        $usePendudukData = false;
        $pendudukStats = null;
        
        try {
            // Cek apakah tabel penduduk ada
            if (Schema::hasTable('penduduk') && Penduduk::tetap()->exists()) {
                $usePendudukData = true;
                
                // Ambil statistik dari model Penduduk
                $query = Penduduk::tetap();
                
                $pendudukStats = [
                    'total_penduduk' => $query->count(),
                    'kepala_keluarga' => $query->select('rt', 'rw')->distinct()->count(),
                    'laki_laki' => (clone $query)->where('jenis_kelamin', 'L')->count(),
                    'perempuan' => (clone $query)->where('jenis_kelamin', 'P')->count(),
                    
                    // Status Perkawinan
                    'perkawinan' => [
                        'belum_kawin' => (clone $query)->where('status_perkawinan', 'Belum Kawin')->count(),
                        'kawin' => (clone $query)->where('status_perkawinan', 'Kawin')->count(),
                        'cerai_hidup' => (clone $query)->where('status_perkawinan', 'Cerai Hidup')->count(),
                        'cerai_mati' => (clone $query)->where('status_perkawinan', 'Cerai Mati')->count(),
                    ],
                    
                    // Pendidikan
                    'pendidikan' => $query->selectRaw('pendidikan_terakhir, COUNT(*) as total')
                        ->groupBy('pendidikan_terakhir')
                        ->pluck('total', 'pendidikan_terakhir'),
                    
                    // Pekerjaan (Top 10)
                    'pekerjaan' => $query->selectRaw('pekerjaan, COUNT(*) as total')
                        ->whereNotNull('pekerjaan')
                        ->where('pekerjaan', '!=', '')
                        ->groupBy('pekerjaan')
                        ->orderByDesc('total')
                        ->limit(10)
                        ->pluck('total', 'pekerjaan'),
                    
                    // Kelompok Umur
                    'kelompok_umur_raw' => $query->selectRaw('
                        CASE 
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 4 THEN "0-4"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 5 AND 9 THEN "5-9"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 10 AND 14 THEN "10-14"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 15 AND 19 THEN "15-19"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 20 AND 24 THEN "20-24"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 25 AND 29 THEN "25-29"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 30 AND 34 THEN "30-34"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 35 AND 39 THEN "35-39"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 40 AND 44 THEN "40-44"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 45 AND 49 THEN "45-49"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 50 AND 54 THEN "50-54"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 55 AND 59 THEN "55-59"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 60 AND 64 THEN "60-64"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 65 AND 69 THEN "65-69"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 70 AND 74 THEN "70-74"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 75 AND 79 THEN "75-79"
                            WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 80 AND 84 THEN "80-84"
                            ELSE "85+"
                        END as age_group,
                        SUM(CASE WHEN jenis_kelamin = "L" THEN 1 ELSE 0 END) as laki,
                        SUM(CASE WHEN jenis_kelamin = "P" THEN 1 ELSE 0 END) as perempuan
                    ')
                    ->groupBy('age_group')
                    ->pluck('laki', 'perempuan', 'age_group'),
                ];
            }
        } catch (\Exception $e) {
            // Jika error, fallback ke mode lama
            $usePendudukData = false;
        }

        // Helper: ambil dari penduduk atau fallback ke infografis table atau hardcoded
        $getValue = function($key, $default, $source = 'penduduk') use ($pendudukStats, $usePendudukData) {
            if ($usePendudukData && $source === 'penduduk' && isset($pendudukStats[$key])) {
                return $pendudukStats[$key];
            }
            // Fallback: cek tabel infografis
            $dbValue = Infografis::where('judul', 'like', "%{$key}%")->value('deskripsi');
            if ($dbValue && preg_match('/[\d\.]+/', $dbValue, $matches)) {
                return (int) str_replace('.', '', $matches[0]);
            }
            return $default;
        };

        // 4b. Susun struktur nested array (SAMA PERSIS seperti kode lamamu)
        $infografis = [
            // ===== DASAR (✅ DENGAN ICON) =====
            'total_penduduk' => [
                'value' => $getValue('total_penduduk', 4456),
                'icon' => asset('assets/icons/penduduk.png'),
            ],
            'kepala_keluarga' => [
                'value' => $getValue('kepala_keluarga', 1250),
                'icon' => asset('assets/icons/family.png'),
            ],
            'laki_laki' => [
                'value' => $getValue('laki_laki', 2200),
                'icon' => asset('assets/icons/male.png'),
            ],
            'perempuan' => [
                'value' => $getValue('perempuan', 2256),
                'icon' => asset('assets/icons/female.png'),
            ],
            
            // ===== PERKAWINAN (✅ DENGAN ICON) =====
            'perkawinan' => [
                'belum_kawin' => [
                    'value' => $getValue('perkawinan', 1200, 'perkawinan.belum_kawin'),
                    'icon' => asset('assets/icons/bk.png'),
                ],
                'kawin' => [
                    'value' => $getValue('perkawinan', 2800, 'perkawinan.kawin'),
                    'icon' => asset('assets/icons/k.png'),
                ],
                'cerai_hidup' => [
                    'value' => $getValue('perkawinan', 150, 'perkawinan.cerai_hidup'),
                    'icon' => asset('assets/icons/ch.png'),
                ],
                'cerai_mati' => [
                    'value' => $getValue('perkawinan', 200, 'perkawinan.cerai_mati'),
                    'icon' => asset('assets/icons/cm.png'),
                ],
                'kawin_tercatat' => [
                    'value' => $getValue('kawin tercatat', 2500),
                    'icon' => asset('assets/icons/kt.png'),
                ],
                'kawin_tidak_tercatat' => [
                    'value' => $getValue('kawin tidak tercatat', 300),
                    'icon' => asset('assets/icons/ktt.png'),
                ],
            ],
            
            // ===== KELOMPOK UMUR (Pyramid) =====
            'kelompok_umur' => $usePendudukData 
                ? self::formatAgeGroups($pendudukStats['kelompok_umur_raw']) 
                : [
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
            
            // ===== PENDIDIKAN =====
            'pendidikan' => $usePendudukData
                ? [
                    'tidak_belum_sekolah' => $pendudukStats['pendidikan']->get('Tidak Sekolah', 0) + $pendudukStats['pendidikan']->get('SD', 0),
                    'belum_tamat_sd' => $pendudukStats['pendidikan']->get('SD', 0),
                    'tamat_sd' => $pendudukStats['pendidikan']->get('SD', 0),
                    'sltp_sederajat' => $pendudukStats['pendidikan']->get('SMP', 0),
                    'slta_sederajat' => $pendudukStats['pendidikan']->get('SMA', 0),
                    'diploma_i_ii' => $pendudukStats['pendidikan']->get('D1', 0) + $pendudukStats['pendidikan']->get('D2', 0),
                    'diploma_iii_sarjana_muda' => $pendudukStats['pendidikan']->get('D3', 0),
                    'diploma_iv_strata_i' => $pendudukStats['pendidikan']->get('S1', 0),
                    'strata_ii' => $pendudukStats['pendidikan']->get('S2', 0),
                    'strata_iii' => $pendudukStats['pendidikan']->get('S3', 0),
                ]
                : [
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
            'pekerjaan' => $usePendudukData
                ? $pendudukStats['pekerjaan']->map(function($value, $key) {
                    return ['value' => $value, 'icon' => self::getPekerjaanIcon($key)];
                })->toArray()
                : [
                    'belum_tidak_bekerja' => [
                        'value' => $getValue('tidak bekerja', 1850),
                        'icon' => asset('assets/icons/bb.png'),
                    ],
                    'pelajar_mahasiswa' => [
                        'value' => $getValue('pelajar', 680),
                        'icon' => asset('assets/icons/m.png'),
                    ],
                    'pegawai_negeri' => [
                        'value' => $getValue('pegawai negeri', 320),
                        'icon' => asset('assets/icons/pn.png'),
                    ],
                    'karyawan_swasta' => [
                        'value' => $getValue('karyawan swasta', 550),
                        'icon' => asset('assets/icons/ps.png'),
                    ],
                    'petani_pekebun' => [
                        'value' => $getValue('petani', 420),
                        'icon' => asset('assets/icons/p.png'),
                    ],
                    'pedagang' => [
                        'value' => $getValue('pedagang', 280),
                        'icon' => asset('assets/icons/D.png'),
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

    // =====================================================================
    // HELPER METHODS
    // =====================================================================
    
    /**
     * Format raw age groups to match blade structure
     */
    private static function formatAgeGroups($raw)
    {
        $groups = [
            '0-4' => ['laki' => 0, 'perempuan' => 0],
            '5-9' => ['laki' => 0, 'perempuan' => 0],
            '10-14' => ['laki' => 0, 'perempuan' => 0],
            '15-19' => ['laki' => 0, 'perempuan' => 0],
            '20-24' => ['laki' => 0, 'perempuan' => 0],
            '25-29' => ['laki' => 0, 'perempuan' => 0],
            '30-34' => ['laki' => 0, 'perempuan' => 0],
            '35-39' => ['laki' => 0, 'perempuan' => 0],
            '40-44' => ['laki' => 0, 'perempuan' => 0],
            '45-49' => ['laki' => 0, 'perempuan' => 0],
            '50-54' => ['laki' => 0, 'perempuan' => 0],
            '55-59' => ['laki' => 0, 'perempuan' => 0],
            '60-64' => ['laki' => 0, 'perempuan' => 0],
            '65-69' => ['laki' => 0, 'perempuan' => 0],
            '70-74' => ['laki' => 0, 'perempuan' => 0],
            '75-79' => ['laki' => 0, 'perempuan' => 0],
            '80-84' => ['laki' => 0, 'perempuan' => 0],
            '85+' => ['laki' => 0, 'perempuan' => 0],
        ];
        
        foreach ($raw as $ageGroup => $data) {
            if (isset($groups[$ageGroup])) {
                $groups[$ageGroup] = $data;
            }
        }
        
        return $groups;
    }
    
    /**
     * Get icon path for pekerjaan based on keyword
     */
    private static function getPekerjaanIcon($pekerjaan)
    {
        $pekerjaan = strtolower($pekerjaan);
        
        if (str_contains($pekerjaan, 'pelajar') || str_contains($pekerjaan, 'mahasiswa')) {
            return asset('assets/icons/m.png');
        }
        if (str_contains($pekerjaan, 'negeri') || str_contains($pekerjaan, 'pns') || str_contains($pekerjaan, 'pegawai')) {
            return asset('assets/icons/pn.png');
        }
        if (str_contains($pekerjaan, 'swasta') || str_contains($pekerjaan, 'karyawan')) {
            return asset('assets/icons/ps.png');
        }
        if (str_contains($pekerjaan, 'petani') || str_contains($pekerjaan, 'pekebun')) {
            return asset('assets/icons/p.png');
        }
        if (str_contains($pekerjaan, 'dagang') || str_contains($pekerjaan, 'pedagang') || str_contains($pekerjaan, 'wiraswasta')) {
            return asset('assets/icons/D.png');
        }
        
        return asset('assets/icons/bb.png'); // Default
    }
}