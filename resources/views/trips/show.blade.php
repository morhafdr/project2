@extends('layouts.master')

@section('pageTitle','تفاصيل الرحلة')

@section('scripts')
@endsection

@section('content')
    <div class="container">
        <h2 class="my-4">تفاصيل الرحلة</h2>
        <div class="card">
            <div class="card-body">
                <p class="mb-2 fs-5"><strong>رقم لوحة الشاحنة: </strong> {{ $trip->truck->plate_number }}</p>
                <p class="mb-2 fs-5"><strong>من المكتب: </strong> {{ $trip->fromOffice->city }}</p>
                <p class="mb-2 fs-5"><strong>إلى المكتب: </strong> {{$trip->toOffice->city }}</p>
                <p class="mb-2 fs-5"><strong>الحالة: </strong> {{ ucfirst($trip->status) }}</p>
                <p class="mb-2 fs-5"><strong>المسافة: </strong> {{ ucfirst($trip->distancePerKm) }}كم </p>

                @if ($cargo->isNotEmpty())
                    <h4 class="my-4">محتويات الشاحنة :</h4>
                    <ul class="list-group">
                        @foreach ($cargo as $manifest)
                            <li class="list-group-item">
                                <p class="mb-2 fs-5"><strong>اسم البضاعة:</strong> {{ $manifest->incomingGoods->good_name }}</p>
                                <p class="mb-2 fs-5"><strong>الكمية:</strong> {{ $manifest->incomingGoods->quantity }}</p>
                                <p class="mb-2 fs-5"><strong>الوزن:</strong> {{ $manifest->incomingGoods->weight }}</p>
                                <p class="mb-2 fs-5"><strong>الحجم:</strong> {{ $manifest->incomingGoods->volume }}</p>
                                <p class="mb-2 fs-5"><strong>رقم الطلب:</strong> {{ $manifest->incomingGoods->order->id }}</p>

                                <!-- Button to show order details -->
                                <a href="{{ route('orders.show', $manifest->incomingGoods->order->id) }}" class="btn btn-secondary mt-2">عرض تفاصيل الطلب</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="fs-5">لا توجد بضائع واردة لهذا المنافست.</p>
                @endif

                <a href="{{ route('trips.index') }}" class="btn btn-primary mt-4">العودة إلى القائمة</a>
            </div>
        </div>
    </div>
@endsection
