@extends('layouts.master')

@section('pageTitle')
    إنشاء رحلة جديدة
@endsection

@section('scripts')
    <style>
        /* Custom CSS for the form fields */
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
        <h2>إنشاء رحلة جديدة</h2>
        <!-- Form to create a new trip -->
        <form action="{{ route('trips.store') }}" method="post" class="mb-3 mx-4 bg-white p-3 border-radius-2xl">
            @csrf
            <div class="form-group mt-3">
                <label for="truck_id" class="h4">الشاحنة</label>
                <select class="form-control @error('truck_id') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="truck_id" name="truck_id">
                    @foreach(\App\Models\Truck::all() as $truck)
                        <option value="{{ $truck->id }}" {{ old('truck_id') == $truck->id ? 'selected' : '' }}>{{ $truck->plate_number }}</option>
                    @endforeach
                </select>
                @error('truck_id')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="from_office_id" class="h4">من المكتب</label>
                <select class="form-control @error('from_office_id') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="from_office_id" name="from_office_id">
                    @foreach(\App\Models\Office::all() as $office)
                        <option value="{{ $office->id }}" {{ old('from_office_id') == $office->id ? 'selected' : '' }}>{{ $office->city }}/{{ $office->address }}</option>
                    @endforeach
                </select>
                @error('from_office_id')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="to_office_id" class="h4">إلى المكتب</label>
                <select class="form-control @error('to_office_id') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="to_office_id" name="to_office_id">
                    @foreach(\App\Models\Office::all() as $office)
                        <option value="{{ $office->id }}" {{ old('from_office_id') == $office->id ? 'selected' : '' }}>{{ $office->city }}/{{ $office->address }}</option>
                    @endforeach
                </select>
                @error('to_office_id')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="status" class="h4">الحالة</label>
                <select class="form-control @error('status') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="status" name="status">
                    <option value="جاهز" {{ old('status') == 'جاهز' ? 'selected' : '' }}>جاهز</option>
                    <option value="مرسل" {{ old('status') == 'مرسل' ? 'selected' : '' }}>مرسل</option>
                    <option value="مستلم" {{ old('status') == 'مستلم' ? 'selected' : '' }}>مستلم</option>
                </select>
                @error('status')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="distancePerKm" class="h4">المسافة</label>
                <input type="text" class="form-control @error('distancePerKm') error @enderror h6 mr-3 bg-gradient-light w-50 p-2"
                       id="distancePerKm" name="distancePerKm" value="{{ old('distancePerKm') }}">
                @error('distancePerKm')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">إنشاء رحلة</button>
            <a href="{{ route('trips.index') }}" class="btn btn-primary">العودة إلى القائمة</a>
        </form>
    </div>
@endsection
