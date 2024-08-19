<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Requests\order\OrderRequest;
use App\Http\Requests\order\UpdateOrderRequest;
use App\Models\Employee;
use App\Models\Incoming_good;
use App\Models\Office;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Trips;
use App\Models\User;
use App\Models\VariableValue;
use App\Models\Wallet;
use App\Models\Warehouse;
use App\Services\GoodsService;
use App\Services\InvoiceService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    protected $orderService;
    protected $goodsService;
    protected $invoiceService;


    public function __construct(OrderService $orderService, GoodsService $goodsService, InvoiceService $invoiceService)
    {

        $this->orderService = $orderService;
        $this->goodsService = $goodsService;
        $this->invoiceService = $invoiceService;

    }

    public function index(Request $request)
    {
        $query = Order::with('order_details');

        // Check if there is a search query
        if ($request->has('order_number')) {
            $query->where('id', $request->order_number);
        }

        // Add status filter if it's provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->get();

        return view('orders.index', compact('orders'));
    }


    public function create()
    {
        $orderDetails = Order_detail::select('S_national_id',
            DB::raw('MAX(S_user) as S_user'),
            DB::raw('MAX(S_phone_number) as S_phone_number'),
            DB::raw('MAX(S_mother_name) as S_mother_name'),
            DB::raw('MAX(S_Location) as S_Location'),
            DB::raw('MAX(S_family_registration) as S_family_registration'))
            ->groupBy('S_national_id')
            ->get();
        $offices=Office::all();
        // Fetch necessary data for creating an order (e.g., office lists)
        return view('orders.create',compact('orderDetails','offices'));
    }

    public function store(OrderRequest $request)
    {

        try {
            $userId = Auth::id();
            $employeeId = Employee::where('user_id', $userId)->first()->id;
            $warehouse_id = Warehouse::where('office_id', $request->from_office_id)->first()->id;
            $roles = auth()->user()->getRoleNames()->first();

            $orderData = $request->only(['from_office_id', 'to_office_id', 'payment_method', 'payment_type']);
            $orderData['user_id'] = $roles === 'client' ? $userId : null;
            $orderData['employee_id'] = $roles !== 'client' ? $employeeId : null;
            $orderData['status'] ='جاري المعالجة';

            $order = $this->orderService->createOrder($orderData);

            $orderDetailsData = $request->only([
                'S_user', 'S_national_id', 'S_phone_number', 'S_mother_name',
                'S_Location', 'S_family_registration', 'R_user', 'R_phone_number'
            ]);
            $orderDetailsData['order_id'] = $order->id;
            $orderDetails = $this->orderService->createOrderDetails($orderDetailsData);

            $goodsList = $request->input('incoming_goods', []);
            $processedGoods = $this->goodsService->processIncomingGoods($goodsList, $order, $warehouse_id);

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
            if($order->payment_type =='prepaid'){
                $superAdmin=User::role("superAdmin")->first();
                $wallet=$superAdmin->wallet;
                if($wallet){
                    $superAdmin->wallet->update(['balance'=>$order->total_price +$superAdmin->wallet->balance]);
                }else{
                    Wallet::create(['user_id'=>$superAdmin->id,'balance'=>$order->total_price]);
                }

            }
            Session::flash('success', 'تم تسليم الطلب بنجاح!');
            return redirect()->route('orders.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            Session::flash('error', 'فشل انشاء الطلب' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        try {
            $order = Order::findOrFail($id);
            $order->update(['status' => $request->status]);

            Session::flash('success', 'تم تحديث حالة الطلب بنجاح');
        } catch (\Exception $e) {
            Session::flash('error', 'فشل في تحديث حالة الطلب: ' . $e->getMessage());
        }

        return redirect()->route('orders.index');
    }

    public function show($id)
    {
        $order = Order::with(['order_details', 'incomingGoods', 'invoices'])->findOrFail($id);

        $filteredGoods = $order->incomingGoods->unique(function ($item) {
            return $item['good_name'] . $item['quantity'] . $item['weight'] . $item['volume'];
        });   // Filter incoming goods to remove duplicates based on 'good_name', 'quantity', 'weight', and 'volume'


        return view('orders.show', compact('order', 'filteredGoods'));
    }


    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $offices = Office::all(); // Assuming you have an Office model for offices
        $orderDetails = Order_detail::select('S_national_id',
            DB::raw('MAX(S_user) as S_user'),
            DB::raw('MAX(S_phone_number) as S_phone_number'),
            DB::raw('MAX(S_mother_name) as S_mother_name'),
            DB::raw('MAX(S_Location) as S_Location'),
            DB::raw('MAX(S_family_registration) as S_family_registration'))
            ->groupBy('S_national_id')
            ->get();
        $filteredGoods = $order->incomingGoods->unique(function ($item) {
            return $item['good_name'] . $item['quantity'] . $item['weight'] . $item['volume'];
        });
        return view('orders.edit', compact('order', 'offices', 'orderDetails','filteredGoods'));
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        $user = Auth::user();
        $order = Order::findOrFail($id);

//        if ($user->id != $order->user_id) {
//            Session::flash('error', 'You are not authorized to update the order');
//            return redirect()->route('orders.index');
//        }

        if ($order->status == 'Under fetch') {
            Session::flash('error', 'The order cannot be modified after receipt');
            return redirect()->route('orders.index');
        }
//dd($order);
        $updateData = array_filter($request->only([
            'customer_id', 'from_office_id', 'to_office_id', 'payment_method', 'payment_type'
        ]), function ($value) {
            return $value !== null;
        });

        $order->update($updateData);
        $warehouse_id = Warehouse::where('office_id', $order->from_office_id)->first()->id;

        $orderDetailsData = array_filter($request->only([
            'S_user', 'S_national_id', 'S_phone_number', 'S_family_registration',
            'S_mother_name', 'S_Location', 'R_user', 'R_phone_number'
        ]), function ($value) {
            return $value !== null;
        });

        if (!empty($orderDetailsData)) {
            $order->order_details->update($orderDetailsData);
        }

        if ($request->has('incoming_goods')) {
            $goodsList = $request->input('incoming_goods');
            $order->incomingGoods()->delete();
            $processedGoods = $this->goodsService->processIncomingGoods($goodsList, $order, $warehouse_id);
        }

        Session::flash('success', 'Order updated successfully');
        return redirect()->route('orders.index');
    }

    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();

            Session::flash('success', 'Order deleted successfully');
            return redirect()->route('orders.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to delete order: ' . $e->getMessage());
            return redirect()->route('orders.index');
        }
    }
    public function delivery(Order $order)
    {
        // Check if the order's status is 'جاري المعالجة'
        if ($order->status === 'جاري المعالجة') {
            // Update the status to 'مكتمل'
            $order->status = 'مكتمل';
            if($order->payment_type =='postpaid'){
                $superAdmin=User::role("superAdmin")->first();
                $superAdmin->wallet->update(['balance'=>$order->total_price +$superAdmin->wallet->balance]);
            }
            $order->save();
            return redirect()->route('orders.index', $order->id)->with('success', 'تم تسليم الطلب بنجاح!');
        }
        return redirect()->route('orders.show', $order->id)->with('error', 'لا يمكن تسليم هذا الطلب.');
    }


    public function calculatePrice(Request $request)
    {
        $quantity = $request->query('quantity');
        $weight = $request->query('weight');
        $fromOfficeId = $request->query('from_office_id');
        $toOfficeId = $request->query('to_office_id');
        $pricePerKm = VariableValue::where('key', "PricePerKm")->where('weight', $weight)->first()->value;

        // Get the distance between the two offices
        // Get the distance between the two offices in either direction
        $distancePerKm = Trips::where(function($query) use ($fromOfficeId, $toOfficeId) {
            $query->where('from_office_id', $fromOfficeId)
                ->where('to_office_id', $toOfficeId);
        })->orWhere(function($query) use ($fromOfficeId, $toOfficeId) {
            $query->where('from_office_id', $toOfficeId)
                ->where('to_office_id', $fromOfficeId);
        })->pluck('distancePerKm')->first();

        // Calculate distance price
        $distancePrice = $pricePerKm * $distancePerKm;

        // Calculate total price
        $totalPrice = $quantity * $distancePrice;

        return response()->json(['price' => $totalPrice]);
    }
}
