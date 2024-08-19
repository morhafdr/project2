@extends('layouts.master')

@section('pageTitle', 'قائمة الرحلات')

@section('links')
    <style>
        body {
            direction: rtl;
        }

        .alert {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            opacity: 0.9;
            transition: opacity 0.5s ease-out; /* Ensure smooth transition */
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
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
            text-align: right;
        }

        .close:hover,
        .close:focus {
            color: red;
            cursor: pointer;
        }

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
                    event.preventDefault();
                    var form = this.closest('form');
                    confirmDeleteBtn.onclick = function () {
                        form.submit();
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
            };

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
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <h2 class="my-4">قائمة الرحلات</h2>

        <!-- Display success or error message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(auth()->user()->hasRole('superAdmin') || auth()->user()->hasRole('admin'))
            <a href="{{ route('trips.create') }}" class="btn btn-success">إضافة رحلة</a>
        @endif

        @if($trips->isEmpty())
            <p class="alert alert-info">لا يوجد رحلات متاحة حالياً.</p>
        @else
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">الشاحنة</th>
                    <th scope="col">من المكتب</th>
                    <th scope="col">إلى المكتب</th>
                    <th scope="col">الحالة</th>
                    <th scope="col">العمليات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($trips as $index => $trip)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $trip->truck->plate_number }}</td>
                        <td>{{ $trip->fromOffice->city }}/{{ $trip->fromOffice->address }}</td>
                        <td>{{ $trip->toOffice->city }}/{{$trip->toOffice->address }}</td>
                        <td>
                            <form action="{{ route('trips.updateStatus', $trip->id) }}" method="POST">
                                @csrf
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="جاهز" {{ $trip->status == 'جاهز' ? 'selected' : '' }}>جاهز</option>
                                    <option value="مرسل" {{ $trip->status == 'مرسل' ? 'selected' : '' }}>مرسل</option>
                                    <option value="مستلم" {{ $trip->status == 'مستلم' ? 'selected' : '' }}>مستلم</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('trips.show', $trip->id) }}" class="btn btn-primary">عرض</a>
                            @if(auth()->user()->hasRole('superAdmin') || auth()->user()->hasRole('admin'))
                                <a href="{{ route('trips.edit', $trip->id) }}" class="btn btn-warning">تعديل</a>
                                <form action="{{ route('trips.destroy', $trip->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger delete-btn">حذف</button>
                                </form>
                            @endif
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
                        <p>هل أنت متأكد من أنك تريد حذف هذه الرحلة؟</p>
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
