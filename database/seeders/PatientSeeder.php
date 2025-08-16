<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    // Data wilayah untuk DKI Jakarta
    private $provinces = [
        ['id' => '31', 'name' => 'DKI Jakarta'],
    ];
    private $regencies = [
        ['id' => '3171', 'province_id' => '31', 'name' => 'Jakarta Selatan'],
        ['id' => '3172', 'province_id' => '31', 'name' => 'Jakarta Timur'],
        ['id' => '3173', 'province_id' => '31', 'name' => 'Jakarta Pusat'],
        ['id' => '3174', 'province_id' => '31', 'name' => 'Jakarta Barat'],
        ['id' => '3175', 'province_id' => '31', 'name' => 'Jakarta Utara'],
    ];
    private $districts = [
        ['id' => '3171010', 'regency_id' => '3171', 'name' => 'Kebayoran Baru'],
        ['id' => '3172010', 'regency_id' => '3172', 'name' => 'Cakung'],
        ['id' => '3173010', 'regency_id' => '3173', 'name' => 'Menteng'],
        ['id' => '3174010', 'regency_id' => '3174', 'name' => 'Grogol Petamburan'],
        ['id' => '3175010', 'regency_id' => '3175', 'name' => 'Koja'],
    ];
    private $villages = [
        ['id' => '3171010001', 'district_id' => '3171010', 'name' => 'Gandaria Utara'],
        ['id' => '3172010001', 'district_id' => '3172010', 'name' => 'Penggilingan'],
        ['id' => '3173010001', 'district_id' => '3173010', 'name' => 'Pegangsaan'],
        ['id' => '3174010001', 'district_id' => '3174010', 'name' => 'Tomang'],
        ['id' => '3175010001', 'district_id' => '3175010', 'name' => 'Tugu Utara'],
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

        // Get region codes
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
            'Kartika', 'Lestari', 'Muhammad', 'Nina', 'Oscar', 'Putri', 'Rini', 'Sari', 'Tono', 'Untung'
        ];

        $lastNames = [
            'Wijaya', 'Susanto', 'Sanjaya', 'Hutapea', 'Sitorus', 'Nasution', 'Siregar', 'Hidayat', 'Nugraha',
            'Santoso', 'Kusuma', 'Pratama', 'Widodo', 'Saputra', 'Suryadi', 'Hartono', 'Wibowo', 'Pranowo'
        ];

        for ($i = 0; $i < 20; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = $firstName . ' ' . $lastName;

            $gender = rand(0, 1) ? 'Laki-laki' : 'Perempuan';
            $birthDate = Carbon::createFromDate(rand(1970, 2005), rand(1, 12), rand(1, 28));

            $nikData = $this->generateValidNIK($birthDate, $gender);

            $phone = '08' . rand(10, 99) . '-' .
                    str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT) . '-' .
                    str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            $address = sprintf(
                'Jl. %s No. %d, Kel. %s, Kec. %s, %s, %s',
                $lastNames[array_rand($lastNames)],
                rand(1, 200),
                $nikData['address']['village'],
                $nikData['address']['district'],
                $nikData['address']['regency'],
                $nikData['address']['province']
            );

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
