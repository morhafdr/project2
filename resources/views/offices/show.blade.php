@extends('layouts.master')
@section('pageTitle')
    تفاصيل المكتب
@endsection
@section('links')

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 400px; /* Set the height of the map */
            width: 100%; /* Make the map full width */
        }
    </style>
    <script>
        $(document).ready(function() {
            var averageRating = {{ $averageRating }};
            var stars = '';
            for (var i = 0; i < averageRating; i++) {
                stars += '<i class="fas fa-star"></i>';
            }
            for (var i = 0; i < 5 - averageRating; i++) {
                stars += '<i class="far fa-star"></i>';
            }
            $('#averageRating').html(stars);


        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if latitude and longitude are set
            var latitude = {{ $office->latitude }};
            var longitude = {{ $office->longitude }};

            if (latitude !== null && longitude !== null) {
                var map = L.map('map').setView([latitude, longitude], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19
                }).addTo(map);

                var marker = L.marker([latitude, longitude]).addTo(map);
            } else {
                // Hide the map if no coordinates
                document.getElementById('map').style.display = 'none';
                // Optionally, display a message
                // document.getElementById('map').insertAdjacentHTML('beforebegin', '<p>الموقع غير متوفر.</p>');
            }
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <h2 class="my-4">تفاصيل المكتب</h2>

        <div class="card">
            <div class="card-body">
                <a href="{{ route('offices.index') }}" class="btn btn-primary">العودة إلى القائمة</a>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rateModal">
                    إعطاء تقييم
                </button>
                <h5 class="card-title">{{ $office->city }}</h5>

                <p class="mb-2 fs-5"> <strong> العنوان: </strong> {{ $office->address }}</p>
                <p class="mb-2 fs-5"> <strong> الجوال: </strong> {{ $office->phone }}</p>
                <p class="mb-2 fs-5"> <strong>المدينة: </strong> {{ $office->city }}</p>
                <p class="mb-2 fs-5"> <strong> المحافظة: </strong> {{ $office->governorate->name }}</p>

                <!-- Map Display -->
                <div id="map"></div>

                <!-- Average Rating Display -->
                <div id="averageRating" class="mt-4"></div>

                <!-- Rate Modal -->
                <div class="modal fade" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="rateModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rateModalLabel">إعطاء تقييم</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('rates.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="office_id" value="{{ $office->id }}">
                                    <div class="form-group">
                                        <label for="rate">التقييم:</label>
                                        <select class="form-control" id="rate" name="rate" required>
                                            <option value="">اختر تقييم</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="comment">التعليق:</label>
                                        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success">إرسال التقييم</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if(count($employees) > 0 && (auth()->user()->hasRole('superAdmin') || auth()->user()->hasRole('admin')))
                    <p class="mb-2 fs-5 mt-2"> <strong>موظفو المكتب </strong> </p>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">البريد الإلكتروني</th>
                            <th scope="col">الاسم الكامل</th>
                            <th scope="col">الوظيفة</th>
                            <th scope="col">العمليات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($employees as $index => $employee)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $employee->user->email }}</td>
                                <td>{{ $employee->user->first_name }} {{ $employee->user->last_name }}</td>
                                <td>{{ $employee->user->roles->pluck('name')->implode(', ') }}</td>
                                <td>
                                    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-primary">عرض</a>
                                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning">تعديل</a>
                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger delete-btn">حذف</button>
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
                                <p>هل أنت متأكد من أنك تريد حذف هذا الموظف؟</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                <button type="button" class="btn btn-danger" id="confirmDelete">حذف</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
