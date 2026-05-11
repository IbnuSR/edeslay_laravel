<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghasilan extends Model
{
    protected $table = 'pengajuan_penghasilan';

    protected $fillable = [
        'nama_lengkap', 'nik', 'no_hp', 'alamat', 'tanggal_pengajuan',
        'pekerjaan', 'jumlah_penghasilan', 'jumlah_tanggungan', 'tujuan_pengajuan',
        'dokumen_scan', 'metode_pengambilan', 'status', 'nomor_surat', 
        'file_surat_jadi', 'keterangan_admin', 'alasan_tolak'
    ];

    protected $casts = [
        'dokumen_scan' => 'array',
        'tanggal_pengajuan' => 'date',
    ];
}