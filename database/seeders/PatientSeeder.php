<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    // Data wilayah statis (contoh)
    private $provinces = [
        ['id' => '32', 'name' => 'Jawa Barat'],
        ['id' => '33', 'name' => 'Jawa Tengah'],
        ['id' => '35', 'name' => 'Jawa Timur'],
    ];
    private $regencies = [
        ['id' => '3201', 'province_id' => '32', 'name' => 'Kabupaten Bogor'],
        ['id' => '3202', 'province_id' => '32', 'name' => 'Kabupaten Sukabumi'],
        ['id' => '3301', 'province_id' => '33', 'name' => 'Kabupaten Cilacap'],
    ];
    private $districts = [
        ['id' => '3201010', 'regency_id' => '3201', 'name' => 'Cibinong'],
        ['id' => '3201020', 'regency_id' => '3201', 'name' => 'Citeureup'],
        ['id' => '3301010', 'regency_id' => '3301', 'name' => 'Cilacap Selatan'],
    ];
    private $villages = [
        ['id' => '3201010001', 'district_id' => '3201010', 'name' => 'Pondok Rajeg'],
        ['id' => '3201010002', 'district_id' => '3201010', 'name' => 'Nanggewer'],
        ['id' => '3301010001', 'district_id' => '3301010', 'name' => 'Sidakaya'],
    ];

    private function generateValidNIK($birthDate, $gender)
    {
        // Get random locations
        $province = $this->provinces[array_rand($this->provinces)];
        $regency = $this->regencies[array_rand($this->regencies)];
        $district = $this->districts[array_rand($this->districts)];
        $village = $this->villages[array_rand($this->villages)];

        // Format birth date
        $day = (int)$birthDate->format('d');
        if ($gender === 'Perempuan') {
            $day += 40;
        }
        $month = $birthDate->format('m');
        $year = substr($birthDate->format('y'), -2);

        // Get region codes from IDs
        $provinceCode = substr($province['id'], 0, 2);
        $regencyCode = substr($regency['id'], 2, 2);
        $districtCode = substr($district['id'], 4, 2);

        // Generate unique number
        $uniqueNum = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        // Combine all components for NIK
        $nik = $provinceCode . $regencyCode . $districtCode .
               str_pad($day, 2, '0', STR_PAD_LEFT) .
               $month . $year . $uniqueNum;

        return [
            'nik' => $nik,
            'address' => [
                'province' => $province['name'],
                'regency' => $regency['name'],
                'district' => $district['name'],
                'village' => $village['name']
            ]
        ];
    }

    public function run()
    {
        // Array nama Indonesia
        $firstNames = [
            'Adi', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fitri', 'Gunawan', 'Hadi', 'Indah', 'Joko',
            'Kartika', 'Lestari', 'Muhammad', 'Nina', 'Oscar', 'Putri', 'Rini', 'Sari', 'Tono', 'Untung',
            'Wahyu', 'Yanto', 'Zainal', 'Ayu', 'Bambang', 'Dian', 'Eko', 'Farida', 'Gading', 'Hendra'
        ];

        $lastNames = [
            'Wijaya', 'Susanto', 'Sanjaya', 'Hutapea', 'Sitorus', 'Nasution', 'Siregar', 'Hidayat', 'Nugraha',
            'Santoso', 'Kusuma', 'Pratama', 'Widodo', 'Saputra', 'Suryadi', 'Hartono', 'Wibowo', 'Pranowo'
        ];

        for ($i = 0; $i < 300; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = $firstName . ' ' . $lastName;

            $gender = rand(0, 1) ? 'Laki-laki' : 'Perempuan';
            $birthDate = Carbon::createFromDate(rand(1950, 2005), rand(1, 12), rand(1, 28));

            $nikData = $this->generateValidNIK($birthDate, $gender);

            $phone = '08' . rand(10, 99) . '-' .
                    str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT) . '-' .
                    str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            $address = sprintf(
                'Jl. %s No. %d, Desa %s, Kec. %s, %s, %s',
                $lastNames[array_rand($lastNames)],
                rand(1, 200),
                $nikData['address']['village'],
                $nikData['address']['district'],
                $nikData['address']['regency'],
                $nikData['address']['province']
            );

            // Data riwayat medis
            $medicalHistory = rand(0, 1) ? 'Tidak ada' : json_encode([
                'riwayat_penyakit' => ['Hipertensi', 'Diabetes'],
                'alergi' => ['Penisilin', 'Kacang'],
                'riwayat_pengobatan' => ['Metformin 500mg', 'Amlodipine 5mg'],
            ]);

            DB::table('patients')->insert([
                'user_id' => null,
                'nama' => $fullName,
                'nik' => $nikData['nik'],
                'tanggal_lahir' => $birthDate,
                'jenis_kelamin' => $gender,
                'alamat' => $address,
                'no_telepon' => $phone,
                'medical_history' => $medicalHistory,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
