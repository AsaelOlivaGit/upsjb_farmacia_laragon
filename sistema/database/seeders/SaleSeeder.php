<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Medicine;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * 60 ventas al azar de los últimos 90 días.
     * Usa las mismas reglas de SaleController@store: el precio sale de la tabla,
     * se descuenta el stock y el IGV se separa del total (total * 18 / 118).
     */
    public function run(): void
    {
        $customers = Customer::all();
        $users = User::all();

        for ($i = 0; $i < 60; $i++) {
            $medicines = Medicine::where('stock', '>', 0)->get();

            if ($medicines->isEmpty()) {
                break;
            }

            $sale = Sale::create([
                'customer_id' => $customers->random()->id,
                'user_id' => $users->random()->id,
                'date' => now()->subDays(fake()->numberBetween(0, 90))
                    ->setTime(fake()->numberBetween(8, 20), fake()->numberBetween(0, 59)),
                'total' => 0,
                'igv' => 0,
            ]);

            $total = 0;

            // de 1 a 4 medicamentos distintos por venta
            foreach ($medicines->random(min(fake()->numberBetween(1, 4), $medicines->count())) as $medicine) {
                $amount = min(fake()->numberBetween(1, 6), $medicine->stock);
                $subtotal = $medicine->price * $amount;

                $sale->details()->create([
                    'medicine_id' => $medicine->id,
                    'amount' => $amount,
                    'price_unit' => $medicine->price,
                    'subtotal' => $subtotal,
                ]);

                $medicine->decrement('stock', $amount);

                $total += $subtotal;
            }

            $sale->update([
                'total' => $total,
                'igv' => round($total * 18 / 118, 2),
            ]);
        }
    }
}
