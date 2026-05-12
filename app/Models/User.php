<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';

    // ✅ FIX 1: Tambahkan field yang dipakai controller
    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'name',
        'email',
        'role',
        'foto',              // ✅ Avatar/profil
        'foto_sampul',       // ✅ GANTI 'cover' → 'foto_sampul' (sesuai controller)
        'jenis_kelamin',
        'no_telp',
        'alamat',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // ✅ FIX 2: Hapus atau sesuaikan appends jika tidak dipakai
    protected $appends = [
        // 'foto_url'  // ← Opsional, kalau tidak dipakai di view bisa dihapus
    ];

    // ✅ FIX 3: Accessor yang fleksibel (handle berbagai path)
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            // Kalau path sudah termasuk folder (misal: 'profile/filename.jpg')
            if (str_contains($this->foto, '/')) {
                return asset('storage/' . $this->foto);
            }
            // Kalau path cuma filename (misal: 'filename.jpg')
            return asset('storage/profile/' . $this->foto);
        }
        return null;
    }

    // ✅ FIX 4: Aktifkan timestamps (atau hapus baris ini kalau memang tidak pakai)
    public $timestamps = true;  // ✅ UBAH dari false → true
}