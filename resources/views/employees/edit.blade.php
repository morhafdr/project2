@extends('layouts.master')

@section('pageTitle')
    تعديل موظف
@endsection

@section('links')
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

@section('scripts')
    <script>
        // Add any specific JavaScript for the page here
    </script>
@endsection

@section('content')
    <div class="container">
        <h2 class="my-4">تعديل بيانات الموظف</h2>

        <form method="POST" action="{{ route('employees.update', $employee->id) }}">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="first_name" class="h4">الاسم الأول:</label>
                        <input type="text" class="form-control @error('first_name') error @enderror h6 mr-3 bg-gradient-light p-2" id="first_name" name="first_name" value="{{ old('first_name', $employee->user->first_name) }}" required>
                        @error('first_name')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="h4">الاسم الأخير:</label>
                        <input type="text" class="form-control @error('last_name') error @enderror h6 mr-3 bg-gradient-light p-2" id="last_name" name="last_name" value="{{ old('last_name', $employee->user->last_name) }}" required>
                        @error('last_name')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="father_name" class="h4">اسم الأب:</label>
                        <input type="text" class="form-control @error('father_name') error @enderror h6 mr-3 bg-gradient-light p-2" id="father_name" name="father_name" value="{{ old('father_name', $employee->user->father_name) }}" required>
                        @error('father_name')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="mother_name" class="h4">اسم الأم:</label>
                        <input type="text" class="form-control @error('mother_name') error @enderror h6 mr-3 bg-gradient-light p-2" id="mother_name" name="mother_name" value="{{ old('mother_name', $employee->user->mother_name) }}" required>
                        @error('mother_name')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="h4">البريد الإلكتروني:</label>
                        <input type="email" class="form-control @error('email') error @enderror h6 mr-3 bg-gradient-light p-2" id="email" name="email" value="{{ old('email', $employee->user->email) }}" required>
                        @error('email')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>


                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label for="phone" class="h4">رقم الجوال:</label>
                        <input type="text" class="form-control @error('phone') error @enderror h6 mr-3 bg-gradient-light p-2 text-end" id="phone" name="phone" value="{{ old('phone', $employee->user->phone) }}" required>
                        @error('phone')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="national_number" class="h4">الرقم الوطني:</label>
                        <input type="text" class="form-control @error('national_number') error @enderror h6 mr-3 bg-gradient-light p-2" id="national_number" name="national_number" value="{{ old('national_number', $employee->user->national_number) }}" required>
                        @error('national_number')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="office_id" class="h4">المكتب:</label>
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
                        <label for="role_id" class="h4">الدور:</label>
                        <select class="form-control @error('role_id') error @enderror h6 mr-3 bg-gradient-light p-2" id="role_id" name="role_id" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $employee->user->roles->contains($role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="join_date" class="h4">تاريخ الانضمام:</label>
                        <input type="date" class="form-control @error('join_date') error @enderror h6 mr-3 bg-gradient-light p-2 text-end" id="join_date" name="join_date" value="{{ old('join_date', $employee->join_date) }}" required>
                        @error('join_date')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="salary" class="h4">الراتب:</label>
                        <input type="number" class="form-control @error('salary') error @enderror h6 mr-3 bg-gradient-light p-2" id="salary" name="salary" value="{{ old('salary', $employee->salary) }}" required>
                        @error('salary')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">تحديث</button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
@endsection
