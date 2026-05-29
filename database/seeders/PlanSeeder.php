<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insertar el Plan Mensual estándar de la UI
        Plan::create([
            'name' => 'Iron Mensual',
            'price' => 25.00,
            'duration_days' => 30,
        ]);

        // Insertar el Plan Trimestral con descuento de la UI
        Plan::create([
            'name' => 'Iron Trimestral',
            'price' => 60.00,
            'duration_days' => 90,
        ]);
    }
}