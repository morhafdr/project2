<!-- resources/views/trips/edit.blade.php -->
@extends('layouts.master')

@section('pageTitle')
    تعديل الرحلة
@endsection

@section('scripts')
    <style>
        /* Reuse existing styles for form elements */
        #typeSelect {
            width: 200px;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            font-size: 14px;
        }

        #typeSelect option {
            padding: 5px;
            font-size: 12px;
        }

        /* Styles for validation */
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
        <h2>تعديل الرحلة</h2>

        <!-- Form to edit an existing trip -->
        <form action="{{ route('trips.update', $trip->id) }}" method="post" class="mb-3 mx-4 bg-white p-3 border-radius-2xl" autocomplete="off">
            @csrf
            @method('PUT') <!-- Correct method for updating -->

            <div class="form-group mt-3">
                <label for="truck_id" class="h4">الشاحنة</label>
                <select class="form-control @error('truck_id') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="truck_id" name="truck_id">
                    @foreach(\App\Models\Truck::all() as $truck)
                        <option value="{{ $truck->id }}" {{ (old('truck_id', $trip->truck_id) == $truck->id) ? 'selected' : '' }}>
                            {{ $truck->plate_number }}
                        </option>
                    @endforeach
                </select>
                @error('truck_id')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="from_office_id" class="h4">المكتب المغادر</label>
                <select class="form-control @error('from_office_id') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="from_office_id" name="from_office_id">
                    @foreach(\App\Models\Office::all() as $office)
                        <option value="{{ $office->id }}" {{ (old('from_office_id', $trip->from_office_id) == $office->id) ? 'selected' : '' }}>
                            {{ $office->city }}/{{ $office->address }}
                        </option>
                    @endforeach
                </select>
                @error('from_office_id')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="to_office_id" class="h4">المكتب الوجهة</label>
                <select class="form-control @error('to_office_id') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="to_office_id" name="to_office_id">
                    @foreach(\App\Models\Office::all() as $office)
                        <option value="{{ $office->id }}" {{ (old('to_office_id', $trip->to_office_id) == $office->id) ? 'selected' : '' }}>
                            {{ $office->city }}/{{ $office->address }}
                        </option>
                    @endforeach
                </select>
                @error('to_office_id')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="status" class="h4">الحالة</label>
                <select class="form-control @error('status') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="status" name="status">
                    <option value="جاهز" {{ old('status', $trip->status) == 'جاهز' ? 'selected' : '' }}>جاهز</option>
                    <option value="مرسل" {{ old('status', $trip->status) == 'مرسل' ? 'selected' : '' }}>مرسل</option>
                    <option value="مستلم" {{ old('status', $trip->status) == 'مستلم' ? 'selected' : '' }}>مستلم</option>
                </select>
                @error('status')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="distancePerKm" class="h4">اسم المستلم</label>
                <input type="text" class="form-control @error('distancePerKm') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="R_user" name="distancePerKm" value="{{ $trip->distancePerKm }}">
                @error('distancePerKm')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">تحديث</button>
            <a href="{{ route('trips.index') }}" class="btn btn-primary">العودة إلى القائمة</a>
        </form>
    </div>
@endsection
