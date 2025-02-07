<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Dokter;

class PoliSeeder extends Seeder
{
    public function run(): void
    {
        $poliName = 'Poli Penyakit Dalam'; // Hanya satu nama poli
        $locations = [
            'Lantai 1', 'Lantai 2', 'Lantai 3', 'Lantai 4', 'Gedung A',
            'Gedung B', 'Gedung C', 'Gedung D', 'Area Parkir', 'Area Lobi',
            'Gedung E', 'Gedung F', 'Gedung G','Sayap Utara','Sayap Selatan','Ruang Tunggu','Area Farmasi'
        ];
        $baseKodePoli = strtoupper(substr(str_replace('Poli ', '', $poliName), 0, 2));

        for ($i = 0; $i < 300; $i++) {
            $dokter = Dokter::inRandomOrder()->first();
            $lokasi = $locations[array_rand($locations)] . ', Ruang ' . rand(101, 400);
            $kodePoli = $baseKodePoli;
            $counter = 1;

            while (DB::table('polis')->where('kode_poli', $kodePoli)->exists()) {
                $kodePoli = $baseKodePoli . $counter;
                $counter++;
            }

            DB::table('polis')->insert([
                'nama' => $poliName,
                'kode_poli' => $kodePoli,
                'deskripsi' => "Poli $poliName melayani pasien dengan keluhan terkait $poliName.",
                'lokasi' => $lokasi,
                'kapasitas_harian' => rand(20, 100),
                'dokter_id' => $dokter->id ?? null,
                'status' => rand(0, 1) ? 'aktif' : 'tidak aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
