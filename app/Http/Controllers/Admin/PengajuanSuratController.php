<?php

namespace App\Http\Controllers\Admin; // <--- WAJIB BENAR

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengajuanSuratController extends Controller
{
    // Mapping Jenis Surat ke Nama Tabel
    private $tables = [
        'domisili'    => 'pengajuan_domisili',
        'sktm'        => 'pengajuan_sktm',
        'penghasilan' => 'pengajuan_penghasilan',
        'kelahiran'   => 'pengajuan_kelahiran',
        'ktp'         => 'pengajuan_ktp',
        'kematian'    => 'pengajuan_kematian',
        'izin'        => 'pengajuan_izin',
        'nikah'       => 'pengajuan_nikah',
    ];

    // 1. LIST DATA (Admin melihat semua pengajuan)
    public function index(Request $request)
    {
        $jenis = $request->jenis ?? 'domisili'; // Default Domisili
        $table = $this->tables[$jenis] ?? abort(404);
        
        // Urutkan dari yang terbaru (proses dulu)
        $data = DB::table($table)->orderBy('status')->orderBy('created_at', 'desc')->get();
        
        return view('admin.surat.index', compact('data', 'jenis'));
    }

    // 2. DETAIL DATA (Admin melihat detail untuk memproses)
    public function show($jenis, $id)
    {
        $table = $this->tables[$jenis] ?? abort(404);
        $surat = DB::table($table)->where('id', $id)->first();
        
        if (!$surat) abort(404);

        return view('admin.surat.detail', compact('surat', 'jenis'));
    }

    // 3. PROSES / UPDATE STATUS (Logika utama sesuai permintaanmu)
    public function updateStatus(Request $request, $jenis, $id)
    {
        $table = $this->tables[$jenis] ?? abort(404);
        $status = $request->status;
        $metode = $request->metode_pengambilan; // ambil_desa / cetak_online

        $updateData = [
            'status' => $status,
            'updated_at' => now()
        ];

        // LOGIKA KALO SELESAI
        if ($status === 'selesai') {
            $updateData['nomor_surat'] = $request->nomor_surat;

            if ($metode === 'cetak_online') {
                // Wajib upload file
                if ($request->hasFile('file_surat')) {
                    $path = $request->file('file_surat')->store('surat_jadi', 'public');
                    $updateData['file_surat_jadi'] = $path;
                }
            } else {
                // Ambil di Desa -> Wajib isi Keterangan
                $updateData['keterangan_admin'] = $request->keterangan_admin;
            }
        } 
        
        // LOGIKA KALO DITOLAK
        elseif ($status === 'ditolak') {
            $updateData['alasan_tolak'] = $request->alasan_tolak;
        }

        DB::table($table)->where('id', $id)->update($updateData);

        return back()->with('success', 'Status berhasil diupdate!');
    }

    // 4. PRINT LAPORAN (Halaman khusus cetak - clean & simple)
    public function print($jenis)
    {
        $table = $this->tables[$jenis] ?? abort(404);
        
        // Ambil semua data urut terbaru
        $data = DB::table($table)->orderBy('created_at', 'desc')->get();
        
        // Hitung statistik
        $stats = [
            'total' => DB::table($table)->count(),
            'proses' => DB::table($table)->where('status', 'proses')->count(),
            'selesai' => DB::table($table)->where('status', 'selesai')->count(),
            'ditolak' => DB::table($table)->where('status', 'ditolak')->count(),
        ];
        
        return view('admin.surat.print', [
            'data' => $data,
            'jenis' => $jenis,
            'total' => $stats['total'],
            'proses' => $stats['proses'],
            'selesai' => $stats['selesai'],
            'ditolak' => $stats['ditolak'],
        ]);
    }
}