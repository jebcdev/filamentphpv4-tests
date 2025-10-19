<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MoneyMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = \App\Models\User::pluck('id')->toArray();

        for ($day = 1; $day <= 10; $day++) {
            // Ingreso diario
            \App\Models\MoneyMovement::create([
                'user_id' => fake()->randomElement($userIds),
                'movement_date' => Carbon::create(2025, 10, $day),
                'description' => 'Ingreso diario día ' . $day,
                'amount' => 2000,
                'type' => 'income'
            ]);

            // Egreso diario
            \App\Models\MoneyMovement::create([
                'user_id' => fake()->randomElement($userIds),
                'movement_date' => Carbon::create(2025, 10, $day),
                'description' => 'Egreso diario día ' . $day,
                'amount' => 1000,
                'type' => 'expense'
            ]);
        }
    }
}
