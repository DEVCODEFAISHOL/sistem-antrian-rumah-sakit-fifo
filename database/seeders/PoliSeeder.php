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
        $poliNames = [
            'Poli Penyakit Dalam', 'Poli Jantung', 'Poli Anak', 'Poli Bedah', 'Poli Saraf', 'Poli Mata',
            'Poli THT', 'Poli Kulit & Kelamin', 'Poli Gigi', 'Poli Psikiatri', 'Poli Paru', 'Poli Kebidanan',
            'Poli Rehabilitasi Medik', 'Poli Radiologi', 'Poli Anestesi', 'Poli Patologi Klinik',
             'Poli Umum', 'Poli Geriatri', 'Poli Akupuntur',
             'Poli Gizi', 'Poli Fisioterapi','Poli Onkologi', 'Poli Urologi',
            'Poli Bedah Orthopedi', 'Poli Endokrin', 'Poli Alergi', 'Poli Hemato-Onkologi',
             'Poli Bedah Saraf', 'Poli Bedah Plastik', 'Poli Ginekologi','Poli Tumbuh Kembang'
        ];

         $locations = [
           'Lantai 1', 'Lantai 2', 'Lantai 3', 'Lantai 4', 'Gedung A',
             'Gedung B', 'Gedung C', 'Gedung D', 'Area Parkir', 'Area Lobi'
             ,'Gedung E', 'Gedung F', 'Gedung G','Sayap Utara','Sayap Selatan','Ruang Tunggu','Area Farmasi'
         ];

       for ($i = 0; $i < 300; $i++) {
            $name = $poliNames[array_rand($poliNames)];
            $dokter = Dokter::inRandomOrder()->first();
            $baseKodePoli = strtoupper(substr(str_replace('Poli ', '', $name), 0, 2));
             $lokasi = $locations[array_rand($locations)] . ', Ruang ' . rand(101, 400);
               $kodePoli = $baseKodePoli;
             $counter = 1;

            while (DB::table('polis')->where('kode_poli', $kodePoli)->exists()) {
                 $kodePoli = $baseKodePoli . $counter;
                   $counter++;
              }


             DB::table('polis')->insert([
                'nama' => $name,
                 'kode_poli' => $kodePoli,
                 'deskripsi' => "Poli $name melayani pasien dengan keluhan terkait $name.",
                'lokasi' => $lokasi,
                 'kapasitas_harian' => rand(20, 100),
                 'dokter_id' => $dokter->id ?? null,
                'status' => rand(0,1) ? 'aktif' : 'tidak aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
       }
    }
}
