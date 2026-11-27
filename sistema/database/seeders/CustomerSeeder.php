<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = fake('es_PE');

        for ($i = 0; $i < 25; $i++) {
            Customer::create([
                'name' => $faker->firstName() . ' ' . $faker->lastName() . ' ' . $faker->lastName(),
                'dni' => $faker->unique()->numerify('########'),
                'phone' => $faker->numerify('9########'),
                'age' => $faker->numberBetween(18, 80),
            ]);
        }
    }
}
