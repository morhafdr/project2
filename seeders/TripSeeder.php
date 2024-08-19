<?php

namespace Database\Seeders;

use App\Models\Office;
use App\Models\Trips;
use App\Models\Truck;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $truck=Truck::where('id',1)->first();
        $fromOffice=Office::where('id',1)->first();
        $toOffice=Office::where('id',2)->first();
        Trips::create([
            'truck_id' => $truck->id,
            'from_office_id' => $fromOffice->id,
            'to_office_id' => $toOffice->id,
            'distancePerKm' => $faker->numberBetween(50, 1000), // Random distance in km
            'status' => $faker->randomElement(['جاهز', 'مرسل', 'مستلم']), // Random trip status
        ]);

        $truck2=Truck::where('id',2)->first();
        $fromOffice2=Office::where('id',1)->first();
        $toOffice2=Office::where('id',10)->first();
        Trips::create([
            'truck_id' => $truck2->id,
            'from_office_id' => $fromOffice2->id,
            'to_office_id' => $toOffice2->id,
            'distancePerKm' => $faker->numberBetween(50, 1000), // Random distance in km
            'status' => $faker->randomElement(['جاهز', 'مرسل', 'مستلم']), // Random trip status
        ]);
    }
}
