@extends('layouts.master')

@section('pageTitle')
    تعديل مكتب
@endsection

@section('scripts')
    <style>
        #governorateSelect {
            width: 200px;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            font-size: 14px;
        }

        #governorateSelect option {
            padding: 5px;
            font-size: 12px;
        }

        .form-control.error {
            border: 1px solid red;
        }

        .error-message {
            color: red;
            font-size: 0.8em;
            margin-top: 2px;
        }

        #map {
            height: 400px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var initialLat = {{ $office->latitude ?? 31.5 }};
            var initialLng = {{ $office->longitude ?? 34.5 }};
            var map = L.map('map').setView([initialLat, initialLng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);

            var marker = L.marker([initialLat, initialLng]).addTo(map);

            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;
            });
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <h2>تعديل مكتب</h2>
        <!-- Display Validation Errors -->

        <form action="{{ route('offices.update', $office->id) }}" method="post" class="mb-3 mx-4 bg-white p-3 border-radius-2xl" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="form-group mt-3">
                <label for="governorate_id" class="h4">المحافظة</label>
                <select class="form-control @error('governorate_id') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="governorate_id" name="governorate_id">
                    @foreach(\App\Models\Governorate::all() as $governorate)
                        <option value="{{ $governorate->id }}" {{ (old('governorate_id', $office->governorate_id) == $governorate->id) ? 'selected' : '' }}>
                            {{ $governorate->name }}
                        </option>
                    @endforeach
                </select>
                @error('governorate_id')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="city" class="h4">المدينة</label>
                <input type="text" class="form-control @error('city') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="city" name="city" value="{{ old('city', $office->city) }}">
                @error('city')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="address" class="h4">العنوان</label>
                <input type="text" class="form-control @error('address') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="address" name="address" value="{{ old('address', $office->address) }}">
                @error('address')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-5">
                <label for="phone" class="h4">الجوال</label>
                <input type="tel" class="form-control @error('phone') error @enderror text-end h6 mr-3 bg-gradient-light w-50 p-2" id="phone" name="phone" value="{{ old('phone', $office->phone) }}">
                @error('phone')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-5">
                <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $office->latitude) }}">
                @error('latitude')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group mt-5">
                <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $office->longitude) }}">
                @error('longitude')
                <div class="error-message">{{$message}}</div>
                @enderror
            </div>
            <div id="map"></div>
            <button type="submit" class="btn btn-primary mt-3">تحديث</button>
            <a href="{{ route('offices.index') }}" class="btn btn-primary mt-3">العودة إلى القائمة</a>
        </form>
    </div>
@endsection
