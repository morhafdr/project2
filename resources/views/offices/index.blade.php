@extends('layouts.master')
@section('pageTitle')
    مكاتب
@endsection
@section('links')
    <style>
        /* RTL modal styling */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            direction: rtl; /* Right-to-left */
        }
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
        }
        .modal-content {
            margin: auto;
            background: white;
            border: 1px solid #888;
            width: 80%;
        }
        .modal-header, .modal-body, .modal-footer {
            text-align: right; /* Align text to the right for Arabic */
        }
        .close:hover,
        .close:focus {
            color: red;
            cursor: pointer;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var deleteButtons = document.querySelectorAll('.delete-btn');
            var modal = document.getElementById('deleteConfirmationModal');
            var closeModalBtn = document.querySelector('.close');
            var cancelBtn = document.querySelector('.modal-footer .btn-secondary');
            var confirmDeleteBtn = document.getElementById('confirmDelete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent form submission
                    var form = this.closest('form'); // Get the form the button is inside
                    confirmDeleteBtn.onclick = function () {
                        form.submit(); // Submit the form on confirmation
                    };
                    modal.style.display = 'block';
                });
            });

            closeModalBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            cancelBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            window.onclick = function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            }
        });
    </script>
@endsection

@section('pageTitle')
@endsection

@section('content')
    <div class="container">
        <h2 class="my-4">قائمة المكاتب</h2>
        @if(auth()->user()->hasRole('superAdmin'))
        <a href="{{ route('offices.create') }}" class="btn btn-success">إنشاء مكتب</a>
        @endif
        <form method="GET" action="{{ route('offices.index') }}" class="mb-4">
            <select name="governorate" id="governorate" class="form-control">
                <option value="">اختر محافظة</option>
                @foreach($governorates as $id => $name)
                    <option value="{{ $name }}" {{ request('governorate') == $name ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>

            <div class="form-group">
                <label for="city">المدينة:</label>
                <select name="city" id="city" class="form-control">
                    <option value="">اختر مدينة</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">فلتر</button>
            <a href="{{ route('offices.index') }}" class="btn btn-secondary">إعادة ظبط</a>
        </form>
        @if($offices->isEmpty())
            <p class="alert alert-info">لا يوجد مكاتب متاحة حالياً.</p>
        @else
        <table class="table table-striped" style="text-align: right;">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">المحافظة</th>
                <th scope="col">المدينة</th>
                <th scope="col">العنوان</th>
                <th scope="col">الجوال</th>
                <th scope="col">العمليات</th>
            </tr>
            </thead>
            <tbody>
            @php $i = '0'; @endphp
            @foreach($offices as $office)
                <tr>
                    <th scope="row">{{ ++$i }}</th>
                    <td>{{ $office->governorate->name }}</td>
                    <td>{{ $office->city }}</td>
                    <td>{{ $office->address }}</td>
                    <td>{{ $office->phone }}</td>
                    <td>
                        <a href="{{ route('offices.show', $office) }}" class="btn btn-primary">عرض</a>
                        @if(auth()->user()->hasRole('superAdmin'))
                        <a href="{{ route('offices.edit', $office) }}" class="btn btn-warning">تعديل</a>
                        <form action="{{ route('offices.destroy', $office) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger delete-btn">حذف</button>
                            @endif
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmationModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تأكيد الحذف</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من أنك تريد حذف هذا المكتب؟</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">حذف</button>
                </div>
            </div>
        </div>
    </div>
@endsection
