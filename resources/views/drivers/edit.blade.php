@extends('layouts.master')

@section('pageTitle')
    تعديل السائق
@endsection

@section('scripts')
    <style>
        /* Existing CSS */
        #governorateSelect {
            width: 200px;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            font-size: 14px;
        }

        #governorateSelect option {
            padding: 5px;
            font-size: 12px;
        }

        /* New styles for validation */
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
        <h2>تعديل السائق</h2>
        <!-- Display Validation Errors -->

        <form action="{{ route('drivers.update', $driver->id) }}" method="post" class="mb-3 mx-4 bg-white p-3 border-radius-2xl" autocomplete="off">
            @csrf
            @method('PUT') <!-- Correct method for updating -->
            <div class="form-group mt-3">
                <label for="name" class="h4">الاسم</label>
                <input type="text" class="form-control @error('name') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="name" name="name" value="{{ old('name', $driver->name) }}">
                @error('name')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="national_id" class="h4">الرقم الوطني</label>
                <input type="text" class="form-control @error('national_id') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="national_id" name="national_id" value="{{ old('national_id', $driver->national_id) }}">
                @error('national_id')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="driver_License_number" class="h4">رقم رخصة القيادة</label>
                <input type="text" class="form-control @error('driver_License_number') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="driver_License_number" name="driver_License_number" value="{{ old('driver_License_number', $driver->driver_License_number) }}">
                @error('driver_License_number')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-5">
                <label for="phone" class="h4">الجوال</label>
                <input type="tel" class="form-control @error('phone') error @enderror text-end h6 mr-3 bg-gradient-light w-50 p-2" id="phone" name="phone" value="{{ old('phone', $driver->phone) }}">
                @error('phone')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="join_date" class="h4">تاريخ الانضمام</label>
                <input type="date" class="form-control @error('join_date') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="join_date" name="join_date" value="{{ old('join_date', $driver->join_date) }}">
                @error('join_date')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="status" class="h4">الحالة</label>
                <input type="text" class="form-control @error('status') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="status" name="status" value="{{ old('status', $driver->status) }}">
                @error('status')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">تحديث</button>
            <a href="{{ route('drivers.index') }}" class="btn btn-primary">العودة إلى القائمة</a>
        </form>
    </div>
@endsection
