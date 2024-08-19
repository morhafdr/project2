<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Wallet;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;

class PaymentService
{

    protected $notifictionService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notifictionService = $notificationService;

    }
    public function handlePrePaidPayment($request)
    {
        $user= Auth::user();
        $order = Order::where('id', $request->order_id)->first();
        if(!$order){
            return response()->json(['message' => 'order not found'], 404);
        }
        $wallet = Wallet::where('user_id', $user->id)->first();
        if (!$wallet || $wallet->balance < $order->total_price) {
            return response()->json(['message' => 'Insufficient wallet or balance for pre-paid payment'], 404);
        }

        // Deduct wallet balance
        $wallet->balance -= $order->total_price;
        $wallet->save();
        // Update order and invoice status
        $order->Invoices()->update(['status' => 'Completed']);
        // Send notification
        $title = "Payment Successful";
        $message = "Your payment was successful. Your current wallet balance is $wallet->balance.";
        $this->notifictionService->send($user, $title, $message);

        return response()->json(['message' => 'Payment processed successfully.', 'current_balance' => $wallet->balance], 200);
    }

    /**
     * Handle post-paid payment.
     * Update order status to indicate it is pending payment.
     *
     * @param Order $order
     */
    public function handlePostPaidPayment(Order $order)
    {
        // Update order status to indicate it's awaiting payment
        $order->update(['status' => 'Pending Payment']);
    }
















}
