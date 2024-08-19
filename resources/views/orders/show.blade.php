@extends('layouts.master')

@section('pageTitle')
    تفاصيل الطلب
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="text-end">تفاصيل الطلب #{{ $order->id }}</h3>
            </div>
            <div class="card-body ">
                <div class="row mb-4 bg-gray-200 border-radius-2xl p-2 ">
                    <div class="col-md-6 ">
                        <h5 class="card-title">معلومات المكتب</h5>
                        <p><strong>المكتب المرسل:</strong> {{ $order->fromOffice->city }} / {{ $order->fromOffice->address }}</p>
                        <p><strong>المكتب المستلم:</strong> {{ $order->toOffice->city }} / {{ $order->toOffice->address }}</p>
                    </div>
                    <div class="col-md-6 ">
                        <h5 class="card-title ">معلومات الدفع</h5>
                        <p><strong>طريقة الدفع:</strong> {{ $order->payment_method }}</p>
                        <p><strong>نوع الدفع:</strong> {{ $order->payment_type }}</p>
                        <p><strong>حالة الطلب:</strong> {{ $order->status }}</p>
                        <p><strong>السعر الكلي:</strong> {{ $order->total_price }}</p>
                        <p><strong>تاريخ الإنشاء:</strong> {{ $order->created_at->format('Y-m-d') }}</p>
                    </div>
                </div>

                <div class="row mb-4 bg-gray-200 border-radius-2xl p-2">
                    <div class="col-md-6">
                        <h5 class="card-title">تفاصيل المرسل</h5>
                        <p><strong>اسم المرسل:</strong> {{ $order->order_details->S_user }}</p>
                        <p><strong>الرقم الوطني للمرسل:</strong> {{ $order->order_details->S_national_id }}</p>
                        <p><strong>رقم هاتف المرسل:</strong> {{ $order->order_details->S_phone_number }}</p>
                        <p><strong>اسم والدة المرسل:</strong> {{ $order->order_details->S_mother_name }}</p>
                        <p><strong>موقع المرسل:</strong> {{ $order->order_details->S_Location }}</p>
                        <p><strong>تسجيل العائلة للمرسل:</strong> {{ $order->order_details->S_family_registration }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="card-title">تفاصيل المستلم</h5>
                        <p><strong>اسم المستلم:</strong> {{ $order->order_details->R_user }}</p>
                        <p><strong>رقم هاتف المستلم:</strong> {{ $order->order_details->R_phone_number }}</p>
                    </div>
                </div>

                <h5 class="card-title">البضائع الواردة</h5>
                <ul class="list-group mb-4">
                    @foreach($filteredGoods as $goods)
                        <li class="list-group-item">
                            <p><strong>اسم البضاعة:</strong> {{ $goods->good_name }}</p>
                            <p><strong>الكمية:</strong> {{ $goods->quantity }}</p>
                            <p><strong>الوزن:</strong> {{ $goods->weight }}</p>
                            <p><strong>الحجم:</strong> {{ $goods->volume }}</p>
                        </li>
                    @endforeach
                </ul>

                <h5 class="card-title">الفواتير</h5>
                <ul class="list-group mb-4">
                    @foreach($order->invoices as $invoice)
                        <li class="list-group-item">
                            <p><strong>رقم الفاتورة:</strong> {{ $invoice->id }}</p>
                            <p><strong>حالة الفاتورة:</strong> {{ $invoice->status }}</p>
                            <p><strong>قيمة الفاتورة:</strong> {{ $invoice->value }}</p>
                            <p><strong>طريقة الدفع:</strong> {{ $invoice->payment_method }}</p>
                        </li>
                    @endforeach
                </ul>

                <div class="">
                    <a href="{{ route('orders.index') }}" class="btn btn-primary">العودة إلى القائمة</a>
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning">تحديث الطلب</a>

                    @if($order->status === 'جاري المعالجة' && !auth()->user()->hasRole('superAdmin') && $order->to_office_id == auth()->user()->employee->office_id)
                        <!-- Show the 'تسليم' button if the order status is 'جاري المعالجة' -->
                        <a href="{{ route('order.delivery', $order->id) }}" class="btn btn-success">تسليم</a>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
