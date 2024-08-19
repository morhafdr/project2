<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Method to display the deposit form
    public function showDepositForm()
    {
        return view('chargeAccount.chargeAccount');
    }

    // Method to handle deposit request
    public function deposit(Request $request, $email)
    {
        $user = User::where('email', $email)->first(); // Ensure the user exists
        if (!$user) {
            return redirect()->back()->with('error', 'المستخدم غير موجود');
        }

        $wallet = $user->wallet;

        if (!$wallet) {
            // Optionally create a wallet if it doesn't exist
            $wallet = new Wallet(['user_id' => $user->id]);
            $user->wallet()->save($wallet);
        }

        $amount = $request->input('amount');
        if ($amount <= 0) {
            return redirect()->back()->with('error', 'المبلغ غير مقبول');
        }

        $wallet->deposit($amount);

        return redirect()->back()->with('success', 'تم ايداع مبلغ بقيمة: ' . $wallet->balance);
    }

    // Method to display the withdraw form

    }
