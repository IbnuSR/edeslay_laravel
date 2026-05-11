<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens; // ← TAMBAHKAN INI

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory; // ← TAMBAHKAN HasApiTokens

    protected $table = 'users';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'nama_lengkap',
        'username',
        'email',
        'password',
        'role',
        'foto',
        'cover',
        'jenis_kelamin',
        'no_telp',
        'alamat',
        'name',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    // Jika kolom password di-hash, tambahkan casts
    protected $casts = [
        'password' => 'hashed',
    ];

    public $timestamps = false;
}