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

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'name',
        'email',
        'role',
        'foto',
        'cover',
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

    protected $appends = [
        'foto_url'
    ];

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/profile/' . $this->foto);
        }

        return null;
    }

    public $timestamps = false;
}