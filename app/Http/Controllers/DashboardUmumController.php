<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use App\Models\Infografis;
use App\Models\Penduduk;

class DashboardUmumController extends Controller
{
    public function __invoke()
    {
        // =====================================================================
        // 1. HERO SLIDES - KONFIGURASI FILE LOKAL
        // 'file' berisi path relatif dari folder 'public/'
        // =====================================================================
        $heroSlides = [
        [
            'type' => 'video',
            'file' => 'assets/videos/hero/hero1.mp4',
            'title' => 'Selamat Datang di E-Deslay',
            'subtitle' => 'Website Resmi Kelurahan Banjardowo',
            'tagline' => 'Layanan Digital Desa Yang Lebih Mudah Dan Cepat'
        ],
        [
            'type' => 'video',
            'file' => 'assets/videos/hero/hero2.mp4',
            'title' => 'Profil Desa Banjardowo',
            'subtitle' => 'Membangun Desa Bersama',
            'tagline' => 'Transparan, Efisien, dan Berkarakter'
        ],
        [
            'type' => 'video',
            'file' => 'assets/videos/hero/hero3.mp4',
            'title' => 'Inovasi Digital untuk Kesejahteraan',
            'subtitle' => 'Desa Banjardowo Menuju Smart Village',
            'tagline' => 'Akses Informasi Cepat, Jelas, dan Terstruktur'
        ],
        [
            'type' => 'video',
            'file' => 'assets/videos/hero/hero4.mp4',
            'title' => 'Potensi Desa Banjardowo',
            'subtitle' => 'Mengenal Sumber Daya Alam & Manusia',
            'tagline' => 'Desa yang Kaya akan Potensi'
        ],
        [
            'type' => 'video',
            'file' => 'assets/videos/hero/hero5.mp4',
            'title' => 'Kegiatan Masyarakat',
            'subtitle' => 'Gotong Royong & Kearifan Lokal',
            'tagline' => 'Bersama Membangun Desa'
        ],
        [
            'type' => 'video',
            'file' => 'assets/videos/hero/hero6.mp4',
            'title' => 'Prestasi & Harapan',
            'subtitle' => 'Langkah Maju Desa Banjardowo',
            'tagline' => 'Terus Berkarya untuk Negeri'
        ],
    ];

        // =====================================================================
        // 2. AMBIL DATA KEGIATAN (Limit 6 untuk slider)
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
        // 3. AMBIL DATA PRESTASI (Limit 6 untuk slider)
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
        // 4. AMBIL DATA STRUKTUR DESA
        // =====================================================================
        $strukturDesa = DB::table('struktur_desa')
            ->select('id', 'nama', 'jabatan', 'nip', 'foto', 'urutan')
            ->orderBy('urutan', 'asc')
            ->get()
            ->map(function ($item) {
                if ($item->foto) {
                    $item->foto_url = asset('storage/' . $item->foto);
                } else {
                    $item->foto_url = asset('assets/images/default-avatar.png');
                }
                return $item;
            });

        // =====================================================================
        // 5. INFOGRAFIS - AMBIL DARI TABEL PENDUDUK
        // =====================================================================
        
        $getIcon = fn($name) => asset("assets/icons/{$name}.png");
        $q = Penduduk::query();
        
        try {
            if (Schema::hasColumn('penduduk', 'status_penduduk')) {
                $q->where('status_penduduk', 'Tetap');
            }
        } catch (\Exception $e) {}

        $total = $q->count();
        $kk = (clone $q)->where('status_keluarga', 'Kepala Keluarga')->count();
        $laki = (clone $q)->where('jenis_kelamin', 'L')->count();
        $perempuan = (clone $q)->where('jenis_kelamin', 'P')->count();

        $perkawinan = [
            'belum_kawin' => ['value' => (clone $q)->where('status_perkawinan', 'Belum Kawin')->count(), 'icon' => $getIcon('bk')],
            'kawin' => ['value' => (clone $q)->where('status_perkawinan', 'Kawin')->count(), 'icon' => $getIcon('k')],
            'cerai_hidup' => ['value' => (clone $q)->where('status_perkawinan', 'Cerai Hidup')->count(), 'icon' => $getIcon('ch')],
            'cerai_mati' => ['value' => (clone $q)->where('status_perkawinan', 'Cerai Mati')->count(), 'icon' => $getIcon('cm')],
            'kawin_tercatat' => ['value' => (clone $q)->where('status_perkawinan', 'Kawin')->where('kawin_tercatat', 'Ya')->count(), 'icon' => $getIcon('kt')],
            'kawin_tidak_tercatat' => ['value' => (clone $q)->where('status_perkawinan', 'Kawin')->where('kawin_tercatat', 'Tidak')->count(), 'icon' => $getIcon('ktt')],
        ];

        $ageGroups = ['0-4','5-9','10-14','15-19','20-24','25-29','30-34','35-39','40-44','45-49','50-54','55-59','60-64','65-69','70-74','75-79','80-84','85+'];
        $kelompokUmur = [];
        
        foreach ($ageGroups as $range) {
            if (str_contains($range, '+')) {
                $min = (int) str_replace('+', '', $range);
                $max = 999;
            } else {
                [$min, $max] = explode('-', $range);
                $max = (int)$max;
                $min = (int)$min;
            }
            
            $lakiAge = (clone $q)->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?', [$min, $max])->where('jenis_kelamin', 'L')->count();
            $perempuanAge = (clone $q)->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?', [$min, $max])->where('jenis_kelamin', 'P')->count();
            
            $kelompokUmur[$range] = ['laki' => $lakiAge, 'perempuan' => $perempuanAge];
        }

        $pendidikanRaw = (clone $q)->selectRaw('
            CASE 
                WHEN pendidikan IN ("Tidak Sekolah","Belum Sekolah") THEN "tidak_belum_sekolah"
                WHEN pendidikan = "Belum Tamat SD" THEN "belum_tamat_sd"
                WHEN pendidikan = "SD" OR pendidikan LIKE "%SD%" THEN "tamat_sd"
                WHEN pendidikan = "SMP" OR pendidikan LIKE "%SLTP%" THEN "sltp_sederajat"
                WHEN pendidikan = "SMA" OR pendidikan LIKE "%SLTA%" OR pendidikan LIKE "%SMK%" THEN "slta_sederajat"
                WHEN pendidikan IN ("D1","D2") THEN "diploma_i_ii"
                WHEN pendidikan = "D3" THEN "diploma_iii_sarjana_muda"
                WHEN pendidikan = "S1" OR pendidikan LIKE "%Strata I%" OR pendidikan LIKE "%Diploma IV%" THEN "diploma_iv_strata_i"
                WHEN pendidikan = "S2" OR pendidikan LIKE "%Strata II%" THEN "strata_ii"
                WHEN pendidikan = "S3" OR pendidikan LIKE "%Strata III%" THEN "strata_iii"
                ELSE "lainnya"
            END as grouped_pendidikan,
            COUNT(*) as total
        ')->groupBy('grouped_pendidikan')->pluck('total', 'grouped_pendidikan');

        $pendidikan = [
            'tidak_belum_sekolah' => $pendidikanRaw->get('tidak_belum_sekolah', 0),
            'belum_tamat_sd' => $pendidikanRaw->get('belum_tamat_sd', 0),
            'tamat_sd' => $pendidikanRaw->get('tamat_sd', 0),
            'sltp_sederajat' => $pendidikanRaw->get('sltp_sederajat', 0),
            'slta_sederajat' => $pendidikanRaw->get('slta_sederajat', 0),
            'diploma_i_ii' => $pendidikanRaw->get('diploma_i_ii', 0),
            'diploma_iii_sarjana_muda' => $pendidikanRaw->get('diploma_iii_sarjana_muda', 0),
            'diploma_iv_strata_i' => $pendidikanRaw->get('diploma_iv_strata_i', 0),
            'strata_ii' => $pendidikanRaw->get('strata_ii', 0),
            'strata_iii' => $pendidikanRaw->get('strata_iii', 0),
        ];

        $pekerjaanRaw = (clone $q)->selectRaw('
            CASE 
                WHEN pekerjaan IN ("Belum Bekerja","Tidak Bekerja","Menganggur") OR pekerjaan IS NULL OR pekerjaan = "" THEN "belum_tidak_bekerja"
                WHEN pekerjaan LIKE "%Pelajar%" OR pekerjaan LIKE "%Mahasiswa%" OR pekerjaan LIKE "%Siswa%" THEN "pelajar_mahasiswa"
                WHEN pekerjaan LIKE "%Negeri%" OR pekerjaan LIKE "%ASN%" OR pekerjaan LIKE "%PNS%" OR pekerjaan LIKE "%TNI%" OR pekerjaan LIKE "%Polri%" THEN "pegawai_negeri"
                WHEN pekerjaan LIKE "%Swasta%" OR pekerjaan LIKE "%Karyawan%" OR pekerjaan LIKE "%Buruh%" THEN "karyawan_swasta"
                WHEN pekerjaan LIKE "%Petani%" OR pekerjaan LIKE "%Pekebun%" OR pekerjaan LIKE "%Buruh Tani%" THEN "petani_pekebun"
                WHEN pekerjaan LIKE "%Dagang%" OR pekerjaan LIKE "%Pedagang%" OR pekerjaan LIKE "%Wiraswasta%" THEN "pedagang"
                ELSE "lainnya"
            END as grouped_pekerjaan,
            COUNT(*) as total
        ')->groupBy('grouped_pekerjaan')->pluck('total', 'grouped_pekerjaan');

        $pekerjaan = [
            'belum_tidak_bekerja' => ['value' => $pekerjaanRaw->get('belum_tidak_bekerja', 0), 'icon' => $getIcon('bb')],
            'pelajar_mahasiswa' => ['value' => $pekerjaanRaw->get('pelajar_mahasiswa', 0), 'icon' => $getIcon('m')],
            'pegawai_negeri' => ['value' => $pekerjaanRaw->get('pegawai_negeri', 0), 'icon' => $getIcon('pn')],
            'karyawan_swasta' => ['value' => $pekerjaanRaw->get('karyawan_swasta', 0), 'icon' => $getIcon('ps')],
            'petani_pekebun' => ['value' => $pekerjaanRaw->get('petani_pekebun', 0), 'icon' => $getIcon('p')],
            'pedagang' => ['value' => $pekerjaanRaw->get('pedagang', 0), 'icon' => $getIcon('D')],
        ];

        $infografis = [
            'total_penduduk' => ['value' => $total, 'icon' => $getIcon('penduduk')],
            'kepala_keluarga' => ['value' => $kk, 'icon' => $getIcon('family')],
            'laki_laki' => ['value' => $laki, 'icon' => $getIcon('male')],
            'perempuan' => ['value' => $perempuan, 'icon' => $getIcon('female')],
            'perkawinan' => $perkawinan,
            'kelompok_umur' => $kelompokUmur,
            'pendidikan' => $pendidikan,
            'pekerjaan' => $pekerjaan,
        ];

        // =====================================================================
        // 6. RETURN VIEW
        // =====================================================================
        return view('dashboard_umum', compact(
            'heroSlides',      // ✅ ARRAY HERO SLIDES LOKAL
            'kegiatanList',
            'prestasiList',
            'strukturDesa',
            'infografis'
        ));
    }
}