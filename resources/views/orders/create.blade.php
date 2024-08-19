@extends('layouts.master')

@section('pageTitle')
    إنشاء طلب جديد
@endsection
@section('links')
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

        .form-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .form-column {
            flex: 0 0 48%;
            display: flex;
            flex-direction: column;
        }
        #prevButton,#showModalButton{
            display: none;
        }
    </style>
@endsection
@section('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let currentSection = 0;
            const formSections = document.querySelectorAll('.form-section');
            const nextButton = document.querySelector('#nextButton');
            const prevButton = document.querySelector('#prevButton');
            const showModalButton = document.querySelector('#showModalButton');
            const totalPriceText = document.querySelector('#totalPriceText');
            const goodsContainer = document.querySelector('#goodsContainer');
            const addGoodButton = document.querySelector('#addGoodButton');

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

            showModalButton.addEventListener('click', function (e) {
                e.preventDefault();
                calculateTotalPrice();
                const confirmOrderModal = new bootstrap.Modal(document.getElementById('confirmOrderModal'));
                confirmOrderModal.show();
            });

            function calculateTotalPrice() {
                let totalPrice = 0;
                const goodInputs = document.querySelectorAll('.good-input-group');

                goodInputs.forEach(function (group) {
                    const quantity = parseFloat(group.querySelector('[name*="quantity"]').value) || 0;
                    const weight = group.querySelector('[name*="weight"]').value;
                    console.log(weight);
                    const fromOfficeId = document.querySelector('#from_office_id').value;
                    const toOfficeId = document.querySelector('#to_office_id').value;

                    // Perform an AJAX call to get the price for the goods
                    fetch(`/calculate-price?quantity=${quantity}&weight=${weight}&from_office_id=${fromOfficeId}&to_office_id=${toOfficeId}`)
                        .then(response => {
                            if (!response.ok) {
                                console.log('hi')
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json(); // Try to parse the JSON
                        })
                        .then(data => {
                            totalPrice += data.price;
                            totalPriceText.textContent = totalPrice.toFixed(2) + ' ل.س';
                        })
                        .catch(error => {
                            console.error('There was an issue with the fetch operation:', error);
                            // You can add additional error handling here, like showing an error message to the user.
                        });
                });
            }



            function updateButtons() {
                nextButton.style.display = currentSection === formSections.length - 1 ? 'none' : 'inline';
                prevButton.style.display = currentSection === 0 ? 'none' : 'inline';
                showModalButton.style.display = currentSection === formSections.length - 1 ? 'inline' : 'none';
            }

            updateButtons();

            // Handle Sender Select Change
            const senderSelect = document.querySelector('#senderSelect');
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
            <select class="form-control h6 mr-3 bg-gradient-light w-50 p-2" name="incoming_goods[${index}][weight]" required>
                <option value="under_5" ${good.weight === 'under_5' ? 'selected' : ''}>أقل من 5</option>
                <option value="under_20" ${good.weight === 'under_20' ? 'selected' : ''}>أقل من 20</option>
                <option value="under_40" ${good.weight === 'under_40' ? 'selected' : ''}>أقل من 40</option>
                <option value="under_60" ${good.weight === 'under_60' ? 'selected' : ''}>أقل من 60</option>
            </select>
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
        });

    </script>
@endsection

