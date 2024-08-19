@extends('layouts.master')

@section('pageTitle')
    شحن الحساب
@endsection
@section('links')
    <style>
        .alert {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            opacity: 0.9;
            transition: opacity 0.5s ease-out; /* Ensure smooth transition */
        }
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
@section('scripts')

    <script>
        // Automatically hide the alert after 2 seconds
        setTimeout(function() {
            var alertBox = document.querySelector('.alert');
            if (alertBox) {
                alertBox.style.opacity = '0';
                setTimeout(function() {
                    alertBox.remove();
                }, 500);
            }
        }, 2000);
    </script>
@endsection

@section('content')
    <div class="container">
        <h2>شحن الحساب</h2>

        <!-- Success and Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Form to charge the account -->
        <form id="deposit-form" method="POST" class="mb-3 mx-4 bg-white p-3 border-radius-2xl">
            @csrf
            <div class="form-group mt-3">
                <label for="email" class="h4">البريد الإلكتروني للمستخدم</label>
                <input type="email" name="email" class="form-control @error('email') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="email" value="{{ old('email') }}" required>
                @error('email')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="amount" class="h4">المبلغ</label>
                <input type="number" name="amount" class="form-control @error('amount') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="amount" value="{{ old('amount') }}" required>
                @error('amount')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">شحن الحساب</button>

        </form>
    </div>

    <script>
        document.getElementById('deposit-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const email = document.getElementById('email').value;
            this.action = `/payments/deposit/${email}`;
            this.submit();
        });
    </script>
@endsection
