<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kematian extends Model
{
    protected $table = 'pengajuan_kematian';

    protected $fillable = [
        'nama_pelapor', 'nik_pelapor', 'no_hp', 'alamat', 'tanggal_pengajuan',
        'nama_almarhum', 'nik_almarhum', 'tempat_kematian', 'tanggal_kematian', 
        'sebab_kematian', 'hubungan_pelapor',
        'dokumen_scan', 'metode_pengambilan', 'status', 'nomor_surat', 
        'file_surat_jadi', 'keterangan_admin', 'alasan_tolak'
    ];

    protected $casts = [
        'dokumen_scan' => 'array',
        'tanggal_pengajuan' => 'date',
        'tanggal_kematian' => 'date',
    ];
}