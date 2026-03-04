<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Crear rol superadmin si no existe
        $role = Role::firstOrCreate(
            ['name' => 'superadmin']
        );

        // Crear usuario superadmin si no existe
        User::firstOrCreate(
            ['email' => 'admin@aventura506.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('password123'),
                'role_id'  => $role->id,
            ]
        );
    }
}