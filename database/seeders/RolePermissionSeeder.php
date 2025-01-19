<?php

// database/seeders/RolePermissionSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat permissions
        $permissions = [
            // Admin permissions
            'manage users',
            'manage patients',
            'manage queues',
            'manage hospitals',

            // Staff permissions
            'view queues',
            'create queues',
            'process queues',

            // Pasien permissions
            'view own queues', // Melihat antrian sendiri
            'create own queues', // Mengambil antrian baru
            'view queue history', // Melihat riwayat antrian
            'view medical history', // Melihat riwayat penyakit
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Buat roles dan assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'manage users',
            'manage patients',
            'manage queues',
            'manage hospitals',
            'view queues',
            'create queues',
            'process queues',
        ]);

        $staffRole = Role::create(['name' => 'staff']);
        $staffRole->givePermissionTo([
            'view queues',
            'create queues',
            'process queues',
        ]);
    }
}
