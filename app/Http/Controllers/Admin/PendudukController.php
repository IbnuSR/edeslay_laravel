<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\PendudukImport;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PendudukController extends Controller
{
    /**
     * Display listing of penduduk - ✅ METHOD INI HARUS ADA!
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
     * TAMPILKAN HALAMAN KONFIRMASI HAPUS (GET)
     */
    public function confirmDelete(Penduduk $penduduk)
    {
        return view('admin.penduduk.delete', compact('penduduk'));
    }

    /**
     * EKSEKUSI PENGHAPUSAN DATA (DELETE)
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
     * TAMPILKAN HALAMAN IMPORT
     */
    public function import()
    {
        return view('admin.penduduk.import');
    }

    /**
     * PROSES UPLOAD & IMPORT FILE EXCEL
     */
    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ], [
            'file.required' => 'Silakan pilih file Excel/CSV untuk diimport',
            'file.mimes' => 'Format file harus .xlsx, .xls, atau .csv',
            'file.max' => 'Ukuran file maksimal 10MB',
        ]);

        try {
            $file = $request->file('file');
            $importer = new PendudukImport();
            $result = $importer->import($file);

            if (!empty($result['errors'])) {
                return redirect()->route('admin.penduduk.index')
                    ->with('success', "✅ {$result['success']} data berhasil diimport")
                    ->with('warning', "⚠️ " . count($result['errors']) . " data gagal. Error: " . implode('; ', array_slice($result['errors'], 0, 3)));
            }

            return redirect()->route('admin.penduduk.index')
                ->with('success', "✅ {$result['success']} data penduduk berhasil diimport!");
                
        } catch (\Exception $e) {
            return back()
                ->with('error', '❌ Gagal mengimport file: ' . $e->getMessage());
        }
    }

    /**
     * DOWNLOAD TEMPLATE EXCEL YANG RAPI
     */
    public function downloadTemplate()
    {
        $fileName = 'Template_Data_Penduduk.xlsx';
        
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];
        
        $callback = function() {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $headerLabels = [
                'NIK (16 Digit)',
                'Nama Lengkap',
                'Jenis Kelamin (L/P)',
                'Tanggal Lahir (YYYY-MM-DD)',
                'Pendidikan',
                'Pekerjaan',
                'Status Perkawinan',
                'Kawin Tercatat (Ya/Tidak)',
                'Dusun',
                'Status Keluarga'
            ];
            
            $col = 'A';
            foreach ($headerLabels as $label) {
                $sheet->setCellValue($col . '1', $label);
                $col++;
            }

            $styleArray = [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF4A90E2'],
                ],
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ];
            $sheet->getStyle('A1:J1')->applyFromArray($styleArray);

            $dataContoh = [
                '3207011234567890',
                'Budi Santoso',
                'L',
                '1990-01-15',
                'SMA',
                'Karyawan Swasta',
                'Kawin',
                'Ya',
                'Krajan',
                'Anggota'
            ];

            $col = 'A';
            foreach ($dataContoh as $value) {
                $sheet->setCellValue($col . '2', $value);
                $col++;
            }

            $sheet->getStyle('A2:J2')->applyFromArray([
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                ],
            ]);

            $sheet->getColumnDimension('A')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(20);
            $sheet->getColumnDimension('F')->setWidth(25);
            $sheet->getColumnDimension('G')->setWidth(20);
            $sheet->getColumnDimension('H')->setWidth(20);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(20);

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * API: Get data for infografis
     */
    public function infografisData()
    {
        $q = Penduduk::query();

        $total = $q->count();
        $kk = (clone $q)->where('status_keluarga', 'Kepala Keluarga')->count();
        $laki = (clone $q)->where('jenis_kelamin', 'L')->count();
        $perempuan = (clone $q)->where('jenis_kelamin', 'P')->count();

        $perkawinan = [
            'belum_kawin' => (clone $q)->where('status_perkawinan', 'Belum Kawin')->count(),
            'kawin' => (clone $q)->where('status_perkawinan', 'Kawin')->count(),
            'cerai_hidup' => (clone $q)->where('status_perkawinan', 'Cerai Hidup')->count(),
            'cerai_mati' => (clone $q)->where('status_perkawinan', 'Cerai Mati')->count(),
            'kawin_tercatat' => (clone $q)->where('status_perkawinan', 'Kawin')->where('kawin_tercatat', 'Ya')->count(),
            'kawin_tidak_tercatat' => (clone $q)->where('status_perkawinan', 'Kawin')->where('kawin_tercatat', 'Tidak')->count(),
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
            'belum_tidak_bekerja' => ['value' => $pekerjaanRaw->get('belum_tidak_bekerja', 0), 'icon' => asset('assets/icons/bb.png')],
            'pelajar_mahasiswa' => ['value' => $pekerjaanRaw->get('pelajar_mahasiswa', 0), 'icon' => asset('assets/icons/m.png')],
            'pegawai_negeri' => ['value' => $pekerjaanRaw->get('pegawai_negeri', 0), 'icon' => asset('assets/icons/pn.png')],
            'karyawan_swasta' => ['value' => $pekerjaanRaw->get('karyawan_swasta', 0), 'icon' => asset('assets/icons/ps.png')],
            'petani_pekebun' => ['value' => $pekerjaanRaw->get('petani_pekebun', 0), 'icon' => asset('assets/icons/p.png')],
            'pedagang' => ['value' => $pekerjaanRaw->get('pedagang', 0), 'icon' => asset('assets/icons/D.png')],
        ];

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