@extends('layouts.master')

@section('pageTitle')
    تعديل الطلب
@endsection

@section('scripts')
    <style>
        .form-section {
            display: none;
        }
        .form-section.current {
            display: block;
        }
        .form-control.error {
            border: 1px solid red;
        }
        .error-message {
            color: red;
            font-size: 0.8em;
            margin-top: 2px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let currentSection = 0;
            const formSections = document.querySelectorAll('.form-section');
            const nextButton = document.querySelector('#nextButton');
            const prevButton = document.querySelector('#prevButton');
            const submitButton = document.querySelector('#submitButton');
            const addGoodButton = document.querySelector('#addGoodButton');
            const goodsContainer = document.querySelector('#goodsContainer');
            const senderSelect = document.querySelector('#senderSelect');

            formSections[currentSection].classList.add('current');

            nextButton.addEventListener('click', function (e) {
                e.preventDefault();
                if (currentSection < formSections.length - 1) {
                    formSections[currentSection].classList.remove('current');
                    currentSection++;
                    formSections[currentSection].classList.add('current');
                }
                updateButtons();
            });

            prevButton.addEventListener('click', function (e) {
                e.preventDefault();
                if (currentSection > 0) {
                    formSections[currentSection].classList.remove('current');
                    currentSection--;
                    formSections[currentSection].classList.add('current');
                }
                updateButtons();
            });

            senderSelect.addEventListener('change', function () {
                const selectedSender = this.value ? JSON.parse(this.value) : null;
                if (selectedSender) {
                    document.querySelector('#S_user').value = selectedSender.S_user;
                    document.querySelector('#S_national_id').value = selectedSender.S_national_id;
                    document.querySelector('#S_phone_number').value = selectedSender.S_phone_number;
                    document.querySelector('#S_mother_name').value = selectedSender.S_mother_name;
                    document.querySelector('#S_Location').value = selectedSender.S_Location;
                    document.querySelector('#S_family_registration').value = selectedSender.S_family_registration;
                } else {
                    document.querySelector('#S_user').value = '';
                    document.querySelector('#S_national_id').value = '';
                    document.querySelector('#S_phone_number').value = '';
                    document.querySelector('#S_mother_name').value = '';
                    document.querySelector('#S_Location').value = '';
                    document.querySelector('#S_family_registration').value = '';
                }
            });

            function updateButtons() {
                nextButton.style.display = currentSection === formSections.length - 1 ? 'none' : 'inline';
                prevButton.style.display = currentSection === 0 ? 'none' : 'inline';
                submitButton.style.display = currentSection === formSections.length - 1 ? 'inline' : 'none';
            }

            function createGoodInputGroup(index = null, good = {}) {
                const goodInputGroup = document.createElement('div');
                goodInputGroup.classList.add('good-input-group', 'mt-3');

                goodInputGroup.innerHTML = `
                    <div class="form-group">
                        <label for="good_name[]" class="h4">اسم البضاعة</label>
                        <input type="text" class="form-control h6 mr-3 bg-gradient-light w-50 p-2" name="incoming_goods[${index}][good_name]" value="${good.good_name || ''}" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity[]" class="h4">الكمية</label>
                        <input type="number" class="form-control h6 mr-3 bg-gradient-light w-50 p-2" name="incoming_goods[${index}][quantity]" value="${good.quantity || ''}" required>
                    </div>
                    <div class="form-group">
                        <label for="weight[]" class="h4">الوزن</label>
                        <input type="number" step="0.01" class="form-control h6 mr-3 bg-gradient-light w-50 p-2" name="incoming_goods[${index}][weight]" value="${good.weight || ''}" required>
                    </div>
                    <div class="form-group">
                        <label for="volume[]" class="h4">الحجم</label>
                        <input type="number" step="0.01" class="form-control h6 mr-3 bg-gradient-light w-50 p-2" name="incoming_goods[${index}][volume]" value="${good.volume || ''}" required>
                    </div>
                    <button type="button" class="btn btn-danger remove-good-button">إزالة</button>
                `;

                goodInputGroup.querySelector('.remove-good-button').addEventListener('click', function () {
                    goodInputGroup.remove();
                });

                return goodInputGroup;
            }

            addGoodButton.addEventListener('click', function (e) {
                e.preventDefault();
                const index = goodsContainer.children.length;
                const newGoodInputGroup = createGoodInputGroup(index);
                goodsContainer.appendChild(newGoodInputGroup);
            });

            updateButtons();
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <h2>تعديل الطلب</h2>
        <form action="{{ route('orders.update', $order->id) }}" method="post" class="mb-3 mx-4 bg-white p-3 border-radius-2xl">
            @csrf
            @method('PUT')
            <div class="form-section current">
                <h3>معلومات المكتب</h3>
                <div class="form-group mt-3">
                    <label for="from_office_id" class="h4">المكتب المرسل</label>
                    <!-- Hidden input to store the from_office_id -->
                    <input type="hidden" name="from_office_id" id="from_office_id" value="{{ auth()->user()->employee->office->id }}">
                    <!-- Read-only input to display the office's city and address -->
                    <input type="text" class="form-control h6 mr-3 bg-gradient-light w-50 p-2"
                           value="{{ auth()->user()->employee->office->city }}/{{ auth()->user()->employee->office->address }}" readonly>
                    @error('from_office_id')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group mt-3">
                    <label for="to_office_id" class="h4">المكتب المستلم</label>
                    <select class="form-control @error('to_office_id') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="to_office_id" name="to_office_id">
                        @foreach($offices as $office)
                            <option value="{{ $office->id }}" {{ $order->to_office_id == $office->id ? 'selected' : '' }}>{{ $office->city }}/{{ $office->address }}</option>
                        @endforeach
                    </select>
                    @error('to_office_id')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="payment_method" class="h4">طريقة الدفع</label>
                    <input type="text" class="form-control @error('payment_method') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="payment_method" name="payment_method" value="{{ $order->payment_method }}" readonly>
                    @error('payment_method')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="payment_type" class="h4">نوع الدفع</label>
                    <select class="form-control @error('payment_type') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="payment_type" name="payment_type">
                        <option value="prepaid" {{ $order->payment_type == 'prepaid' ? 'selected' : '' }}>Prepaid</option>
                        <option value="postpaid" {{ $order->payment_type == 'postpaid' ? 'selected' : '' }}>Postpaid</option>
                    </select>
                    @error('payment_type')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h3>تفاصيل المرسل</h3>
                <div class="form-group mt-3">
                    <label for="senderSelect" class="h4">اختر المرسل</label>
                    <select class="form-control h6 mr-3 bg-gradient-light w-50 p-2" id="senderSelect">
                        <option value="">مرسل جديد</option>
                        @foreach($orderDetails as $orderDetail)
                            <option value="{{ json_encode($orderDetail) }}" {{ $orderDetail->S_user == $order->S_user ? 'selected' : '' }}>{{ $orderDetail->S_user }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="S_user" class="h4">اسم المرسل</label>
                    <input type="text" class="form-control @error('S_user') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="S_user" name="S_user" value="{{ $order->order_details->S_user }}">
                    @error('S_user')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="S_national_id" class="h4">الرقم الوطني للمرسل</label>
                    <input type="text" class="form-control @error('S_national_id') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="S_national_id" name="S_national_id" value="{{ $order->order_details->S_national_id }}">
                    @error('S_national_id')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="S_phone_number" class="h4">رقم هاتف المرسل</label>
                    <input type="text" class="form-control @error('S_phone_number') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="S_phone_number" name="S_phone_number" value="{{ $order->order_details->S_phone_number }}">
                    @error('S_phone_number')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="S_mother_name" class="h4">اسم والدة المرسل</label>
                    <input type="text" class="form-control @error('S_mother_name') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="S_mother_name" name="S_mother_name" value="{{ $order->order_details->S_mother_name }}">
                    @error('S_mother_name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="S_Location" class="h4">موقع المرسل</label>
                    <input type="text" class="form-control @error('S_Location') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="S_Location" name="S_Location" value="{{ $order->order_details->S_Location }}">
                    @error('S_Location')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="S_family_registration" class="h4">تسجيل العائلة للمرسل</label>
                    <input type="text" class="form-control @error('S_family_registration') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="S_family_registration" name="S_family_registration" value="{{ $order->order_details->S_family_registration }}">
                    @error('S_family_registration')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h3>تفاصيل المستلم</h3>
                <div class="form-group mt-3">
                    <label for="R_user" class="h4">اسم المستلم</label>
                    <input type="text" class="form-control @error('R_user') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="R_user" name="R_user" value="{{ $order->order_details->R_user }}">
                    @error('R_user')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="R_phone_number" class="h4">رقم هاتف المستلم</label>
                    <input type="text" class="form-control @error('R_phone_number') error @enderror h6 mr-3 bg-gradient-light w-50 p-2" id="R_phone_number" name="R_phone_number" value="{{ $order->order_details->R_phone_number }}">
                    @error('R_phone_number')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-section ">
                <h3>البضائع الواردة</h3>
                <div id="goodsContainer">
                    @foreach($filteredGoods as $index => $good)
                        <div class="good-input-group mt-3">
                            <div class="form-group">
                                <label for="incoming_goods[{{ $index }}][good_name]" class="h4">اسم البضاعة</label>
                                <input type="text" class="form-control h6 mr-3 bg-gradient-light w-50 p-2" name="incoming_goods[{{ $index }}][good_name]" value="{{ $good->good_name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="incoming_goods[{{ $index }}][quantity]" class="h4">الكمية</label>
                                <input type="number" class="form-control h6 mr-3 bg-gradient-light w-50 p-2" name="incoming_goods[{{ $index }}][quantity]" value="{{ $good->quantity }}" required>
                            </div>
                            <div class="form-group">
                                <label for="incoming_goods[{{ $index }}][weight]" class="h4">الوزن</label>
                                <input type="number" step="0.01" class="form-control h6 mr-3 bg-gradient-light w-50 p-2" name="incoming_goods[{{ $index }}][weight]" value="{{ $good->weight }}" required>
                            </div>
                            <div class="form-group">
                                <label for="incoming_goods[{{ $index }}][volume]" class="h4">الحجم</label>
                                <input type="number" step="0.01" class="form-control h6 mr-3 bg-gradient-light w-50 p-2" name="incoming_goods[{{ $index }}][volume]" value="{{ $good->volume }}" required>
                            </div>
                            <button type="button" class="btn btn-danger remove-good-button">إزالة</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-secondary mt-3" id="addGoodButton">إضافة بضاعة</button>
            </div>

            <div class="form-navigation">
                <button type="button" class="btn btn-secondary" id="prevButton">السابق</button>
                <button type="button" class="btn btn-primary" id="nextButton">التالي</button>
                <button type="submit" class="btn btn-success" id="submitButton">تحديث الطلب</button>
            </div>
        </form>
    </div>
@endsection
