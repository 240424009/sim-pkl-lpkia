<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalKegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'deskripsi_pekerjaan',
        'status_approval',
        'catatan_pembimbing',
        'rating',
    ];

    // Relasi ka model User (Siswa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}