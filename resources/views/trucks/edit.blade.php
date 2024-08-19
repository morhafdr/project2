<!-- resources/views/trucks/edit.blade.php -->
@extends('layouts.master')

@section('pageTitle')
    تعديل شاحنة
@endsection

@section('scripts')
    <style>
        /* Existing CSS */
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
        <h2>تعديل شاحنة</h2>
        <!-- Display Validation Errors -->

        <form action="{{ route('trucks.update', $truck->id) }}" method="post" class="mb-3 mx-4 bg-white p-3 border-radius-2xl" autocomplete="off">
            @csrf
            @method('PUT') <!-- Correct method for updating -->
            <div class="form-group mt-3">
                <label for="plate_number" class="h4">رقم اللوحة</label>
                <input type="text" class="form-control @error('plate_number') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="plate_number" name="plate_number" value="{{ old('plate_number', $truck->plate_number) }}">
                @error('plate_number')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="driver_id" class="h4"> السائق</label>
                <select class="form-control @error('driver_id') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="driver_id" name="driver_id">
                    @foreach(\App\Models\Driver::all() as $driver)
                        <option value="{{ $driver->id }}" {{ (old('driver_id', $truck->driver_id) == $driver->id) ? 'selected' : '' }}>
                            {{ $driver->name }}
                        </option>
                    @endforeach
                </select>
                @error('driver_id')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="type" class="h4">النوع</label>
                <input type="text" class="form-control @error('type') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="type" name="type" value="{{ old('type', $truck->type) }}">
                @error('type')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="capacity" class="h4">السعة</label>
                <input type="number" class="form-control @error('capacity') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="capacity" name="capacity" value="{{ old('capacity', $truck->capacity) }}">
                @error('capacity')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">تحديث</button>
            <a href="{{ route('trucks.index') }}" class="btn btn-primary">العودة إلى القائمة</a>
        </form>
    </div>
@endsection
