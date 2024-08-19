@extends('layouts.master')

@section('links')
    <style>
        .error-message {
            color: red;
            font-size: 0.8em;
            margin-top: 2px;
        }
    </style>
@endsection

@section('scripts')
@endsection

@section('pageTitle')
    تعديل الملف الشخصي
@endsection

@section('content')
    <div class="container">
        <h2>تعديل الملف الشخصي</h2>
        @if(Session::has('success'))
            <div class="alert alert-success mt-3">
                {{ Session::get('success') }}
            </div>
        @endif
        <form action="{{ route('profile.update') }}" method="post" class="mb-3 mx-4 bg-white p-3 border-radius-2xl">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <!-- User Details Fields (Left Column) -->
                    <div class="form-group mt-3">
                        <label for="first_name" class="h4">الاسم الأول</label>
                        <input type="text" class="form-control @error('first_name') error @enderror h6 mr-3 bg-gradient-light w-100 p-2" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                        @error('first_name')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="last_name" class="h4">اسم العائلة</label>
                        <input type="text" class="form-control @error('last_name') error @enderror h6 mr-3 bg-gradient-light w-100 p-2" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                        @error('last_name')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="father_name" class="h4">اسم الأب</label>
                        <input type="text" class="form-control @error('father_name') error @enderror h6 mr-3 bg-gradient-light w-100 p-2" id="father_name" name="father_name" value="{{ old('father_name', $user->father_name) }}">
                        @error('father_name')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="mother_name" class="h4">اسم الأم</label>
                        <input type="text" class="form-control @error('mother_name') error @enderror h6 mr-3 bg-gradient-light w-100 p-2" id="mother_name" name="mother_name" value="{{ old('mother_name', $user->mother_name) }}">
                        @error('mother_name')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="national_number" class="h4">الرقم الوطني</label>
                        <input type="text" class="form-control @error('national_number') error @enderror h6 mr-3 bg-gradient-light w-100 p-2" id="national_number" name="national_number" value="{{ old('national_number', $user->national_number) }}">
                        @error('national_number')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- User Details Fields (Right Column) -->
                    <div class="form-group mt-3">
                        <label for="phone" class="h4">الهاتف</label>
                        <input type="text" class="form-control @error('phone') error @enderror h6 mr-3 bg-gradient-light w-100 p-2" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                        @error('phone')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="email" class="h4">البريد الإلكتروني</label>
                        <input type="email" class="form-control @error('email') error @enderror h6 mr-3 bg-gradient-light w-100 p-2" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Password Field -->
                    <div class="form-group mt-3">
                        <label for="current_password" class="h4">كلمة المرور الحالية</label>
                        <input type="password" class="form-control @error('current_password') error @enderror h6 mr-3 bg-gradient-light w-100 p-2" id="current_password" name="current_password">
                        @error('current_password')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Password Fields -->
                    <div class="form-group mt-3">
                        <label for="password" class="h4">كلمة المرور الجديدة</label>
                        <input type="password" class="form-control @error('password') error @enderror h6 mr-3 bg-gradient-light w-100 p-2" id="password" name="password">
                        @error('password')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="password_confirmation" class="h4">تأكيد كلمة المرور الجديدة</label>
                        <input type="password" class="form-control h6 mr-3 bg-gradient-light w-100 p-2" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">تحديث الملف الشخصي</button>
        </form>
    </div>
@endsection
