@extends('layouts.master')

@section('pageTitle')
    تفاصيل الموظف
@endsection

@section('scripts')

@endsection

@section('content')
    <div class="container">
        <h2 class="my-4">تفاصيل الموظف</h2>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $employee->user->first_name }} {{ $employee->user->last_name }}</h4>

                <p class="mb-2 fs-5">   <strong>اسم الأب: </strong> {{ $employee->user->father_name }}</p>
                <p class="mb-2 fs-5">    <strong>اسم الأم: </strong> {{ $employee->user->mother_name }}</p>
                <p class="mb-2 fs-5">  <strong>البريد الإلكتروني: </strong> {{ $employee->user->email }}</p>
                <p class="mb-2 fs-5">  <strong> الجوال: </strong> {{ $employee->user->phone }}</p>
                <p class="mb-2 fs-5">  <strong> الرقم الوطني: </strong> {{ $employee->user->national_number }}</p>
{{--                @if(auth()->user()->hasRole('superAdmin') || auth()->id()==$employee->user->id)--}}
{{--                    <p class="mb-2 fs-5">  <strong> كلمة السر: </strong> {{ $employee->user->password }}</p>--}}
{{--                @endif--}}
                <p class="mb-2 fs-5">    <strong>الدور: </strong>
                    @foreach($employee->user->roles as $role)
                        {{ $role->name }},
                    @endforeach
                </p>
                <p class="mb-2 fs-5">   <strong>المكتب:</strong>  {{ $employee->office->governorate->name }}/{{ $employee->office->city }} / {{ $employee->office->address }}</p>
                <p class="mb-2 fs-5">   <strong>تاريخ الانضمام:</strong> {{ $employee->join_date }}</p>
                <p class="mb-2 fs-5">   <strong>الراتب:</strong> {{ $employee->salary }}</p>

                <!-- Average Rating Display -->
                <a href="{{ route('employees.index') }}" class="btn btn-primary">العودة إلى القائمة</a>
            </div>
        </div>
    </div>
@endsection
