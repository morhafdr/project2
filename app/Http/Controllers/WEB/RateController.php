<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'office_id' => 'required|exists:offices,id',
            'rate' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $rate = Rate::updateOrCreate([
            'user_id'   => Auth::id(),
            'office_id' => $request['office_id'],
        ],[
            'user_id'=>Auth::id(),
            'office_id' => $request['office_id'],
                'rate' => $request['rate'],
            'comment' => $request['comment']
        ]);


        return redirect()->route('offices.show', ['office' => $rate->office_id])->with('success', 'تم إرسال التقييم بنجاح.');
    }
}
