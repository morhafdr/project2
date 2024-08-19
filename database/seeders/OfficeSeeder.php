<?php

namespace Database\Seeders;

use App\Models\Governorate;
use App\Models\Office;
use App\Models\Warehouse;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Office::query()->delete();
        $faker = Factory::create('ar_SA');

        $governorates = Governorate::all();
        $cities = [
            "البرامكة",
            "جرمانا",
            "عين العرب",
            "حمص",
            "السلمية",
            "جبلا",
            "ادلب",
            "البصرى",
            "القنيطرة",
            "شهبا",
            "الحسكة",
            "الرقة",
            "دير الزور"
        ];
        $i=0;
        foreach ($governorates as $governorate) {
           $office = Office::create([
                'governorate_id' => $governorate->id,
                'address' => $faker->address,
                'city'=>$cities[$i],
               'longitude'=>'36.6247902',
               'latitude'=>'32.8680101',
                'phone' => $faker->phoneNumber,
            ]);
            $office->wareHouse()->create([
                'address' => $faker->address,
            ]);
            $i++;
        }
    }
}
