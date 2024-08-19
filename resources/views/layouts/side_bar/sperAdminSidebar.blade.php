<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-end me-3 rotate-caret  bg-gradient-dark" id="sidenav-main">
<div class="collapse navbar-collapse px-0 w-auto " id="sidenav-collapse-main">

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() === 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <div class="text-white text-center ms-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons-round opacity-10">dashboard</i>
                </div>
                <span class="nav-link-text me-1">لوحة القيادة</span>
            </a>
        </li>
        <!-- العناصر الأخرى من القائمة -->
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() === 'offices.index' ? 'active' : '' }}"  href="{{ route('offices.index') }}">
                <div class="text-white text-center ms-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons-round opacity-10">store</i>
                </div>
                <span class="nav-link-text me-1">المكاتب</span>
            </a>
        </li>
        @if(auth()->user()->hasRole('superAdmin'))
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() === 'employees.index' ? 'active' : '' }}"  href="{{ route('employees.index') }}">
            <div class="text-white text-center ms-2 d-flex align-items-center justify-content-center">
                <i class="material-icons-round opacity-10">group</i>
            </div>
            <span class="nav-link-text me-1">الموظفين</span>
        </a>
    </li>
        @endif
        <li class="nav-item position-relative">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="text-white text-center ms-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons-round opacity-10">local_grocery_store</i>
                </div>
                <span class="nav-link-text me-1">الطلبات</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark position-absolute top-0" aria-labelledby="navbarDropdown">
                @if(!auth()->user()->hasRole('superAdmin'))    <li><a class="dropdown-item" href="{{ route('orders.create') }}">طلب جديد</a></li>@endif
                <li><a class="dropdown-item" href="{{ route('orders.index') }}">الطلبات</a></li>
                <li><a class="dropdown-item" href="{{ route('orders.index', ['status' => 'جاري المعالجة']) }}">طلب قيد المعالجة</a></li>
                <li><a class="dropdown-item" href="{{ route('orders.index', ['status' => 'مكتمل']) }}">طلبات مكتملة</a></li>
            </ul>

        </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() === 'trucks.index' ? 'active' : '' }}"  href="{{ route('trucks.index') }}">
            <div class="text-white text-center ms-2 d-flex align-items-center justify-content-center">
                <i class="material-icons-round opacity-10">directions_bus</i>
            </div>
            <span class="nav-link-text me-1">الشاحنات</span>
        </a>
    </li>
        <li class="nav-item">
            <a class="nav-link  {{ Route::currentRouteName() === 'drivers.index' ? 'active' : '' }}"  href="{{ route('drivers.index') }}">
                <div class="text-white text-center ms-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons-round opacity-10">group</i>
                </div>
                <span class="nav-link-text me-1">السائقون</span>
            </a>
        </li>
        @if(auth()->user()->hasRole('superAdmin'))
        <li class="nav-item">
            <a class="nav-link  {{ Route::currentRouteName() === 'variable-values.index' ? 'active' : '' }}"  href="{{ route('variable-values.index') }}">
                <div class="text-white text-center ms-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons-round opacity-10">view_in_ar</i>
                </div>
                <span class="nav-link-text me-1">تسعير</span>
            </a>
        </li>
        @endif
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link active" href="../pages/rtl.html">--}}
{{--            <div class="text-white text-center ms-2 d-flex align-items-center justify-content-center">--}}
{{--                <i class="material-icons-round opacity-10">format_textdirection_r_to_l</i>--}}
{{--            </div>--}}
{{--            <span class="nav-link-text me-1">RTL</span>--}}
{{--        </a>--}}
{{--    </li>--}}
    <li class="nav-item">
        <a class="nav-link  {{ Route::currentRouteName() === 'deposit.form' ? 'active' : '' }}"  href="{{ route('deposit.form') }}">
            <div class="text-white text-center ms-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">attach_money</i>
            </div>
            <span class="nav-link-text me-1">شحن حساب</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link  {{ Route::currentRouteName() === 'profile.edit' ? 'active' : '' }}"  href="{{ route('profile.edit') }}">
            <div class="text-white text-center ms-2 d-flex align-items-center justify-content-center">
                <i class="material-icons-round opacity-10">person</i>
            </div>
            <span class="nav-link-text me-1">حساب تعريفي</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() === 'trips.index' ? 'active' : '' }}"  href="{{ route('trips.index') }}" >
            <div class="text-white text-center ms-2 d-flex align-items-center justify-content-center">
                <i class="material-icons-round opacity-10">event_note</i>
            </div>
            <span class="nav-link-text me-1">الرحلات</span>
        </a>
    </li>
        @if(auth()->user()->hasRole('superAdmin'))
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() === 'download.report' ? 'active' : '' }}"  href="{{ route('download.report') }}" >
                <div class="text-white text-center ms-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons-round opacity-10">assessment</i>
                </div>
                <span class="nav-link-text me-1">تحميل تقرير</span>
            </a>
        </li>
        @endif
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link " >--}}
{{--                <div class="text-white text-center ms-2 d-flex align-items-center justify-content-center">--}}
{{--                    <i class="material-icons-round opacity-10">login</i>--}}
{{--                </div>--}}
{{--                <span class="nav-link-text me-1">تسجيل الدخول</span>--}}
{{--            </a>--}}
{{--        </li>--}}
</ul>
</div>
</aside>
