<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Truck;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TruckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drivers = Driver::all();

        // Ensure there are drivers in the system


        $faker = Factory::create();

        // Create a truck for each driver
        foreach ($drivers as $driver) {
            Truck::create([
                'plate_number' => strtoupper($faker->bothify('??####')), // Random plate number
                'driver_id' => $driver->id, // Assign each truck to a unique driver
                'type' => $faker->randomElement(['cargo', 'tanker', 'flatbed', 'dump']),
                'capacity' => $faker->numberBetween(5000, 20000), // Capacity in kg
            ]);
        }
    }
}
