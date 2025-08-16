<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\Poli;
use App\Models\PoliQuota;
use Carbon\Carbon;

class QueueSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $polis = Poli::where('status', 'aktif')->get();
        $priorities = ['ringan', 'sedang', 'berat'];
        $visitTypes = ['baru', 'lama'];
        $statuses = ['waiting', 'called', 'completed'];

        for ($i = 0; $i < 100; $i++) { // contoh 100 antrian
            $patient = $patients->random();
            $poli = $polis->random();
            $dokter = $poli->dokter;

            // Tanggal checkup acak (7 hari ke depan)
            $checkupDate = Carbon::today()->addDays(rand(0, 6))->toDateString();

            // Cari kuota untuk poli & tanggal tsb
            $quota = PoliQuota::where('poli_id', $poli->id)
                ->where('quota_date', $checkupDate)
                ->first();

            // Kalau kuota tidak ada atau penuh → skip
            if (!$quota || $quota->current_count >= $quota->max_quota) {
                continue;
            }

            // Generate nomor antrian
            $prefix = strtoupper(substr($poli->nama, 0, 1));
            $queueNumber = $prefix . str_pad($quota->current_count + 1, 3, '0', STR_PAD_LEFT);

            // Insert ke table queues
            DB::table('queues')->insert([
                'patient_id' => $patient->id,
                'poli_id' => $poli->id,
                'dokter_id' => $dokter ? $dokter->id : null,
                'queue_number' => $queueNumber,
                'priority' => $priorities[array_rand($priorities)],
                'appointment_time' => Carbon::now()->addHours(rand(8, 16))->format('H:i'),
                'called_time' => null, // default null → nanti diupdate saat dipanggil
                'keterangan' => rand(0, 1) ? 'Antrian online' : 'Datang langsung',
                'complaint' => rand(0, 1) ? 'Sakit kepala' : 'Lemas',
                'checkup_date' => $checkupDate,
                'status' => $statuses[array_rand($statuses)],
                'estimated_waiting_time' => rand(10, 60),
                'jenis_kunjungan' => $visitTypes[array_rand($visitTypes)],
                'is_emergency' => rand(0, 1) == 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update kuota → tambah 1 pasien
            $quota->increment('current_count');
        }
    }
}

