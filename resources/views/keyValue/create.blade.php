@extends('layouts.master')

@section('pageTitle')
    إنشاء تسعيرة
@endsection

@section('scripts')
    <style>
        /* Custom CSS for the input fields */
        .form-control.error {
            border: 1px solid red;
        }
        .error-message {
            color: red;
            font-size: 0.8em;
            margin-top: 2px;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h2>إنشاء تسعيرة جديدة</h2>
        <!-- Form to create a new variable value -->
        <form action="{{ route('variable-values.store') }}" method="post" class="mb-3 mx-4 bg-white p-3 border-radius-2xl">
            @csrf
            <div class="form-group mt-3">
                <label for="value" class="h4">سعر كم</label>
                <input type="number" class="form-control @error('value') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="value" name="value" autocomplete="off" value="{{ old('value') }}">
                @error('value')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="weight" class="h4">الوزن </label>
                <input type="text" class="form-control @error('weight') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="weight" name="weight" autocomplete="off" value="{{ old('weight') }}">
                @error('weight')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">إنشاء قيمة متغيرة</button>
            <a href="{{ route('variable-values.index') }}" class="btn btn-secondary">العودة إلى القائمة</a>
        </form>
    </div>
@endsection
