<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'poli_id',
        'dokter_id',
        'queue_number',
        'priority',
        'appointment_time',
        'called_time',
        'keterangan',
        'complaint',
        'checkup_date',
        'status',
        'estimated_waiting_time',
        'jenis_kunjungan',
        'is_emergency',
    ];

   // Casting kolom
   protected $casts = [
    'appointment_time' => 'datetime',
    'called_time' => 'datetime',
    'checkup_date' => 'date',
    'is_emergency' => 'boolean',
];

    // Relasi dengan pasien
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relasi dengan poli
    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    // Relasi dengan dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    // Relasi dengan riwayat pemanggilan
    public function callHistories()
    {
        return $this->hasMany(CallHistory::class);
    }

    // Method untuk generate nomor antrian
  // Di App\Models\Queue.php
public static function generateQueueNumber($poliId)
{
    $today = Carbon::today()->format('Ymd');
    $poli = Poli::find($poliId);
    $poliCode = $poli ? substr(strtoupper($poli->name), 0, 3) : 'XXX';

    $lastQueue = self::whereDate('created_at', Carbon::today())
        ->where('poli_id', $poliId)
        ->orderBy('id', 'desc')
        ->first();

    $number = $lastQueue ? (int)substr($lastQueue->queue_number, -3) + 1 : 1;

    return $poliCode . '-' . $today . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
}

}
