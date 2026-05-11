<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PendudukController extends Controller
{
    /**
     * Display listing of penduduk
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $search = $request->get('search', '');
        $filter_jk = $request->get('jenis_kelamin', '');
        $filter_pendidikan = $request->get('pendidikan', '');
        $filter_dusun = $request->get('dusun', '');

        $query = Penduduk::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('pekerjaan', 'like', "%{$search}%");
            });
        }
        
        if ($filter_jk) $query->where('jenis_kelamin', $filter_jk);
        if ($filter_pendidikan) $query->where('pendidikan', $filter_pendidikan);
        if ($filter_dusun) $query->where('dusun', $filter_dusun);

        $pendudukList = $query->orderBy('nama', 'asc')->paginate(20)->withQueryString();
        
        // Statistik cepat untuk card
        $stats = [
            'total' => Penduduk::count(),
            'laki' => Penduduk::where('jenis_kelamin', 'L')->count(),
            'perempuan' => Penduduk::where('jenis_kelamin', 'P')->count(),
            'dusun_count' => Penduduk::select('dusun')->distinct()->count('dusun'),
        ];

        return view('admin.penduduk.index', compact(
            'pendudukList', 'stats', 'search', 'filter_jk', 'filter_pendidikan', 'filter_dusun'
        ));
    }

    /**
     * Show form create penduduk
     */
    public function create()
    {
        return view('admin.penduduk.create');
    }

    /**
     * Store new penduduk
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|digits:16|unique:penduduk,nik',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date|before:today',
            'pendidikan' => 'required|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'status_perkawinan' => 'required|string|max:50',
            'kawin_tercatat' => 'nullable|in:Ya,Tidak',
            'dusun' => 'nullable|string|max:100',
            'status_keluarga' => 'required|in:Kepala Keluarga,Anggota',
        ]);

        Penduduk::create($validated);

        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil ditambahkan');
    }

    /**
     * Show edit form
     */
    public function edit(Penduduk $penduduk)
    {
        return view('admin.penduduk.edit', compact('penduduk'));
    }

    /**
     * Update penduduk
     */
    public function update(Request $request, Penduduk $penduduk)
    {
        $validated = $request->validate([
            'nik' => 'required|digits:16|unique:penduduk,nik,' . $penduduk->id,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date|before:today',
            'pendidikan' => 'required|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'status_perkawinan' => 'required|string|max:50',
            'kawin_tercatat' => 'nullable|in:Ya,Tidak',
            'dusun' => 'nullable|string|max:100',
            'status_keluarga' => 'required|in:Kepala Keluarga,Anggota',
        ]);

        $penduduk->update($validated);

        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil diperbarui');
    }

    /**
     * ✅ TAMPILKAN HALAMAN KONFIRMASI HAPUS (GET)
     */
    public function confirmDelete(Penduduk $penduduk)
    {
        return view('admin.penduduk.delete', compact('penduduk'));
    }

    /**
     * ✅ EKSEKUSI PENGHAPUSAN DATA (DELETE)
     */
    public function destroy(Penduduk $penduduk)
    {
        try {
            $nama = $penduduk->nama;
            $penduduk->delete();
            
            return redirect()->route('admin.penduduk.index')
                ->with('success', "Data penduduk {$nama} berhasil dihapus permanen");
        } catch (\Exception $e) {
            return redirect()->route('admin.penduduk.index')
                ->with('error', 'Gagal menghapus data. Pastikan data tidak digunakan di tempat lain.');
        }
    }

    /**
     * API: Get data for infografis (public)
     */
    public function infografisData()
    {
        $q = Penduduk::query();

        // 1. Jumlah & KK
        $total = $q->count();
        $kk = (clone $q)->where('status_keluarga', 'Kepala Keluarga')->count();
        $laki = (clone $q)->where('jenis_kelamin', 'L')->count();
        $perempuan = (clone $q)->where('jenis_kelamin', 'P')->count();

        // 2. Perkawinan
        $perkawinan = [
            'belum_kawin' => (clone $q)->where('status_perkawinan', 'Belum Kawin')->count(),
            'kawin' => (clone $q)->where('status_perkawinan', 'Kawin')->count(),
            'cerai_hidup' => (clone $q)->where('status_perkawinan', 'Cerai Hidup')->count(),
            'cerai_mati' => (clone $q)->where('status_perkawinan', 'Cerai Mati')->count(),
            'kawin_tercatat' => (clone $q)->where('status_perkawinan', 'Kawin')->where('kawin_tercatat', 'Ya')->count(),
            'kawin_tidak_tercatat' => (clone $q)->where('status_perkawinan', 'Kawin')->where('kawin_tercatat', 'Tidak')->count(),
        ];

        // 3. Kelompok Umur
        $ageGroups = ['0-4','5-9','10-14','15-19','20-24','25-29','30-34','35-39','40-44','45-49','50-54','55-59','60-64','65-69','70-74','75-79','80-84','85+'];
        $kelompokUmur = [];
        
        foreach ($ageGroups as $range) {
            [$min, $max] = explode('-', $range);
            $max = ($max === '+') ? 999 : (int)$max;
            $min = (int)$min;
            
            $lakiAge = (clone $q)->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?', [$min, $max])->where('jenis_kelamin', 'L')->count();
            $perempuanAge = (clone $q)->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?', [$min, $max])->where('jenis_kelamin', 'P')->count();
            
            $kelompokUmur[$range] = ['laki' => $lakiAge, 'perempuan' => $perempuanAge];
        }

        // 4. Pendidikan
        $pendidikan = $q->selectRaw('
            CASE 
                WHEN pendidikan IN ("Tidak Sekolah","Belum Sekolah") THEN "Tidak/Belum Sekolah"
                WHEN pendidikan = "SD" OR pendidikan LIKE "%SD%" THEN "Tamat SD/Sederajat"
                WHEN pendidikan = "SMP" OR pendidikan LIKE "%SLTP%" OR pendidikan LIKE "%SMP%" THEN "SLTP/Sederajat"
                WHEN pendidikan = "SMA" OR pendidikan LIKE "%SLTA%" OR pendidikan LIKE "%SMA%" OR pendidikan LIKE "%SMK%" THEN "SLTA/Sederajat"
                WHEN pendidikan IN ("D1","D2") THEN "Diploma I/II"
                WHEN pendidikan = "D3" THEN "Diploma III/Sarjana Muda"
                WHEN pendidikan = "S1" OR pendidikan LIKE "%Strata I%" OR pendidikan LIKE "%Diploma IV%" THEN "Diploma IV/Strata I"
                WHEN pendidikan = "S2" OR pendidikan LIKE "%Strata II%" THEN "Strata II"
                WHEN pendidikan = "S3" OR pendidikan LIKE "%Strata III%" THEN "Strata III"
                ELSE pendidikan
            END as grouped_pendidikan,
            COUNT(*) as total
        ')->groupBy('grouped_pendidikan')->pluck('total', 'grouped_pendidikan');

        // 5. Pekerjaan
        $pekerjaan = $q->selectRaw('
            CASE 
                WHEN pekerjaan IN ("Belum Bekerja","Tidak Bekerja","Menganggur") THEN "Belum/Tidak Bekerja"
                WHEN pekerjaan LIKE "%Pelajar%" OR pekerjaan LIKE "%Mahasiswa%" OR pekerjaan LIKE "%Siswa%" THEN "Pelajar/Mahasiswa"
                WHEN pekerjaan LIKE "%Negeri%" OR pekerjaan LIKE "%ASN%" OR pekerjaan LIKE "%PNS%" OR pekerjaan LIKE "%TNI%" OR pekerjaan LIKE "%Polri%" THEN "Pegawai Negeri"
                WHEN pekerjaan LIKE "%Swasta%" OR pekerjaan LIKE "%Karyawan%" OR pekerjaan LIKE "%Buruh%" THEN "Karyawan Swasta"
                WHEN pekerjaan LIKE "%Petani%" OR pekerjaan LIKE "%Pekebun%" OR pekerjaan LIKE "%Buruh Tani%" THEN "Petani/Pekebun"
                WHEN pekerjaan LIKE "%Dagang%" OR pekerjaan LIKE "%Pedagang%" OR pekerjaan LIKE "%Wiraswasta%" THEN "Pedagang"
                WHEN pekerjaan IS NULL OR pekerjaan = "" THEN "Belum/Tidak Bekerja"
                ELSE pekerjaan
            END as grouped_pekerjaan,
            COUNT(*) as total
        ')->groupBy('grouped_pekerjaan')->pluck('total', 'grouped_pekerjaan');

        return response()->json([
            'total_penduduk' => $total,
            'kepala_keluarga' => $kk,
            'jenis_kelamin' => ['laki' => $laki, 'perempuan' => $perempuan],
            'perkawinan' => $perkawinan,
            'kelompok_umur' => $kelompokUmur,
            'pendidikan' => $pendidikan,
            'pekerjaan' => $pekerjaan,
        ]);
    }
}