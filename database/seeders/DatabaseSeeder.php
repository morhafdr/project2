<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VariableValue;

class
DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = [
            ['key' => 'access_token', 'value' => '2|LoS7aBrt0GzHyOpHLZAWnMsWDyVhbpkfFFcC8N8k'],
            ['key' => 'session_id', 'value' => '35ab8743-1a7f-47ae-9684-7f22afe917b0'],
            ['key' => 'PricePerKm', 'value' => '2','weight'=>'under_5'],
            ['key' => 'PricePerKm', 'value' => '4','weight'=>'under_20'],
            ['key' => 'PricePerKm', 'value' => '5','weight'=>'under_40'],
            ['key' => 'PricePerKm', 'value' => '6','weight'=>'under_60'],
        ];
        // Insert each key-value pair into the database
        foreach ($data as $item) {
            VariableValue::create($item);
        }
    $this->call([
        GovernorateSeeder::class,
        OfficeSeeder::class,
        RolesPermissionsSeeder::class,
        DriverSeeder::class,
        EmployeeSeeder::class,
        TruckSeeder::class,
        TripSeeder::class,
    ]);
    }
}
