<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\NotificationService;

class CheckUnpaidOrders extends Command
{
    protected $signature = 'orders:check-unpaid';
    protected $description = 'Check for unpaid orders and send notification if not paid within 2 minutes.';

    protected $notificationService;

    // Inject the NotificationService in the constructor
    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    public function handle()
    {
        // Get current time minus two minutes
        $twoMinutesAgo = Carbon::now()->subMinutes(1);
        // Find all orders that are not paid and older than 2 minutes
        $unpaidOrders = Order::where('created_at', '<=', $twoMinutesAgo)
            ->get();
        foreach ($unpaidOrders as $order) {
            $user = $order->user;

            // Use NotificationService to send the notification
            $title = 'Payment Reminder';
            $message = "Your order #{$order->id} is pending. Please complete the payment.";
            $result = $this->notificationService->send($user, $title, $message, 'unpaid_order');

            if ($result ===  1) {
                // Log success
                Log::info("Notification sent to user {$user->id} for unpaid order {$order->id}.");
            } else {
                // Log failure
                Log::error("Failed to send notification to user {$user->id} for unpaid order {$order->id}: {$result['message']}");
            }
        }
        return Command::SUCCESS;
    }
}
