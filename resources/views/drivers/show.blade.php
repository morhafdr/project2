@extends('layouts.master')

@section('pageTitle')
    تفاصيل السائق
@endsection

@section('scripts')

@endsection

@section('content')
    <div class="container">
        <h2 class="my-4">تفاصيل السائق</h2>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $driver->name }}</h4>

                <p class="mb-2 fs-5">   <strong>رقم الهوية:  </strong>  {{ $driver->national_id }}</p>
                <p class="mb-2 fs-5">    <strong>رقم رخصة القيادة:  </strong>  {{ $driver->driver_License_number }}</p>
                <p class="mb-2 fs-5">  <strong>رقم الهاتف:  </strong>  {{ $driver->phone }}</p>
                <p class="mb-2 fs-5">   <strong>تاريخ الانضمام: </strong>  {{ $driver->join_date }}</p>
                <p class="mb-2 fs-5">   <strong> الحالة: </strong>  {{ $driver->status }}</p>

                <a href="{{ route('drivers.index') }}" class="btn btn-primary">العودة إلى القائمة</a>
            </div>
        </div>
    </div>
@endsection