@section('content')
    <div class="container">
        <h2>إنشاء طلب جديد</h2>
        <form id="orderForm" action="{{ route('orders.store') }}" method="post" class="mb-3 mx-4 bg-white p-3 border-radius-2xl">
            @csrf
            <div class="form-section current">
                <h3>معلومات المكتب</h3>
                <div class="form-group mt-3">
                    <label for="from_office_id" class="h4">المكتب المرسل</label>
                    <input type="hidden" name="from_office_id" id="from_office_id" value="{{ auth()->user()->employee->office_id }}">
                    <input type="text" class="form-control h6 mr-3 bg-gradient-light w-50 p-2"
                           value="{{ auth()->user()->employee->office->city }}/{{ auth()->user()->employee->office->address }}" readonly>
                    @error('from_office_id')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group mt-3">
                    <label for="to_office_id" class="h4">المكتب المستلم</label>
                    <select class="form-control @error('to_office_id') error @enderror h6 mr-3 bg-gradient-light w-50 p-2"
                            id="to_office_id" name="to_office_id">
                        @foreach($offices as $office)
                            <option value="{{ $office->id }}" {{ old('to_office_id') == $office->id ? 'selected' : '' }}>
                                {{ $office->city }}/{{ $office->address }}
                            </option>
                        @endforeach
                    </select>
                    @error('to_office_id')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="payment_method" class="h4">طريقة الدفع</label>
                    <input type="text" class="form-control @error('payment_method') error @enderror h6 mr-3 bg-gradient-light w-50 p-2"
                           id="payment_method" name="payment_method" value="cash" readonly>
                    @error('payment_method')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="payment_type" class="h4">نوع الدفع</label>
                    <select class="form-control @error('payment_type') error @enderror h6 mr-3 bg-gradient-light w-50 p-2"
                            id="payment_type" name="payment_type">
                        <option value="prepaid" {{ old('payment_type') == 'prepaid' ? 'selected' : '' }}>Prepaid</option>
                        <option value="postpaid" {{ old('payment_type') == 'postpaid' ? 'selected' : '' }}>Postpaid</option>
                    </select>
                    @error('payment_type')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h3>تفاصيل المرسل</h3>
                <div class="form-row">
                    <div class="form-column">
                        <div class="form-group mt-3">
                            <label for="senderSelect" class="h4">اختر المرسل</label>
                            <select class="form-control h6 mr-3 bg-gradient-light p-2" id="senderSelect">
                                <option value="">مرسل جديد</option>
                                @foreach($orderDetails as $orderDetail)
                                    <option value="{{ json_encode($orderDetail) }}">{{ $orderDetail->S_user }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label for="S_user" class="h4">اسم المرسل</label>
                            <input type="text" class="form-control @error('S_user') error @enderror h6 mr-3 bg-gradient-light p-2"
                                   id="S_user" name="S_user" value="{{ old('S_user') }}">
                            @error('S_user')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="S_national_id" class="h4">الرقم الوطني للمرسل</label>
                            <input type="text" class="form-control @error('S_national_id') error @enderror h6 mr-3 bg-gradient-light p-2"
                                   id="S_national_id" name="S_national_id" value="{{ old('S_national_id') }}">
                            @error('S_national_id')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="S_phone_number" class="h4">رقم هاتف المرسل</label>
                            <input type="text" class="form-control @error('S_phone_number') error @enderror h6 mr-3 bg-gradient-light p-2"
                                   id="S_phone_number" name="S_phone_number" value="{{ old('S_phone_number') }}">
                            @error('S_phone_number')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="S_mother_name" class="h4">اسم والدة المرسل</label>
                            <input type="text" class="form-control @error('S_mother_name') error @enderror h6 mr-3 bg-gradient-light p-2"
                                   id="S_mother_name" name="S_mother_name" value="{{ old('S_mother_name') }}">
                            @error('S_mother_name')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-column">
                        <div class="form-group mt-3">
                            <label for="S_Location" class="h4">موقع المرسل</label>
                            <input type="text" class="form-control @error('S_Location') error @enderror h6 mr-3 bg-gradient-light p-2"
                                   id="S_Location" name="S_Location" value="{{ old('S_Location') }}">
                            @error('S_Location')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="S_family_registration" class="h4">تسجيل العائلة للمرسل</label>
                            <input type="text" class="form-control @error('S_family_registration') error @enderror h6 mr-3 bg-gradient-light p-2"
                                   id="S_family_registration" name="S_family_registration" value="{{ old('S_family_registration') }}">
                            @error('S_family_registration')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>تفاصيل المستلم</h3>
                <div class="form-group mt-3">
                    <label for="R_user" class="h4">اسم المستلم</label>
                    <input type="text" class="form-control @error('R_user') error @enderror h6 mr-3 bg-gradient-light w-50 p-2"
                           id="R_user" name="R_user" value="{{ old('R_user') }}">
                    @error('R_user')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="R_phone_number" class="h4">رقم هاتف المستلم</label>
                    <input type="text" class="form-control @error('R_phone_number') error @enderror h6 mr-3 bg-gradient-light w-50 p-2"
                           id="R_phone_number" name="R_phone_number" value="{{ old('R_phone_number') }}">
                    @error('R_phone_number')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h3>البضائع الواردة</h3>
                <div id="goodsContainer">
                    <div class="good-input-group mt-3">
                        <div class="form-group">
                            <label for="incoming_goods[0][good_name]" class="h4">اسم البضاعة</label>
                            <input type="text" class="form-control h6 mr-3 bg-gradient-light w-50 p-2" name="incoming_goods[0][good_name]" required>
                        </div>
                        <div class="form-group">
                            <label for="incoming_goods[0][quantity]" class="h4">الكمية</label>
                            <input type="number" class="form-control h6 mr-3 bg-gradient-light w-50 p-2" name="incoming_goods[0][quantity]" required>
                        </div>
                        <div class="form-group">
                            <label for="incoming_goods[0][weight]" class="h4">الوزن</label>
                            <select class="form-control h6 mr-3 bg-gradient-light w-50 p-2" name="incoming_goods[0][weight]" required>
                                <option value="under_5">أقل من 5</option>
                                <option value="under_20">أقل من 20</option>
                                <option value="under_40">أقل من 40</option>
                                <option value="under_60">أقل من 60</option>
                            </select>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label for="incoming_goods[0][volume]" class="h4">الحجم</label>--}}
{{--                            <input type="number" step="0.01" class="form-control h6 mr-3 bg-gradient-light w-50 p-2" name="incoming_goods[0][volume]" required>--}}
{{--                        </div>--}}
                    </div>
                    <br><br>
                </div>
                <button type="button" class="btn btn-secondary mt-3" id="addGoodButton">إضافة بضاعة</button>
            </div>

            <div class="form-navigation">
                <button type="button" class="btn btn-secondary" id="prevButton">السابق</button>
                <button type="button" class="btn btn-primary" id="nextButton">التالي</button>
                <button type="button" class="btn btn-success" id="showModalButton">مراجعة الطلب</button>
            </div>
        </form>

        <!-- Modal Structure -->
        <div class="modal fade" id="confirmOrderModal" tabindex="-1" aria-labelledby="confirmOrderModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmOrderModalLabel">تأكيد الطلب</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4>المجموع الكلي:</h4>
                        <p id="totalPriceText"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <!-- Submit button that submits the form -->
                        <button type="submit" class="btn btn-success" form="orderForm">إنشاء الطلب</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
