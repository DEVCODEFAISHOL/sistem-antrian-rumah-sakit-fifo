<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode_poli',
        'deskripsi',
        'lokasi',
        'kapasitas_harian',
        'dokter_id',
        'status',
    ];

    // Relasi ke tabel queues (satu poli memiliki banyak antrian)
    public function queues()
    {
        return $this->hasMany(Queue::class);
    }
     // Relasi ke tabel dokter (satu poli bisa memiliki satu dokter)
     public function dokter()
     {
         return $this->belongsTo(Dokter::class);
     }
}
