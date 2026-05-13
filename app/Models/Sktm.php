<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sktm extends Model
{
    use HasFactory;

    protected $table =
        'pengajuan_sktm';

    protected $fillable = [

        'user_id',

        'nama_lengkap',

        'nik',

        'no_hp',

        'alamat',

        'tanggal_pengajuan',

        'jumlah_tanggungan',

        'status_ekonomi',

        'tujuan_skmt',

        'dokumen_scan',

        'metode_pengambilan',

        'status',

        'nomor_surat',

        'file_surat_jadi',

        'keterangan_admin',

        'alasan_tolak',
    ];
}