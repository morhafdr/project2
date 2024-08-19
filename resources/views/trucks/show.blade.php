@extends('layouts.master')

@section('pageTitle','تفاصيل الشاحنة')


@section('scripts')

@endsection

@section('content')
    <div class="container">
        <h2 class="my-4">تفاصيل الشاحنة</h2>
        <div class="card">
            <div class="card-body">


                <p class="mb-2 fs-5">   <strong>النمرة : </strong> {{ $truck->plate_number }}</p>
                <p class="mb-2 fs-5">    <strong>السائق: </strong> {{ $truck->driver->name }}</p>
                <p class="mb-2 fs-5">  <strong>النوع : </strong> {{$truck->type }}</p>
                <p class="mb-2 fs-5">  <strong> السعة: </strong>  {{ $truck->capacity }} T </p>


                <!-- Average Rating Display -->
                <a href="{{ route('trucks.index') }}" class="btn btn-primary">العودة إلى القائمة</a>
            </div>
        </div>
    </div>
@endsection
