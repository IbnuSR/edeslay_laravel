<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanNikah extends Model
{
    protected $table = 'pengajuan_nikah';

    protected $fillable = [

        'user_id',
        'nama_lengkap',
        'nik',
        'no_hp',
        'alamat',
        'tanggal_pengajuan',

        'nama_suami',
        'nama_istri',

        'nik_suami',
        'nik_istri',

        'alamat_masing2',

        'tanggal_rencana',
        'lokasi_nikah',

        'nama_pj',

        'dokumen_scan',

        'metode_pengambilan',

        'status',
    ];
}