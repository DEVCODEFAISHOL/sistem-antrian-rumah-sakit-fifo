<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi (fillable)
    protected $fillable = [
        'nama',
        'spesialisasi',
        'nomor_telepon',
        'email',
        'status',
    ];

    // Relasi one-to-many ke tabel `polis`
    public function polis()
    {
        return $this->hasMany(Poli::class);
    }

    // Relasi one-to-many ke tabel `queues`
    public function queues()
    {
        return $this->hasMany(Queue::class);
    }
}
