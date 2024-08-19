@extends('layouts.master')

@section('pageTitle')
    تعديل التسعيرة
@endsection

@section('scripts')
    <style>
        /* Custom styles for input fields */
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
        <h2>تعديل التسعيرة</h2>

        <form action="{{ route('variable-values.update', $variableValue->id) }}" method="post" class="mb-3 mx-4 bg-white p-3 border-radius-2xl" autocomplete="off">
            @csrf
            @method('PUT') <!-- Correct method for updating -->


            <div class="form-group mt-3">
                <label for="value" class="h4">سعر كم</label>
                <input type="text" class="form-control @error('value') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="value" name="value" value="{{ old('value', $variableValue->value) }}">
                @error('value')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="weight" class="h4">الوزن </label>
                <input type="text" class="form-control @error('weight') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="weight" name="weight" value="{{ old('weight', $variableValue->weight) }}">
                @error('weight')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">تحديث</button>
            <a href="{{ route('variable-values.index') }}" class="btn btn-secondary">العودة إلى القائمة</a>
        </form>
    </div>
@endsection
