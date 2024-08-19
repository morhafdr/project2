<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\DeliveryService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    protected $deliveryService;

    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }


    public function updateOnlineStatus()
    {
        try {
            // Retrieve the authenticated user
            $delivery = Auth::user();

            // Toggle the online status using the service
            $newStatus = $this->deliveryService->toggleOnlineStatus($delivery);
            return response()->json([
                'message' => 'Online status updated successfully.',
                'is_online' => $newStatus
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }


//    public function SetDeliveryOrder($orderId)
//    {
//            $order = $this->deliveryService->assignOrderToDelivery($orderId);
//            return $order;
//
//    }

    public function OrderLocation($id)
    {
            $location = $this->deliveryService->OrderLocation($id);
            return $location;
    }

    public function updateOrderState($id)
    {
        $state = $this->deliveryService->OrderState($id);
        return $state;
    }
}
