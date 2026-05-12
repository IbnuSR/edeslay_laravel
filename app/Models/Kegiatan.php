<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';

    protected $fillable = [
        'judul',
        'lokasi',
        'deskripsi',
        'tanggal',
        'foto',
        'foto_type',
    ];
}
