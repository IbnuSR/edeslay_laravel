<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

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
        'name', // dari kiri (kalau dipakai)
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public $timestamps = false; // dari kiri (PENTING kalau DB tidak pakai created_at)
}