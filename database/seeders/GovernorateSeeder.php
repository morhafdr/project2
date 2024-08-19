<?php

namespace Database\Seeders;

use App\Models\Governorate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Governorate::query()->delete();
        $provinces = [
            "دمشق",
            "ريف دمشق",
            "حلب",
            "حمص",
            "حماة",
            "اللاذقية",
            "ادلب",
            "درعا",
            "القنيطرة",
            "السويداء",
            "الحسكة",
            "الرقة",
            "دير الزور"
        ];
        foreach ($provinces as $province){
            Governorate::create(['name'=>$province]);
        }


    }
}
