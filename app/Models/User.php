<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nisn',
        'asal_sekolah',
        'departemen_lpkia',
        'tanggal_mulai_pkl',
        'tanggal_selesai_pkl',
        'no_hp',
        'alamat',
        'nama_orang_tua',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ka Presensi
    public function presensis()
    {
        return $this->hasMany(Presensi::class);
    }

    // Relasi ka Jurnal Kegiatan
    public function jurnals()
    {
        return $this->hasMany(JurnalKegiatan::class);
    }
}