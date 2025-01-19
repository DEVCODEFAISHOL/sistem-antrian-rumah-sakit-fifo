<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        $firstNames = [
            'Ari', 'Budi', 'Cahya', 'Dina', 'Eka', 'Faisal', 'Gita', 'Hana', 'Indra', 'Jaya',
            'Kiki', 'Lila', 'Mika', 'Nadia', 'Oman', 'Pita', 'Rani', 'Siska', 'Tika', 'Umar',
            'Vera', 'Wawan', 'Yuni', 'Zaki', 'Andi', 'Bimo', 'Cici', 'Deni', 'Evi', 'Fandi',
            'Gani', 'Heni', 'Ira', 'Jefri', 'Kurnia', 'Lia', 'Maman', 'Nani', 'Oki', 'Puji',
            'Rudi', 'Santi', 'Tita', 'Udin', 'Vina', 'Wahyudi', 'Yanti', 'Zul', 'Aan', 'Beni'
             ,'Candra', 'Diah', 'Egi', 'Fifi', 'Guntur', 'Hanafi', 'Iman', 'Juli', 'Kiki', 'Lia', 'Musa',
        ];

        $lastNames = [
            'Pratama', 'Wijaya', 'Susanto', 'Sanjaya', 'Hidayat', 'Nugroho', 'Kurniawan', 'Santoso',
            'Kusuma', 'Pranata', 'Setiawan', 'Utomo', 'Wibowo', 'Yulianto', 'Zulian', 'Ardiansyah',
            'Budianto', 'Cahyono', 'Darmanto', 'Eko', 'Fahmi', 'Gunawan', 'Hartono', 'Irawan',
             'Jumadi', 'Kurnia', 'Lestari', 'Mahendra', 'Nurdin', 'Oktavian', 'Prasetyo','Rachman',
             'Saputra','Tirto', 'Usman', 'Verdi', 'Wahyudi', 'Yanto', 'Zulkifli','Adi','Bambang',
             'Cahyo', 'Dwi', 'Erlangga','Fajar', 'Gatot','Haryanto', 'Imanuel', 'Joko'
        ];

        $specializations = [
            'Penyakit Dalam', 'Jantung', 'Anak', 'Bedah', 'Saraf', 'Mata',
            'THT', 'Kulit & Kelamin', 'Gigi', 'Psikiatri', 'Paru', 'Kebidanan',
            'Rehabilitasi Medik', 'Radiologi', 'Anestesi', 'Patologi Klinik','Umum','Geriatri','Akupuntur', 'Gizi','Fisioterapi'
        ];

        for ($i = 0; $i < 300; $i++) {
             $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = $firstName . ' ' . $lastName;
              $email = strtolower($firstName) . '.' . strtolower($lastName) . '@example.com';
             $phone = '08' . rand(10, 99) . '-' .
                     str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT) . '-' .
                     str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $address = 'Jl. ' . $lastNames[array_rand($lastNames)] . ' No. ' . rand(1, 100);
            DB::table('dokters')->insert([
                 'nama' => $fullName,
                 'spesialisasi' => $specializations[array_rand($specializations)],
                'email' => $email,
                 'telepon' => $phone,
                'alamat' => $address,
                 'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
