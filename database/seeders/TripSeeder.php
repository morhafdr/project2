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
            'distancePerKm' => 40, // Random distance in km
            'status' => 'جاهز', // Random trip status
        ]);

        $truck2=Truck::where('id',2)->first();
        $fromOffice2=Office::where('id',1)->first();
        $toOffice2=Office::where('id',10)->first();
        Trips::create([
            'truck_id' => $truck2->id,
            'from_office_id' => $fromOffice2->id,
            'to_office_id' => $toOffice2->id,
            'distancePerKm' => 90, // Random distance in km
            'status' => 'جاهز', // Random trip status
        ]);
        $truck3=Truck::where('id',3)->first();
        $fromOffice3=Office::where('id',1)->first();
        $toOffice3=Office::where('id',3)->first();
        Trips::create([
            'truck_id' => $truck3->id,
            'from_office_id' => $fromOffice3->id,
            'to_office_id' => $toOffice3->id,
            'distancePerKm' => 90, // Random distance in km
            'status' => 'جاهز', // Random trip status
        ]);
        $truck4=Truck::where('id',4)->first();
        $fromOffice4=Office::where('id',1)->first();
        $toOffice4=Office::where('id',4)->first();
        Trips::create([
            'truck_id' => $truck4->id,
            'from_office_id' => $fromOffice4->id,
            'to_office_id' => $toOffice4->id,
            'distancePerKm' => 50, // Random distance in km
            'status' => 'جاهز', // Random trip status
        ]);
    }
}
