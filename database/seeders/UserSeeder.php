<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Buat admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Ganti dengan password yang diinginkannpm run dev
        ]);
        $adminRole = Role::findByName('admin');
        $admin->assignRole($adminRole);

        // Buat staff user
        $staff = User::create([
            'name' => 'Staff',
            'email' => 'staff@example.com',
            'password' => bcrypt('password'), // Ganti dengan password yang diinginkan
        ]);
        $staffRole = Role::findByName('staff');
        $staff->assignRole($staffRole);


    }
}
