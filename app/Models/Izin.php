<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    protected $table = 'pengajuan_izin';

    protected $fillable = [
        'nama_lengkap', 'nik', 'no_hp', 'alamat', 'tanggal_pengajuan',
        'nama_kegiatan', 'lokasi_kegiatan', 'tanggal_kegiatan', 'waktu_kegiatan', 'penanggung_jawab',
        'dokumen_scan', 'metode_pengambilan', 'status', 'nomor_surat', 
        'file_surat_jadi', 'keterangan_admin', 'alasan_tolak'
    ];

    protected $casts = [
        'dokumen_scan' => 'array',
        'tanggal_pengajuan' => 'date',
        'tanggal_kegiatan' => 'date',
    ];
}