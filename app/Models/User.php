<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang dapat diisi secara mass assignment.
     */
    protected $fillable = [
        'nip',
        'name',
        'email',
        'email_verified_at',
        'password',
        'role',
    ];

    /**
     * Kolom yang disembunyikan saat model diubah menjadi array/JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Konversi tipe data atribut.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: satu pengguna memiliki banyak laporan.
     */
    public function laporans(): HasMany
    {
        return $this->hasMany(Laporan::class);
    }

    /**
     * Memeriksa apakah pengguna adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Memeriksa apakah pengguna adalah PJLP.
     */
    public function isPjlp(): bool
    {
        return $this->role === 'pjlp';
    }

    public function verifikasiSebagaiAdmin(): HasMany
{
    return $this->hasMany(Verifikasi::class, 'verifikator_id');
}
}