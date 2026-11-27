<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Roles del sistema. Los nombres deben ser iguales a los de web.php y el sidebar.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Administrador', 'description' => 'Acceso total al sistema'],
            ['name' => 'Químico farmacéutico', 'description' => 'Registra ventas, controla medicamentos y revisa reportes'],
            ['name' => 'Cajero', 'description' => 'Registra ventas y clientes'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
