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
            ['email' => 'info.aventura506@gmail.com'],
            [
                'name'     => 'Super Administador Aventura506',
                'password' => Hash::make('aventura506.2026dys'),
                'role_id'  => $role->id,
            ]
        );
    }
}