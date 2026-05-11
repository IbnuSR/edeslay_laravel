<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nikah extends Model
{
    protected $table = 'pengajuan_nikah';

    protected $fillable = [
        'nama_lengkap', 'nik', 'no_hp', 'alamat', 'tanggal_pengajuan',
        'nama_suami', 'nama_istri', 'nik_suami', 'nik_istri', 'alamat_masing2',
        'tanggal_rencana', 'lokasi_nikah', 'nama_pj',
        'dokumen_scan', 'metode_pengambilan', 'status', 'nomor_surat', 
        'file_surat_jadi', 'keterangan_admin', 'alasan_tolak'
    ];

    protected $casts = [
        'dokumen_scan' => 'array',
        'tanggal_pengajuan' => 'date',
        'tanggal_rencana' => 'date',
    ];
}