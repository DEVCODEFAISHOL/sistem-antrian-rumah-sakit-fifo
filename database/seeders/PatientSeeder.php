<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    private $provinces = [];
    private $regencies = [];
    private $districts = [];
    private $villages = [];

    private function fetchData()
    {
        // Fetch provinces
        $response = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json');
        $this->provinces = $response->json();

        // Fetch regencies for a random province
        $randomProvince = $this->provinces[array_rand($this->provinces)];
        $response = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/{$randomProvince['id']}.json");
        $this->regencies = $response->json();

        // Fetch districts for a random regency
        $randomRegency = $this->regencies[array_rand($this->regencies)];
        $response = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/districts/{$randomRegency['id']}.json");
        $this->districts = $response->json();

        // Fetch villages for a random district
        $randomDistrict = $this->districts[array_rand($this->districts)];
        $response = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/villages/{$randomDistrict['id']}.json");
        $this->villages = $response->json();
    }

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
        $this->fetchData();

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
                'medical_history' => $medicalHistory, // Ganti riwayat_penyakit dengan medical_history
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
