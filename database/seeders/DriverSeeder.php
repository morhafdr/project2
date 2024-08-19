<?php

namespace Database\Seeders;

use App\Models\Driver;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Driver::query()->delete();
        $faker = Factory::create('ar_SA');

        for ($i = 0; $i < 10; $i++) {
            Driver::create([
                'name' => $faker->name,
                'national_id' => $faker->numerify('##########'),
                'driver_license_number' => 'DL' . $faker->numerify('######'),
                'phone' => $faker->phoneNumber,
                'join_date' => $faker->date,
                'status' => $faker->randomElement(['active','none_active']),
            ]);
        }
    }
}
