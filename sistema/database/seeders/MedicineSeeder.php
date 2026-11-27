<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        // categoría => [nombre, precio, stock]
        $medicines = [
            'Analgésicos' => [
                ['Paracetamol 500 mg', 0.50, 400],
                ['Panadol 500 mg', 2.50, 250],
                ['Metamizol 1 g', 1.20, 180],
                ['Aspirina 100 mg', 0.80, 8],
            ],
            'Antibióticos' => [
                ['Amoxicilina 500 mg', 1.50, 200],
                ['Azitromicina 500 mg', 4.50, 120],
                ['Ciprofloxacino 500 mg', 2.00, 6],
                ['Cefalexina 500 mg', 1.80, 150],
            ],
            'Antiinflamatorios' => [
                ['Ibuprofeno 400 mg', 0.70, 300],
                ['Naproxeno 550 mg', 1.10, 220],
                ['Diclofenaco 50 mg', 0.60, 9],
            ],
            'Antialérgicos' => [
                ['Loratadina 10 mg', 0.90, 260],
                ['Cetirizina 10 mg', 1.00, 190],
                ['Clorfenamina 4 mg', 0.40, 140],
            ],
            'Antigripales' => [
                ['Panadol Antigripal', 3.50, 160],
                ['Nastizol Compositum', 2.80, 130],
                ['Jarabe para la tos 120 ml', 14.50, 45],
            ],
            'Gastrointestinales' => [
                ['Omeprazol 20 mg', 0.80, 280],
                ['Sal de Andrews', 1.50, 150],
                ['Suero oral 500 ml', 5.50, 70],
            ],
            'Vitaminas' => [
                ['Vitamina C 1 g efervescente', 1.20, 210],
                ['Complejo B', 0.50, 240],
                ['Sulfato ferroso 300 mg', 0.30, 7],
            ],
        ];

        $categories = Category::pluck('id', 'name');

        foreach ($medicines as $category => $items) {
            foreach ($items as [$name, $price, $stock]) {
                Medicine::create([
                    'category_id' => $categories[$category],
                    'name' => $name,
                    'price' => $price,
                    'stock' => $stock,
                ]);
            }
        }
    }
}
