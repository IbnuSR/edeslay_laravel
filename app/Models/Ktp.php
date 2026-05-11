<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ktp extends Model
{
    protected $table = 'pengajuan_ktp';

    protected $fillable = [
        'nama_lengkap', 'nik', 'no_hp', 'alamat', 'tanggal_pengajuan',
        'jenis_permohonan', 'alasan_permohonan', 'dokumen_scan',
        'metode_pengambilan', 'status', 'nomor_surat', 'file_surat_jadi', 
        'keterangan_admin', 'alasan_tolak'
    ];

    protected $casts = [
        'dokumen_scan' => 'array',
        'tanggal_pengajuan' => 'date',
    ];
}