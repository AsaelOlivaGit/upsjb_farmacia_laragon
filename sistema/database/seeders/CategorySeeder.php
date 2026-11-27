<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Analgésicos', 'description' => 'Alivian el dolor y bajan la fiebre'],
            ['name' => 'Antibióticos', 'description' => 'Tratan infecciones bacterianas'],
            ['name' => 'Antiinflamatorios', 'description' => 'Reducen la inflamación'],
            ['name' => 'Antialérgicos', 'description' => 'Controlan las reacciones alérgicas'],
            ['name' => 'Antigripales', 'description' => 'Alivian los síntomas del resfrío'],
            ['name' => 'Gastrointestinales', 'description' => 'Problemas digestivos'],
            ['name' => 'Vitaminas', 'description' => 'Vitaminas y suplementos'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
