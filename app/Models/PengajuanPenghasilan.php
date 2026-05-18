<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPenghasilan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_penghasilan';

    protected $guarded = [];
}