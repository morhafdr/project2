@extends('layouts.master')

@section('pageTitle')
    إنشاء موظف جديد
@endsection

@section('scripts')
    <style>
        .form-control.error {
            border: 1px solid red;
        }
        .error-message {
            color: red;
            font-size: 0.8em;
            margin-top: 2px;
        }
        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .form-column {
            flex: 0 0 48%; /* Adjusts the width of each column */
            display: flex;
            flex-direction: column;
        }
        .form-control {
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h2>إنشاء موظف جديد</h2>
        <form action="{{ route('employees.store') }}" method="post" class="mb-3 mx-4 bg-white p-3 border-radius-2xl">
            @csrf
            <div class="form-row">
                <div class="form-column">
                    <!-- User Information Fields -->
                    <div class="form-group">
                        <label for="email" class="h4">البريد الإلكتروني</label>
                        <input type="email" class="form-control @error('email') error @enderror h6 mr-3 bg-gradient-light p-2" id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="first_name" class="h4">الاسم الأول</label>
                        <input type="text" class="form-control @error('first_name') error @enderror h6 mr-3 bg-gradient-light p-2" id="first_name" name="first_name" value="{{ old('first_name') }}">
                        @error('first_name')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="h4">اسم العائلة</label>
                        <input type="text" class="form-control @error('last_name') error @enderror h6 mr-3 bg-gradient-light p-2" id="last_name" name="last_name" value="{{ old('last_name') }}">
                        @error('last_name')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="father_name" class="h4">اسم الأب</label>
                        <input type="text" class="form-control @error('father_name') error @enderror h6 mr-3 bg-gradient-light p-2" id="father_name" name="father_name" value="{{ old('father_name') }}">
                        @error('father_name')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="mother_name" class="h4">اسم الأم</label>
                        <input type="text" class="form-control @error('mother_name') error @enderror h6 mr-3 bg-gradient-light p-2" id="mother_name" name="mother_name" value="{{ old('mother_name') }}">
                        @error('mother_name')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="national_number" class="h4">الرقم الوطني</label>
                        <input type="text" class="form-control @error('national_number') error @enderror h6 mr-3 bg-gradient-light p-2" id="national_number" name="national_number" value="{{ old('national_number') }}">
                        @error('national_number')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-column">
                    <!-- Additional fields for user details -->

                    <div class="form-group">
                        <label for="password" class="h4">كلمة السر</label>
                        <input type="password" class="form-control @error('password') error @enderror h6 mr-3 bg-gradient-light p-2" id="password" name="password">
                        @error('password')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="h4">تأكيد كلمة السر</label>
                        <input type="password" class="form-control @error('password_confirmation') error @enderror h6 mr-3 bg-gradient-light p-2" id="password_confirmation" name="password_confirmation">
                        @error('password_confirmation')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone" class="h4">الجوال</label>
                        <input type="tel" class="form-control @error('phone') error @enderror h6 mr-3 bg-gradient-light p-2 text-end" id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="office_id" class="h4">المكتب</label>
                        <select class="form-control @error('office_id') error @enderror h6 mr-3 bg-gradient-light p-2" id="office_id" name="office_id">
                            @foreach($offices as $office)
                                <option value="{{ $office->id }}">{{ $office->city }}/{{ $office->address }}</option>
                            @endforeach
                        </select>
                        @error('office_id')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="join_date" class="h4">تاريخ الانضمام</label>
                        <input type="date" class="form-control @error('join_date') error @enderror h6 mr-3 bg-gradient-light p-2 text-end" id="join_date" name="join_date" value="{{ old('join_date') }}">
                        @error('join_date')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="salary" class="h4">الراتب</label>
                        <input type="number" class="form-control @error('salary') error @enderror h6 mr-3 bg-gradient-light p-2" id="salary" name="salary" value="{{ old('salary') }}">
                        @error('salary')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role_id" class="h4">الدور</label>
                        <select class="form-control @error('role_id') error @enderror h6 mr-3 bg-gradient-light p-2" id="role_id" name="role_id">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">إنشاء</button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">العودة إلى القائمة</a>
        </form>
    </div>
@endsection
