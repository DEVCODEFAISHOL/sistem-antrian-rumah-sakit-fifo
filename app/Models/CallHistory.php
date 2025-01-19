<?php
// app/Models/CallHistory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'queue_id',
        'called_time',
        'status',
    ];

   protected $casts = [
        'called_time' => 'datetime',
    ];

    // Relasi ke model Queue
    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }
}
