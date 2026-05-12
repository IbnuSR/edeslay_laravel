<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saran extends Model
{
    protected $table = 'saran';

    protected $fillable = [
        'nama',
        'judul',
        'email',
        'pesan',
        'tanggal_dikirim',
        'isi_saran',
        'foto_sampul',
        'foto_type',
    ];
}