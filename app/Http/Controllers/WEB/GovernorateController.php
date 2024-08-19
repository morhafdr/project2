<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Governorate;

class GovernorateController extends Controller
{
    public function getDovernorates(){
        $governorates = Governorate::all();
        return response()->json($governorates);
    }

    public function governorates(){
        $governorates = Governorate::all();
        return response()->json(['data' => $governorates]);
    }

}
