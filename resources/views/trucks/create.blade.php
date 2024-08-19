<!-- resources/views/trucks/create.blade.php -->
@extends('layouts.master')

@section('pageTitle')
    انشاء شاحنة
@endsection

@section('scripts')
    <style>
        /* Custom CSS for the type select list */
        #typeSelect {
            width: 200px; /* Reduced width */
            padding: 10px; /* Some padding */
            border-radius: 5px; /* Rounded borders */
            box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Optional: Shadow for depth */
            font-size: 14px; /* Smaller font size for better fit */
        }

        /* Optional: Style for the options */
        #typeSelect option {
            padding: 5px; /* Padding for better readability */
            font-size: 12px; /* Smaller font size for options */
        }
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
        <h2>انشاء شاحنة جديدة</h2>
        <!-- Form to create a new truck -->
        <form action="{{ route('trucks.store') }}" method="post" class="mb-3 mx-4 bg-white p-3 border-radius-2xl">
            @csrf
            <div class="form-group mt-3">
                <label for="plate_number" class="h4">رقم اللوحة</label>
                <input type="text" class="form-control @error('plate_number') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="plate_number" name="plate_number" autocomplete="off" value="{{ old('plate_number') }}">
                @error('plate_number')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="driver_id" class="h4"> السائق</label>
                <select class="form-control @error('driver_id') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="driver_id" name="driver_id">
                    @foreach(\App\Models\Driver::all() as $driver)
                        <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>{{ $driver->name }}</option>
                    @endforeach
                </select>
                @error('driver_id')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="type" class="h4">النوع</label>
                <input type="text" class="form-control @error('type') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="type" name="type" autocomplete="off" value="{{ old('type') }}">
                @error('type')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="capacity" class="h4">السعة</label>
                <input type="number" class="form-control @error('capacity') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="capacity" name="capacity" autocomplete="off" value="{{ old('capacity') }}">
                @error('capacity')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">انشاء شاحنة</button>
            <a href="{{ route('trucks.index') }}" class="btn btn-primary">العودة إلى القائمة</a>
        </form>
    </div>
@endsection
