
    {{--    <div class="sidenav-header">--}}
    {{--        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute start-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>--}}
    {{--        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">--}}
    {{--            <img src="../assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">--}}
    {{--            <span class="me-1 font-weight-bold text-white">Material Dashboard 2</span>--}}
    {{--        </a>--}}
    {{--    </div>--}}
    <hr class="horizontal light mt-0 mb-2">
{{--    @if(auth()->user()->hasRole('superAdmin'))--}}
{{--        @include('layouts.side_bar.sperAdminSidebar')--}}
{{--    @elseif(auth()->user()->hasRole('admin'))--}}
{{--        @include('layouts.side_bar.adminSidebar')--}}
{{--    @elseif(auth()->user()->hasRole('officer'))--}}
{{--        @include('layouts.side_bar.officerSidebar')--}}
{{--    @else--}}

{{--    @endif--}}


    @include('layouts.side_bar.sperAdminSidebar')
