<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{


    protected  $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    public function deposit(Request $request, $userId)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }
        $user = User::findOrFail($userId);
        $wallet = $user->wallet ?: $user->wallet()->create(['user_id' => $userId, 'balance' => 0]);
        $wallet->deposit($request->input('amount'));
        return response()->json(['message' => 'Deposit successful', 'balance' => $wallet->balance]);
    }
    public function withdraw(Request $request)
       {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        $userWallet = Auth::user()->wallet;
        $adminWallet = User::where('is_admin', true)->first()->wallet;

        DB::transaction(function () use ($userWallet, $adminWallet, $request) {
            $userWallet->withdraw($request->input('amount'));
            $adminWallet->deposit($request->input('amount'));
        });
        return response()->json(['message' => 'Withdrawal and deposit successful']);
       }

    public function payment(Request $request)
    {
        $res = $this->paymentService->handlePrePaidPayment($request);
        return $res;
    }
}
