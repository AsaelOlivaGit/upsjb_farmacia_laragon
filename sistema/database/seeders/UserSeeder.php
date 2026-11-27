<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Usuarios de prueba, todos con la contraseña "password".
     */
    public function run(): void
    {
        // [nombre del rol => id]
        $roles = Role::pluck('id', 'name');

        $users = [
            ['role' => 'Administrador', 'name' => 'Juan Pérez García', 'dni' => '45781236', 'phone' => '987654321', 'tuition' => null, 'email' => 'admin@sanjuan.com'],
            ['role' => 'Químico farmacéutico', 'name' => 'Rosa Quispe Huamán', 'dni' => '41236985', 'phone' => '912345678', 'tuition' => 'CQFP-10452', 'email' => 'rquispe@sanjuan.com'],
            ['role' => 'Cajero', 'name' => 'Carlos Mendoza Ríos', 'dni' => '47852369', 'phone' => '923456789', 'tuition' => null, 'email' => 'cmendoza@sanjuan.com'],
            ['role' => 'Cajero', 'name' => 'Lucía Torres Salazar', 'dni' => '72145896', 'phone' => '934567891', 'tuition' => null, 'email' => 'ltorres@sanjuan.com'],
        ];

        foreach ($users as $user) {
            User::create([
                'rol_id' => $roles[$user['role']],
                'name' => $user['name'],
                'dni' => $user['dni'],
                'phone' => $user['phone'],
                'tuition' => $user['tuition'],
                'email' => $user['email'],
                'password' => 'password', // el cast 'hashed' del modelo User la encripta
            ]);
        }
    }
}
