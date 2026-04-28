<?php

namespace App\Models;

// PASTIKAN BARIS INI ADA!
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// PASTIKAN CLASS EXTEND Authenticatable!
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'nama_lengkap', 'username', 'email', 'password', 
        'role', 'foto', 'cover', 'jenis_kelamin', 'no_telp', 'alamat',
    ];

    protected $hidden = ['password', 'remember_token'];
}