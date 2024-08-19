@extends('layouts.master')

@section('pageTitle')
    انشاء سائق
@endsection

@section('scripts')
    <style>
        /* Custom CSS for the form controls */
        .form-control.error {
            border: 1px solid red;
        }
        .error-message {
            color: red;
            font-size: 0.8em;
            margin-top: 2px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h2>انشاء سائق جديد</h2>
        <!-- Form to create a new driver -->
        <form action="{{ route('drivers.store') }}" method="post" class="mb-3 mx-4 bg-white p-3 border-radius-2xl">
            @csrf
            <div class="form-group mt-3">
                <label for="name" class="h4">الاسم الكامل</label>
                <input type="text" class="form-control @error('name') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="name" name="name" autocomplete="off" value="{{ old('name') }}">
                @error('name')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="national_id" class="h4">رقم الهوية</label>
                <input type="text" class="form-control @error('national_id') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="national_id" name="national_id" autocomplete="off" value="{{ old('national_id') }}">
                @error('national_id')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="driver_license_number" class="h4">رقم رخصة القيادة</label>
                <input type="text" class="form-control @error('driver_License_number') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="driver_License_number" name="driver_License_number" autocomplete="off" value="{{ old('driver_License_number') }}">
                @error('driver_License_number')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="phone" class="h4">رقم الهاتف</label>
                <input type="tel" class="form-control @error('phone') error @enderror text-end h6 mr-3 bg-gradient-light w-50 p-2" id="phone" name="phone" autocomplete="off" value="{{ old('phone') }}">
                @error('phone')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="join_date" class="h4">تاريخ الانضمام</label>
                <input type="date" class="form-control @error('join_date') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="join_date" name="join_date" autocomplete="off" value="{{ old('join_date') }}">
                @error('join_date')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="status" class="h4">الحالة</label>
                <input type="text" class="form-control @error('status') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="status" name="status" autocomplete="off" value="{{ old('status') }}">
                @error('status')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">انشاء سائق</button>
            <a href="{{ route('drivers.index') }}" class="btn btn-primary">العودة إلى القائمة</a>
        </form>
    </div>
@endsection
