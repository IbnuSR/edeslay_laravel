<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelahiran extends Model
{
    protected $table = 'pengajuan_kelahiran';

    protected $fillable = [
        'nama_lengkap', 'nik', 'no_hp', 'alamat', 'tanggal_pengajuan',
        'nama_bayi', 'tempat_lahir_bayi', 'tanggal_lahir_bayi', 'jenis_kelamin_bayi', 'waktu_lahir',
        'nama_ayah', 'nama_ibu', 'nik_ayah', 'nik_ibu',
        'dokumen_scan', 'metode_pengambilan', 'status', 'nomor_surat', 
        'file_surat_jadi', 'keterangan_admin', 'alasan_tolak'
    ];

    protected $casts = [
        'dokumen_scan' => 'array',
        'tanggal_pengajuan' => 'date',
        'tanggal_lahir_bayi' => 'date',
    ];
}