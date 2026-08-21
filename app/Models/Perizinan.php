<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perizinan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'bukti_dokumen',
        'status',
        'catatan_admin',
    ];

    public function user()
    {
        return $table = $this->belongsTo(User::class);
    }
}