@extends('layouts.master')

@section('pageTitle')
    قائمة الطلبات
@endsection
@section('links')
    <style>

        .alert {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            opacity: 0.9;
            transition: opacity 0.5s ease-out; /* Ensure smooth transition */
        }
    </style>
@endsection
@section('scripts')
<script>
    setTimeout(function() {
    var alertBox = document.querySelector('.alert');
    if (alertBox) {
    alertBox.style.opacity = '0';
    setTimeout(function() {
    alertBox.remove();
    }, 500);
    }
    }, 2000);
</script>
@endsection
@section('content')
    <div class="container">
        <h2>قائمة الطلبات</h2>
        <!-- Display success or error message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <!-- Search Form -->
        <form action="{{ route('orders.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <button type="submit" class="btn btn-primary">ابحث</button>
                <input type="text" name="order_number" class="form-control mx-4 bg-gradient-light p-2" placeholder="ابحث برقم الطلب" value="{{ request('order_number') }}">
            </div>
        </form>

        @if($orders->isEmpty())
            <p class="alert alert-info">لا يوجد طلبات </p>
        @else
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>رقم الطلب</th>
                    <th>اسم المرسل</th>
                    <th>طريقة الدفع</th>
                    <th>نوع الدفع</th>
                    <th>حالة الطلب</th>
                    <th>السعر الكلي</th>
                    <th>تاريخ الإنشاء</th>
                    <th>التفاصيل</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->order_details->S_user }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>{{ $order->payment_type }}</td>
                        <td>
                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-control" onchange="this.form.submit()">
                                    <option value="جاري المعالجة" {{ $order->status == "جاري المعالجة" ? 'selected' : '' }}>جاري المعالجة</option>
                                    <option value="مكتمل" {{ $order->status == "مكتمل" ? 'selected' : '' }}>مكتمل</option>
                                </select>
                            </form>
                        </td>
                        <td>{{ $order->total_price }}</td>
                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        <td><a href="{{ route('orders.show', $order->id) }}" class="btn btn-info">عرض</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
    @endif
@endsection
