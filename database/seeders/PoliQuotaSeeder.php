<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PoliQuotaSeeder extends Seeder
{
    public function run()
    {
        $today = Carbon::today();

        // Ambil semua poli
        $polis = DB::table('polis')->get();

        foreach ($polis as $poli) {
            // Generate kuota untuk 7 hari ke depan
            for ($i = 0; $i < 7; $i++) {
                DB::table('poli_quotas')->insert([
                    'poli_id' => $poli->id,
                    'quota_date' => $today->copy()->addDays($i),
                    'max_quota' => $poli->kapasitas_harian,
                    'current_count' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
