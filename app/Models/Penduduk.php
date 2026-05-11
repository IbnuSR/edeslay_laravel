<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Penduduk extends Model
{
    protected $table = 'penduduk';
    
    // ✅ UPDATE $fillable: Sesuaikan dengan kolom database yang AKTUAL
    protected $fillable = [
        'nik',
        'nama',                      // ✅ Bukan 'nama_lengkap'
        'jenis_kelamin',
        'tanggal_lahir',
        'pendidikan',                // ✅ Bukan 'pendidikan_terakhir'
        'pekerjaan',
        'status_perkawinan',
        'kawin_tercatat',           // ✅ Kolom baru untuk infografis
        'dusun',
        'status_keluarga',          // ✅ Kolom baru untuk hitung Kepala Keluarga
    ];
    
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
    
    // Accessor: Hitung umur otomatis
    public function umur(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tanggal_lahir ? now()->diffInYears($this->tanggal_lahir) : null
        );
    }
    
    // Scope: Filter berdasarkan jenis kelamin
    public function scopeJenisKelamin($query, $jk)
    {
        return $query->where('jenis_kelamin', $jk);
    }
    
    // Scope: Filter berdasarkan pendidikan
    public function scopePendidikan($query, $pendidikan)
    {
        return $query->where('pendidikan', $pendidikan);
    }
    
    // Scope: Filter berdasarkan dusun
    public function scopeByDusun($query, $dusun)
    {
        return $query->where('dusun', $dusun);
    }
    
    // Scope: Hanya Kepala Keluarga
    public function scopeKepalaKeluarga($query)
    {
        return $query->where('status_keluarga', 'Kepala Keluarga');
    }
}