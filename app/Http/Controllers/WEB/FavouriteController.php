<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Favourite;
use App\Models\Office;

class FavouriteController extends Controller
{

    public function add($officeId)
    {
        $user = Auth::user();
        $office = Office::find($officeId);
        if ($office == null) {
            return response()->json(['message' => 'Office not found'], 404);
        }

        if ($user->favourites()->where('office_id', $office->id)->exists()) {
            $user->favourites()->detach($office->id);
            return response()->json([
                'status' => false ,
                'message' => 'Office removed from favourites'], 200);
        }
        $user->favourites()->attach($office->id);
        return response()->json(
            [
                'status' => true ,
                'message' => 'Office added to favourites'
            ], 200);
    }
    public function index()
    {
        $user = Auth::user();
        $favourites = $user->favourites()->get();

        return response()->json(['data' => $favourites], 200);
    }
}
