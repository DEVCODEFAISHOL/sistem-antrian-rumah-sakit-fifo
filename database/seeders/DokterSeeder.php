<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        $firstNames = [
            'Ari', 'Budi', 'Cahya', 'Dina', 'Eka', 'Faisal', 'Gita', 'Hana', 'Indra', 'Jaya',
            'Kiki', 'Lila', 'Mika', 'Nadia', 'Oman', 'Pita', 'Rani', 'Siska', 'Tika', 'Umar',
            'Vera', 'Wawan', 'Yuni', 'Zaki', 'Andi', 'Bimo', 'Cici', 'Deni', 'Evi', 'Fandi',
            'Gani', 'Heni', 'Ira', 'Jefri', 'Kurnia', 'Lia', 'Maman', 'Nani', 'Oki', 'Puji',
            'Rudi', 'Santi', 'Tita', 'Udin', 'Vina', 'Wahyudi', 'Yanti', 'Zul', 'Aan', 'Beni',
            'Candra', 'Diah', 'Egi', 'Fifi', 'Guntur', 'Hanafi', 'Iman', 'Juli', 'Kiki', 'Lia', 'Musa',
        ];

        $lastNames = [
            'Pratama', 'Wijaya', 'Susanto', 'Sanjaya', 'Hidayat', 'Nugroho', 'Kurniawan', 'Santoso',
            'Kusuma', 'Pranata', 'Setiawan', 'Utomo', 'Wibowo', 'Yulianto', 'Zulian', 'Ardiansyah',
            'Budianto', 'Cahyono', 'Darmanto', 'Eko', 'Fahmi', 'Gunawan', 'Hartono', 'Irawan',
            'Jumadi', 'Kurnia', 'Lestari', 'Mahendra', 'Nurdin', 'Oktavian', 'Prasetyo','Rachman',
            'Saputra','Tirto', 'Usman', 'Verdi', 'Wahyudi', 'Yanto', 'Zulkifli','Adi','Bambang',
            'Cahyo', 'Dwi', 'Erlangga','Fajar', 'Gatot','Haryanto', 'Imanuel', 'Joko'
        ];

        // Cari poli yang spesialisasinya "Penyakit Dalam"
        $poli = DB::table('polis')->where('nama', 'Penyakit Dalam')->first();

        if (!$poli) {
            $this->command->error('Poli "Penyakit Dalam" tidak ditemukan. Seeder dibatalkan.');
            return;
        }

        $today = Carbon::today();

        for ($i = 0; $i < 30; $i++) { // contoh buat 30 dokter
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = $firstName . ' ' . $lastName;
            $email = strtolower($firstName) . '.' . strtolower($lastName) . '@example.com';
            $phone = '08' . rand(10, 99) . '-' .
                str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT) . '-' .
                str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $address = 'Jl. ' . $lastNames[array_rand($lastNames)] . ' No. ' . rand(1, 100);

            // Insert dokter dengan relasi ke poli
            $dokterId = DB::table('dokters')->insertGetId([
                'nama' => $fullName,
                'spesialisasi' => 'Penyakit Dalam',
                'email' => $email,
                'telepon' => $phone,
                'alamat' => $address,
                'poli_id' => $poli->id, // relasi ke poli
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert kuota ke poli_quotas untuk 7 hari ke depan
            for ($d = 0; $d < 7; $d++) {
                DB::table('poli_quotas')->insert([
                    'poli_id' => $poli->id,
                    'dokter_id' => $dokterId, // kalau kolom ini ada
                    'quota_date' => $today->copy()->addDays($d),
                    'max_quota' => $poli->kapasitas_harian ?? 10,
                    'current_count' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
