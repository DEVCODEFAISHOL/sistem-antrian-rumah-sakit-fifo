<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public static function generateQueueNumber($poli_id)
    {
        $poli = Poli::find($poli_id);
        $prefix = strtoupper(substr($poli->nama, 0, 1));
        $lastQueue = self::where('poli_id', $poli_id)->orderBy('id', 'desc')->first();
        $number = $lastQueue ? (int) substr($lastQueue->queue_number, 1) + 1 : 1;
        $queueNumber = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);

        while (self::where('queue_number', $queueNumber)->exists()) {
            $number++;
            $queueNumber = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
        }

        return $queueNumber;
    }
}
