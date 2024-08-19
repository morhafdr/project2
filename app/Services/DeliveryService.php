<?php

namespace App\Services;

use App\Models\DeliveryOrder;
use App\Models\Employee;
use App\Models\Office;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeliveryService
{
    protected $notifictionService;
    protected $goodservice;

    public function __construct(NotificationService $notificationService ,GoodsService $goodsService )
    {
        $this->notifictionService = $notificationService;
        $this->goodservice = $goodsService;

    }
    public function toggleOnlineStatus(User $delivery)
    {
        if ($delivery->hasRole('delivery')) {
            // Toggle the online status
            $delivery->is_online = !$delivery->is_online;
            $delivery->save();

            $status = $delivery->is_online ? 'online' : 'offline';
            $title = 'Status Update';
            $message = "Your status has been updated to: $status.";

            // Send the notification
            $this->notifictionService->send($delivery, $title, $message);
            return $delivery->is_online;
        }
        throw new \Exception('Unauthorized action.');
    }


    function assignOrderToDelivery($orderId)
    {
        // Retrieve the order that needs to be assigned
        $order = Order::find($orderId);

        if (!$order) {
            return "Order not found.";
        }

        // Fetch available employees in the same office who have the "delivery" role through the user
        $availableEmployees = Employee::where('office_id', $order->from_office_id)
            ->delivery()
            ->get();

        if ($availableEmployees->isEmpty()) {
            return "No available employees.";
        }

        // Find employees who do not have any 'not_received' orders yet
        $employeesWithNoOrders = $availableEmployees->reject(function ($employee) {
            return DeliveryOrder::where('employee_id', $employee->id)
                ->where('status', 'not_received')
                ->exists();
        });

        if ($employeesWithNoOrders->isNotEmpty()) {
            // Prefer assigning to employees with no orders at all
            $employeeId = $employeesWithNoOrders->first()->id;
        } else {
            // If all available employees have some orders, find the one with the least
            $employeeId = DeliveryOrder::select('employee_id')
                ->whereIn('employee_id', $availableEmployees->pluck('id'))
                ->where('status', 'not_received')
                ->groupBy('employee_id')
                ->orderByRaw('COUNT(*) ASC')
                ->first()
                ->employee_id;
        }
        // Create a new delivery order
        $deliveryOrder = new DeliveryOrder([
            'order_id' => $orderId,
            'employee_id' => $employeeId,
            'status' => 'not_received',
        ]);
        $deliveryOrder->save();
        $employee = Employee::find($employeeId);
        if ($employee) {
            $this->notifictionService->send($employee->user, 'Order Assignment', "You have a new order (Order ID: $orderId).");
        }

        return $employeeId;
    }

    public function OrderLocation($id)
    {
        $order = Order_detail::where('order_id', $id)->select('latitude', 'longitude')->first();
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }
        return $order;
    }


    public function OrderState($id)
    {
        $user = Auth::user();

        // Check if the user has the 'delivery' role
        if (!$user->hasRole('delivery')) {
            abort(403, "Unauthorized access - User does not have the required role.");
        }

        $employeeId = $user->employee->id;
        $deliveryOrder = DeliveryOrder::where('employee_id', $employeeId)->where('order_id', $id)->first();


        if ($deliveryOrder) {

            $deliveryOrder->update([
                'status' => 'received'
            ]);
            // Now, update the order status in the Order table
            $order = Order::find($id);
            if ($order) {
                $order->update([
                    'status' => 'جاري المعالجة' // Update the status to 'received'
                ]);
                $this->notifictionService->send($order->user, 'Delivery is Coming to Pick Up Your Item', "a delivery agent is on the way");
                $goods =   $order->incomingGoods;
             foreach($goods as $good) {
                 $this->goodservice->createCargoManifest($good, $order);
             }
            }
            return response()->json(['message' => 'Order and delivery statuses updated to received.']);
        }
        // Optional: Handle the case where permissions exist and no update is needed
        return response()->json(['message' => 'No updates performed.']);
    }
}
