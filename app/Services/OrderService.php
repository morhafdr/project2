<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    protected $goodsService;
    protected $invoiceService;
    protected $verifyService;
    protected $deliveryService;


    public function __construct(GoodsService $goodsService, InvoiceService $invoiceService , VerificationService $verifyService,DeliveryService $deliveryService)
    {
        $this->goodsService = $goodsService;
        $this->invoiceService = $invoiceService;
        $this->verifyService = $verifyService;
        $this->deliveryService = $deliveryService;
    }


    public function createOrderWithDetails($request)
    {
        try {
            $userId = Auth::id();

            $employeeId = optional(Employee::where('user_id', $userId)->first())->id;

            $warehouseId = Warehouse::where('office_id', $request->from_office_id)->first()->id;

            $roles = Auth::user()->getRoleNames()->first();

            $orderData = $request->only(['from_office_id', 'to_office_id', 'payment_method', 'payment_type']);

            $orderData['user_id'] = $roles === 'client' ? $userId : null;

            $orderData['employee_id'] = $roles !== 'client' ? $employeeId : null;

            $orderData['status'] = $roles == 'client' ? 'قيد الجلب' : 'جاري المعالجة';

            // Create the order
            $order = $this->createOrder($orderData);

            // Prepare and create order details
            $orderDetailsData = $request->only([
                'S_user', 'S_national_id', 'S_phone_number', 'S_mother_name',
                'S_family_registration', 'R_user', 'R_phone_number',   'longitude',
                'latitude'
            ]);
            $orderDetailsData['order_id'] = $order->id;
            $orderDetails = $this->createOrderDetails($orderDetailsData);

            $goodsList = $request->input('incoming_goods', []);
            $processedGoods = $this->goodsService->processIncomingGoods($goodsList, $order, $warehouseId);

            $invoiceData = [
                'order_id' => $order->id,
                'status' => 'Pending',
                'value' => $processedGoods['totalPrice'],
                'payment_method' => $order->payment_method,
                'office_id' => $request->from_office_id,
            ];
            $invoice = $this->invoiceService->createInvoice($invoiceData);

            $order->update([
                'total_price' => $processedGoods['totalPrice'],
            ]);
            $this->deliveryService->assignOrderToDelivery($order->id);
//            $this->verifyService->sendOtp($orderDetailsData['R_phone_number']);
            return [
                'order' => $order,
                'orderDetails' => $orderDetails,
                'incomingGoods' => $processedGoods['incomingGoods'],
                'invoice' => $invoice,
            ];
        } catch (\Exception $e) {
            throw new \Exception('Failed to create order or order details: ' . $e->getMessage());
        }
    }

    public function createOrder($data)
    {

        $orderData = [
            'employee_id' => isset($data['employee_id']) ? $data['employee_id'] : null,
            'user_id' => isset($data['user_id']) ? $data['user_id'] : null,
            'from_office_id' => $data['from_office_id'],
            'to_office_id' => $data['to_office_id'],
            'status' => $data['status'],
            'payment_method' => $data['payment_method'],
            'payment_type' => $data['payment_type'],
            'customer_id' => $data['customer_id'] ?? null
        ];
        $order = new Order($orderData);
        $order->save();
        return $order;
    }


    /**
     * Create new order details for a specific order.
     *
     * @param  int $orderId
     * @param  array $details
     * @return \App\Models\Order_detail
     */
    public function createOrderDetails( $details)
    {
       // create
        $orderDetails = new Order_detail($details);
        $orderDetails->save();
        return $orderDetails;
    }

}

