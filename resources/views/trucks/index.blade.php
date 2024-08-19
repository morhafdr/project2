<!-- resources/views/trucks/index.blade.php -->
@extends('layouts.master')

@section('pageTitle', 'قائمة الشاحنات')

@section('links')
    <style>
        /* RTL styling for Arabic */
        body {
            direction: rtl;
        }
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
        /* Add this to your existing styles */
        @media (max-width: 768px) {
            .action-buttons {
                display: none;
            }
            .dropdown-menu {
                display: block !important;
            }
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

@section('content')
    <div class="container">
        <h2 class="my-4">قائمة الشاحنات</h2>
        @if(auth()->user()->hasRole('superAdmin') || auth()->user()->hasRole('admin'))
        <a href="{{ route('trucks.create') }}" class="btn btn-success">إضافة شاحنة</a>
        @endif
        @if($trucks->isEmpty())
            <p class="alert alert-info">لا يوجد شاحنات متاحة حالياً.</p>
        @else
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">رقم اللوحة</th>
                    <th scope="col"> السائق</th>
                    <th scope="col">النوع</th>
                    <th scope="col">السعة</th>
                    <th scope="col">العمليات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($trucks as $index => $truck)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $truck->plate_number }}</td>
                        <td>{{ $truck->driver->name }}</td>
                        <td>{{ $truck->type }}</td>
                        <td>{{ $truck->capacity }}</td>
                        <td>
                            <a href="{{ route('trucks.show', $truck->id) }}" class="btn btn-primary">عرض</a>
                            @if(auth()->user()->hasRole('superAdmin') || auth()->user()->hasRole('admin'))
                            <a href="{{ route('trucks.edit', $truck->id) }}" class="btn btn-warning">تعديل</a>
                            <form action="{{ route('trucks.destroy', $truck->id) }}" method="POST" style="display:inline;">
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
                        <p>هل أنت متأكد من أنك تريد حذف هذه الشاحنة؟</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">حذف</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
