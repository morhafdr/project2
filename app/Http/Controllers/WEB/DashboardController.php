<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Office;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        $data=[];
        $data['office']=Office::count();
        $data['truck']=Truck::count();
        $data['employee']=Employee::count();
        $data['appClient']= User::role('client')->count();
        return view('dashboard',compact('data'));
    }
    public function getDashboardData()
    {
        $data = [
            'office' => Office::count(),
            'truck' => Truck::count(),
            'employee' => Employee::count(),
            'appClient' => User::role('client')->count(),
        ];

        return response()->json($data);
    }
}
