<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Dokter;

class PoliSeeder extends Seeder
{
    public function run(): void
    {
        $poliName = 'Poli Penyakit Dalam';
        $locations = [
            'Lantai 1', 'Lantai 2', 'Lantai 3', 'Lantai 4', 'Gedung A',
            'Gedung B', 'Gedung C', 'Gedung D', 'Area Parkir', 'Area Lobi',
            'Gedung E', 'Gedung F', 'Gedung G','Sayap Utara','Sayap Selatan','Ruang Tunggu','Area Farmasi'
        ];

        $dokter = Dokter::inRandomOrder()->first();
        $lokasi = $locations[array_rand($locations)] . ', Ruang ' . rand(101, 400);

        DB::table('polis')->updateOrInsert(
            ['kode_poli' => 'PE'], // kalau sudah ada PE, update saja
            [
                'nama' => $poliName,
                'deskripsi' => "Poli $poliName melayani pasien dengan keluhan terkait $poliName.",
                'lokasi' => $lokasi,
                'kapasitas_harian' => 20, // sesuai flow kuota harian
                'dokter_id' => $dokter->id ?? null,
                'status' => 'aktif',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
