<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Nama tabel di database
    protected $table = 'users';
    
    // Primary key
    protected $primaryKey = 'id';
    
    // Tipe primary key
    protected $keyType = 'int';
    
    // Auto-increment
    public $incrementing = true;
    
    // Timestamps
    public $timestamps = true;
    
    // Fillable fields (yang boleh di-mass assign)
    protected $fillable = [
        'nama_lengkap',
        'username',      // ← Pakai username, bukan email
        'email',
        'password',      // ← MD5 di database
        'role',
        'foto',
        'cover',
        'jenis_kelamin',
        'no_telp',
        'alamat',
    ];
    
    // Hidden fields (tidak dikirim ke response API)
    protected $hidden = [
        'password',      // ← Password tetap hidden
        'remember_token',
    ];
    
    // Cast attributes ke tipe data tertentu
    protected $casts = [
        'email_verified_at' => 'datetime',
        // Jangan cast password ke 'hashed' karena kita pakai MD5 manual
    ];
    
    /**
     * Custom: Laravel default pakai email untuk auth,
     * kita override pakai username.
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }
    
    /**
     * Custom: Password di database pakai MD5,
     * jadi kita bypass Laravel's password verification.
     * Verification akan kita handle manual di LoginController.
     */
    public function getAuthPassword()
    {
        return $this->password;
    }
}