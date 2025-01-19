<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\Poli;
use App\Models\Dokter;
use Carbon\Carbon;

class QueueSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $polis = Poli::where('status', 'aktif')->get();
        $priorities = ['ringan', 'sedang', 'berat'];
        $visitTypes = ['baru', 'lama'];
        $statuses = ['waiting', 'called', 'skipped', 'completed'];


        for ($i = 0; $i < 300; $i++) {
            $patient = $patients->random();
            //ambil poli yang status aktif
            $poli = $polis->count() > 0 ? $polis->random() : null;
            $dokter = $poli ? $poli->dokter : null;


            //Generate Nomor antrian
            $prefix = $poli ? strtoupper(substr($poli->nama, 0, 1)) : 'X';
            $queueNumber = $prefix . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            $checkupDate = Carbon::now()->addDays(rand(-7, 7))->toDateString();
            $appointmentTime = rand(0, 1) ? Carbon::now()->addHours(rand(8, 16))->addMinutes(rand(0, 59))->format('H:i') : null;
            $calledTime =  rand(0, 1) ? Carbon::now()->addHours(rand(8, 16))->addMinutes(rand(0, 59))->format('H:i:s') : null;
            $estimatedWaitingTime = rand(10, 60); // contoh perkiraan waktu tunggu

            DB::table('queues')->insert([
                'patient_id' => $patient->id,
                'poli_id' => $poli ? $poli->id : null,
                'dokter_id' => $dokter ? $dokter->id : null,
                'queue_number' => $queueNumber,
                'priority' => $priorities[array_rand($priorities)],
                'appointment_time' => $appointmentTime,
                'called_time' => $calledTime,
                'keterangan' => rand(0, 1) ? 'Antrian online' : null,
                'complaint' => rand(0, 1) ? 'Sakit kepala' : 'Lemas',
                'checkup_date' => $checkupDate,
                'status' => $statuses[array_rand($statuses)], // status acak
                'estimated_waiting_time' => $estimatedWaitingTime,
                'jenis_kunjungan' => $visitTypes[array_rand($visitTypes)],
                'is_emergency' => rand(0, 1) == 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
