<?php

namespace App\Http\Controllers\Api; // <--- WAJIB BENAR

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengajuanSuratApiController extends Controller
{
    private $tables = [
        'domisili' => 'pengajuan_domisili',
        'sktm' => 'pengajuan_sktm',
        'penghasilan' => 'pengajuan_penghasilan',
        'kelahiran' => 'pengajuan_kelahiran',
        'ktp' => 'pengajuan_ktp',
        'kematian' => 'pengajuan_kematian',
        'izin' => 'pengajuan_izin',
        'nikah' => 'pengajuan_nikah',
    ];

    // Mobile kirim data сюда
    public function store(Request $request)
    {
        $jenis = $request->jenis_surat; // contoh: "domisili"
        $table = $this->tables[$jenis] ?? null;

        if (!$table) return response()->json(['error' => 'Jenis surat tidak dikenali'], 400);

        // 1. Simpan File Scan (KTP/KK) jadi JSON array
        $files = [];
        if ($request->hasFile('scan_ktp')) $files['ktp'] = $request->file('scan_ktp')->store('scan_' . $jenis, 'public');
        if ($request->hasFile('scan_kk')) $files['kk'] = $request->file('scan_kk')->store('scan_' . $jenis, 'public');
        // Tambahkan file lain sesuai jenis surat jika perlu

        // 2. Ambil semua input kecuali file & token
        $input = $request->except(['_token', 'scan_ktp', 'scan_kk', 'jenis_surat']);
        $input['dokumen_scan'] = json_encode($files);
        $input['status'] = 'proses';
        $input['created_at'] = now();
        $input['updated_at'] = now();

        // 3. Insert ke Tabel yang sesuai
        $id = DB::table($table)->insertGetId($input);

        return response()->json([
            'success' => true, 
            'message' => 'Pengajuan berhasil dikirim',
            'id' => $id
        ], 201);
    }

    // Mobile cek status
    public function checkStatus($jenis, $id)
    {
        $table = $this->tables[$jenis] ?? abort(404);
        $data = DB::table($table)->where('id', $id)->first();
        
        if (!$data) return response()->json(['error' => 'Data tidak ditemukan'], 404);

        // Format agar mudah dibaca Mobile
        return response()->json([
            'status' => $data->status,
            'keterangan' => $data->keterangan_admin, // Jika ambil di desa
            'alasan_tolak' => $data->alasan_tolak,   // Jika ditolak
            'file_url' => $data->file_surat_jadi ? asset('storage/' . $data->file_surat_jadi) : null, // Jika online
            'nomor_surat' => $data->nomor_surat
        ]);
    }
}