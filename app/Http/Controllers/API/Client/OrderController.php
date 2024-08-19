<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\order\OrderRequest;
use App\Http\Requests\order\UpdateOrderRequest;
use App\Http\Resources\order\OrderResource;
use App\Models\DeliveryOrder;
use App\Models\Employee;
use App\Models\Incoming_good;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\User;
use App\Models\Warehouse;
use App\Services\GoodsService;
use App\Services\InvoiceService;
use App\Services\OrderService;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */

//    protected $orderService;
//    protected $goodsService;
//    protected $invoiceService;
//
//    public function __construct(OrderService $orderService , GoodsService $goodsService , InvoiceService $invoiceService)
//    {
//        $this->orderService = $orderService;
//        $this->goodsService = $goodsService;
//        $this->invoiceService = $invoiceService;
//    }
    public function index()
    {   }

    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(OrderRequest $request)
    {
        try {
            $result = $this->orderService->createOrderWithDetails($request);

            return $this->success($result, 'Order, order details, incoming goods, and invoice created successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Failed to create order or order details', 500, ['error' => $e->getMessage()]);
        }
    }



//    public function store(OrderRequest $request)
//    {
//        try {
//            $userId = auth()->id();
//
//            $employeeId = optional(Employee::where('user_id', $userId)->first())->id;
//
//            $warehouse_id = Warehouse::where('office_id' , $request->from_office_id)->first()->id;
//
//            $roles = auth()->user()->getRoleNames()->first();
//
//            $orderData = $request->only(['from_office_id', 'to_office_id','payment_method', 'payment_type',]);
//
//            $orderData['user_id'] = $roles === 'client' ? $userId : null;
//
//            $orderData['employee_id'] = $roles !== 'client' ? $employeeId : null;
//
//            $orderData['status'] = $roles == 'client' ? 'Under fetch' : 'received';
//
//            // Create the order
//            $order = $this->orderService->createOrder($orderData);
//
//            // Prepare and create order details
//            $orderDetailsData = $request->only([
//                'S_user', 'S_national_id', 'S_phone_number', 'S_mother_name',
//                'S_Location', 'S_family_registration', 'R_user', 'R_phone_number'
//            ]);
//            $orderDetailsData['order_id'] = $order->id;
//            $orderDetails = $this->orderService->createOrderDetails($orderDetailsData);
//
//            $goods = $request->only([
//                'S_user', 'S_national_id', 'S_phone_number', 'S_mother_name',
//                'S_Location', 'S_family_registration', 'R_user', 'R_phone_number'
//            ]);
//            $orderDetailsData['order_id'] = $order->id;
//            $orderDetails = $this->orderService->createOrderDetails($orderDetailsData);
//
//            $goodsList = $request->input('incoming_goods', []);
//            $processedGoods = $this->goodsService->processIncomingGoods($goodsList, $order, $warehouse_id);
//
//
//            $invoiceData = [
//                'order_id' => $order->id,
//                'status' => 'Pending',
//                'value' => $processedGoods['totalPrice'],
//                'payment_method' => $order->payment_method,
//                'office_id' => $request->from_office_id,
//            ];
//            $invoice = $this->invoiceService->createInvoice($invoiceData);
//
//                  $order->update([
//                      'total_price' =>$processedGoods['totalPrice'],
//                  ]);
//            // Success response
//
//            return $this->success([
//                'order' => $order,
//                'orderDetails' => $orderDetails,
//                'incomingGoods' => $processedGoods['incomingGoods'],
//                'invoice' => $invoice
//            ], 'Order, order details, incoming goods, and invoice created successfully', 201);
//        } catch (\Exception $e) {
//
//            // Error response
//            return $this->error('Failed to create order or order details ', 500,
//                ['error' => $e->getMessage()]);
//        }
//    }

    public function showUserOrder()
    {
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        // Check if the user has the 'delivery' role
        if ($user->hasRole('delivery')) {
            // Fetch orders from the DeliveryOrder model where the employee_id matches the user's employee id
            $order = DeliveryOrder::where('employee_id', $user->employee->id)->where('status','not_received')->pluck('order_id');
                $orders = Order::whereIn('id', $order)->get();
        }
        else {
            // Fetch orders from the Order model where the user_id matches the user's id
            $orders = Order::where('user_id', $user->id)->get();
        }

        // Check if orders exist for this user or employee
        if ($orders->isEmpty()) {
            return response()->json(['data' => []], 200); // Return empty array if no orders
        }

        // Return orders
        return response()->json(['data' => $orders], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $justOrder = Order::where('id' , $id)->first();
        $order= Order_detail::where('order_id' , $id)
            ->get();
        $goods= Incoming_good::where('order_id' , $id)
            ->get();
        $data =[];
        $data['order'] = $justOrder;
        $data['order_details']=  $order;
        $data['incomingGoods']=$goods;
        return $data;
    }
    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */


    public function update(UpdateOrderRequest $request, string $id)
    {
        $user = Auth::user();
        $order = Order::findOrFail($id);
        // Check if the current user is authorized to update the order
        if ($user['id'] != $order->user_id) {
            return $this->error('You are not authorized to update the order', 403);
        }
        // Check if the order's status allows for modifications
        if ($order->status != 'Under fetch') {
            return $this->error('The order cannot be modified after receipt', 422);
        }
        // filter request and Updating the order
        $updateData = array_filter($request->only([
            'customer_id', 'from_office_id', 'to_office_id',
            'payment_method', 'payment_type'
        ]), function ($value) {
            return $value !== null;
        });
        // Update the order with the new data
        $order->update($updateData);
        $warehouse_id = Warehouse::where('office_id' , $order->from_office_id)->first()->id;
        // filter request for order details
        $orderDetailsData = array_filter($request->only([
            'S_user', 'S_national_id', 'S_phone_number', 'S_family_registration',
            'S_mother_name', 'S_Location', 'R_user', 'R_phone_number'
        ]), function ($value) {
            return $value !== null;
        });

        // update if not empty
        if (!empty($orderDetailsData)) {
            $order->order_details->update($orderDetailsData);
        }
        // Handling incoming goods, if provided in the request
        if ($request->has('incoming_goods')) {
            $goodsList = $request->input('incoming_goods');

            $order->incomingGoods()->delete();
            $processedGoods = $this->goodsService->processIncomingGoods($goodsList, $order, $warehouse_id);
        }
            // Return a success response with the updated order and related entities
            return $this->success([
                'order' => $order->fresh(),
                'orderDetails' => $order->order_details->fresh() ?? null,
                'incomingGoods' => $processedGoods ?? null  // Include only if updated
            ], 'Order updated successfully', 200);
        }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
        {


        }

}
