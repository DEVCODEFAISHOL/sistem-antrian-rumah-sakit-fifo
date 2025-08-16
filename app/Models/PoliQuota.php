<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliQuota extends Model
{
    use HasFactory;

    protected $fillable = [
        'poli_id',
        'quota_date',
        'max_quota',
        'current_count',
    ];

    protected $casts = [
        'quota_date' => 'date',
    ];

    // Relasi ke Poli
    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }
}
