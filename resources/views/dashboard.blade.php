{{--<x-app-layout>--}}
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">--}}
{{--            {{ __('Dashboard') }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

{{--    <div class="py-12">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
{{--            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">--}}
{{--                <div class="p-6 text-gray-900 dark:text-gray-100">--}}
{{--                    {{ __("You're logged in!") }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</x-app-layout>--}}
@extends('layouts.master')
@section('scripts')
<script>
    function fetchDashboardData() {
        fetch('/dashboard-data')
            .then(response => response.json())
            .then(data => {
                document.getElementById('office-count').innerText = data.office;
                document.getElementById('truck-count').innerText = data.truck;
                document.getElementById('employee-count').innerText = data.employee;
                document.getElementById('appClient-count').innerText = data.appClient;
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Fetch data every 5 seconds
    setInterval(fetchDashboardData, 2000);

    // Fetch data immediately when the page loads
    fetchDashboardData();
</script>

@endsection
@section('content')


<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-3 col-sm-6 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">store</i>
                    </div>
                    <div class="text-start pt-1">
                        <p class="text-sm mb-0 text-capitalize">عدد المكاتب</p>
                        <h4 class="mt-3" id="office-count">{{$data['office']}}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
{{--                    <p class="mb-0 text-start"><span class="text-success text-sm font-weight-bolder ms-1">+55% </span></p>--}}
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">directions_bus</i>
                    </div>
                    <div class="text-start pt-1">
                        <p class="text-sm mb-0 text-capitalize">عدد الشاحنات</p>
                        <h4 class="mt-3" id="truck-count">{{$data['truck']}}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
{{--                    <p class="mb-0 text-start"><span class="text-success text-sm font-weight-bolder ms-1">+33% </span>من الأسبوع الماضي</p>--}}
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">groupe</i>
                    </div>
                    <div class="text-start pt-1">
                        <p class="text-sm mb-0 text-capitalize">عدد الموظفين</p>
                        <h4 class="mt-3" id="employee-count">
                            <span class="text-danger text-sm font-weight-bolder ms-1"></span>
                            {{$data['employee']}}
                        </h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
{{--                    <p class="mb-0 text-start"><span class="text-success text-sm font-weight-bolder ms-1">+5% </span>من الشهر الماضي</p>--}}
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">person_add</i>
                    </div>
                    <div class="text-start pt-1">
                        <p class="text-sm mb-0 text-capitalize">مستخدمو التطبيق</p>
                        <h4 class="mt-3" id="appClient-count">{{$data['appClient']}}</h4>
                    </div>
                </div>
<hr class="dark horizontal my-0">
                <div class="card-footer p-3">
{{--                    <p class="mb-0 text-start"><span class="text-success text-sm font-weight-bolder ms-1"> </span></p>--}}
                </div>
            </div>
        </div>
    </div>
{{--    <div class="row mt-4">--}}
{{--        <div class="col-lg-4 col-md-6 mt-4 mb-4">--}}
{{--            <div class="card z-index-2 ">--}}
{{--                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">--}}
{{--                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">--}}
{{--                        <div class="chart">--}}
{{--                            <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <h6 class="mb-0 ">مشاهدات الموقع</h6>--}}
{{--                    <p class="text-sm ">آخر أداء للحملة</p>--}}
{{--                    <hr class="dark horizontal">--}}
{{--                    <div class="d-flex ">--}}
{{--                        <i class="material-icons text-sm my-auto ms-1">schedule</i>--}}
{{--                        <p class="mb-0 text-sm"> الحملة أرسلت قبل يومين </p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-lg-4 col-md-6 mt-4 mb-4">--}}
{{--            <div class="card z-index-2  ">--}}
{{--                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">--}}
{{--                    <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">--}}
{{--                        <div class="chart">--}}
{{--                            <canvas id="chart-line" class="chart-canvas" height="170"></canvas>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <h6 class="mb-0 "> المبيعات اليومية </h6>--}}
{{--                    <p class="text-sm "> (<span class="font-weight-bolder">+15%</span>) زيادة في مبيعات اليوم. </p>--}}
{{--                    <hr class="dark horizontal">--}}
{{--                    <div class="d-flex ">--}}
{{--                        <i class="material-icons text-sm my-auto ms-1">schedule</i>--}}
{{--                        <p class="mb-0 text-sm"> تم التحديث منذ 4 دقائق </p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-lg-4 mt-4 mb-3">--}}
{{--            <div class="card z-index-2 ">--}}
{{--                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">--}}
{{--                    <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">--}}
{{--                        <div class="chart">--}}
{{--                            <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <h6 class="mb-0 ">المهام المكتملة</h6>--}}
{{--                    <p class="text-sm ">آخر أداء للحملة</p>--}}
{{--                    <hr class="dark horizontal">--}}
{{--                    <div class="d-flex ">--}}
{{--                        <i class="material-icons text-sm my-auto me-1">schedule</i>--}}
{{--                        <p class="mb-0 text-sm">تم تحديثه للتو</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row my-4">--}}
{{--        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header pb-0">--}}
{{--                    <div class="row mb-3">--}}
{{--                        <div class="col-6">--}}
{{--                            <h6>المشاريع</h6>--}}
{{--                            <p class="text-sm">--}}
{{--                                <i class="fa fa-check text-info" aria-hidden="true"></i>--}}
{{--                                <span class="font-weight-bold ms-1">30 انتهى</span> هذا الشهر--}}
{{--                            </p>--}}
{{--                        </div>--}}
{{--                        <div class="col-6 my-auto text-start">--}}
{{--                            <div class="dropdown float-start ps-4">--}}
{{--                                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                                    <i class="fa fa-ellipsis-v text-secondary"></i>--}}
{{--                                </a>--}}
{{--                                <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-n4" aria-labelledby="dropdownTable">--}}
{{--                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">عمل</a></li>--}}
{{--                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">عمل آخر</a></li>--}}
{{--                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">شيء آخر هنا</a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card-body p-0 pb-2">--}}
{{--                    <div class="table-responsive">--}}
{{--                        <table class="table align-items-center mb-0">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">المشروع</th>--}}
{{--                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">أعضاء</th>--}}
{{--                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ميزانية</th>--}}
{{--                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">إكمال</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            <tr>--}}
{{--                                <td>--}}
{{--                                    <div class="d-flex px-2 py-1">--}}
{{--                                        <div>--}}
{{--                                            <img src="../assets/img/small-logos/logo-xd.svg" class="avatar avatar-sm ms-3">--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex flex-column justify-content-center">--}}
{{--                                            <h6 class="mb-0 text-sm">Material XD الإصدار</h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <div class="avatar-group mt-2">--}}
{{--                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">--}}
{{--                                            <img alt="Image placeholder" src="../assets/img/team-1.jpg">--}}
{{--                                        </a>--}}
{{--                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">--}}
{{--                                            <img alt="Image placeholder" src="../assets/img/team-2.jpg">--}}
{{--                                        </a>--}}
{{--                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Alexander Smith">--}}
{{--                                            <img alt="Image placeholder" src="../assets/img/team-3.jpg">--}}
{{--                                        </a>--}}
{{--                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">--}}
{{--                                            <img alt="Image placeholder" src="../assets/img/team-4.jpg">--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="align-middle text-center text-sm">--}}
{{--                                    <span class="text-xs font-weight-bold"> $14,000 </span>--}}
{{--                                </td>--}}
{{--                                <td class="align-middle">--}}
{{--                                    <div class="progress-wrapper w-75 mx-auto">--}}
{{--                                        <div class="progress-info">--}}
{{--                                            <div class="progress-percentage">--}}
{{--                                                <span class="text-xs font-weight-bold">60%</span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="progress">--}}
{{--                                            <div class="progress-bar bg-gradient-info w-60" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>--}}
{{--                                    <div class="d-flex px-2 py-1">--}}
{{--                                        <div>--}}
{{--                                            <img src="../assets/img/small-logos/logo-atlassian.svg" class="avatar avatar-sm ms-3">--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex flex-column justify-content-center">--}}
{{--                                            <h6 class="mb-0 text-sm">أضف مسار التقدم إلى التطبيق الداخلي</h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <div class="avatar-group mt-2">--}}
{{--                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">--}}
{{--                                            <img alt="Image placeholder" src="../assets/img/team-2.jpg">--}}
{{--                                        </a>--}}
{{--                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">--}}
{{--                                            <img alt="Image placeholder" src="../assets/img/team-4.jpg">--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="align-middle text-center text-sm">--}}
{{--                                    <span class="text-xs font-weight-bold"> $3,000 </span>--}}
{{--                                </td>--}}
{{--                                <td class="align-middle">--}}
{{--                                    <div class="progress-wrapper w-75 mx-auto">--}}
{{--                                        <div class="progress-info">--}}
{{--                                            <div class="progress-percentage">--}}
{{--                                                <span class="text-xs font-weight-bold">10%</span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="progress">--}}
{{--                                            <div class="progress-bar bg-gradient-info w-10" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>--}}
{{--                                    <div class="d-flex px-2 py-1">--}}
{{--                                        <div>--}}
{{--                                            <img src="../assets/img/small-logos/logo-slack.svg" class="avatar avatar-sm ms-3">--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex flex-column justify-content-center">--}}
{{--                                            <h6 class="mb-0 text-sm">إصلاح أخطاء النظام الأساسي</h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <div class="avatar-group mt-2">--}}
{{--                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">--}}
{{--                                            <img alt="Image placeholder" src="../assets/img/team-3.jpg">--}}
{{--                                        </a>--}}
{{--                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">--}}
{{--                                            <img alt="Image placeholder" src="../assets/img/team-1.jpg">--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="align-middle text-center text-sm">--}}
{{--                                    <span class="text-xs font-weight-bold"> غير مضبوط </span>--}}
{{--                                </td>--}}
{{--                                <td class="align-middle">--}}
{{--                                    <div class="progress-wrapper w-75 mx-auto">--}}
{{--                                        <div class="progress-info">--}}
{{--                                            <div class="progress-percentage">--}}
{{--                                                <span class="text-xs font-weight-bold">100%</span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="progress">--}}
{{--                                            <div class="progress-bar bg-gradient-success w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>--}}
{{--                                    <div class="d-flex px-2 py-1">--}}
{{--                                        <div>--}}
{{--                                            <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm ms-3">--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex flex-column justify-content-center">--}}
{{--                                            <h6 class="mb-0 text-sm">إطلاق تطبيق الهاتف المحمول الخاص بنا</h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <div class="avatar-group mt-2">--}}
{{--                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">--}}
{{--                                            <img alt="Image placeholder" src="../assets/img/team-4.jpg">--}}
{{--                                        </a>--}}
{{--                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">--}}
{{--                                            <img alt="Image placeholder" src="../assets/img/team-3.jpg">--}}
{{--                                        </a>--}}
{{--                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Alexander Smith">--}}
{{--                                            <img alt="Image placeholder" src="../assets/img/team-4.jpg">--}}
{{--                                        </a>--}}
{{--                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">--}}
{{--                                            <img alt="Image placeholder" src="../assets/img/team-1.jpg">--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="align-middle text-center text-sm">--}}
{{--                                    <span class="text-xs font-weight-bold"> $20,500 </span>--}}
{{--                                </td>--}}
{{--                                <td class="align-middle">--}}
{{--                                    <div class="progress-wrapper w-75 mx-auto">--}}
{{--                                        <div class="progress-info">--}}
{{--                                            <div class="progress-percentage">--}}
{{--                                                <span class="text-xs font-weight-bold">100%</span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="progress">--}}
{{--                                            <div class="progress-bar bg-gradient-success w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>--}}
{{--                                    <div class="d-flex px-2 py-1">--}}
{{--                                        <div>--}}
{{--                                            <img src="../assets/img/small-logos/logo-jira.svg" class="avatar avatar-sm ms-3">--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex flex-column justify-content-center">--}}
{{--                                            <h6 class="mb-0 text-sm">أضف صفحة التسعير الجديدة</h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <div class="avatar-group mt-2">--}}
{{--                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">--}}
{{--                                            <img alt="Image placeholder" src="../assets/img/team-4.jpg">--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="align-middle text-center text-sm">--}}
{{--                                    <span class="text-xs font-weight-bold"> $500 </span>--}}
{{--                                </td>--}}
{{--                                <td class="align-middle">--}}
{{--                                    <div class="progress-wrapper w-75 mx-auto">--}}
{{--                                        <div class="progress-info">--}}
{{--                                            <div class="progress-percentage">--}}
{{--                                                <span class="text-xs font-weight-bold">25%</span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="progress">--}}
{{--                                            <div class="progress-bar bg-gradient-info w-25" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="25"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>--}}
{{--                                    <div class="d-flex px-2 py-1">--}}
{{--                                        <div>--}}
{{--                                            <img src="../assets/img/small-logos/logo-invision.svg" class="avatar avatar-sm ms-3">--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex flex-column justify-content-center">--}}
{{--                                            <h6 class="mb-0 text-sm">إعادة تصميم متجر جديد على الإنترنت</h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <div class="avatar-group mt-2">--}}
{{--                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">--}}
{{--                                            <img alt="Image placeholder" src="../assets/img/team-1.jpg">--}}
{{--                                        </a>--}}
{{--                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">--}}
{{--                                            <img alt="Image placeholder" src="../assets/img/team-4.jpg">--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="align-middle text-center text-sm">--}}
{{--                                    <span class="text-xs font-weight-bold"> $2,000 </span>--}}
{{--                                </td>--}}
{{--                                <td class="align-middle">--}}
{{--                                    <div class="progress-wrapper w-75 mx-auto">--}}
{{--                                        <div class="progress-info">--}}
{{--                                            <div class="progress-percentage">--}}
{{--                                                <span class="text-xs font-weight-bold">40%</span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="progress">--}}
{{--                                            <div class="progress-bar bg-gradient-info w-40" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="40"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-lg-4 col-md-6">--}}
{{--            <div class="card h-100">--}}
{{--                <div class="card-header pb-0">--}}
{{--                    <h6>نظرة عامة على الطلبات</h6>--}}
{{--                    <p class="text-sm">--}}
{{--                        <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>--}}
{{--                        <span class="font-weight-bold">24%</span> هذا الشهر--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--                <div class="card-body p-3">--}}
{{--                    <div class="timeline timeline-one-side">--}}
{{--                        <div class="timeline-block mb-3">--}}
{{--                  <span class="timeline-step">--}}
{{--                    <i class="material-icons text-success text-gradient">notifications</i>--}}
{{--                  </span>--}}
{{--                            <div class="timeline-content">--}}
{{--                                <h6 class="text-dark text-sm font-weight-bold mb-0">$2400, تغييرات في التصميم</h6>--}}
{{--                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:20 PM</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="timeline-block mb-3">--}}
{{--                  <span class="timeline-step">--}}
{{--                    <i class="material-icons text-danger text-gradient">code</i>--}}
{{--                  </span>--}}
{{--                            <div class="timeline-content">--}}
{{--                                <h6 class="text-dark text-sm font-weight-bold mb-0">طلب جديد #1832412</h6>--}}
{{--                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 11 PM</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="timeline-block mb-3">--}}
{{--                  <span class="timeline-step">--}}
{{--                    <i class="material-icons text-info text-gradient">shopping_cart</i>--}}
{{--                  </span>--}}
{{--                            <div class="timeline-content">--}}
{{--                                <h6 class="text-dark text-sm font-weight-bold mb-0">مدفوعات الخادم لشهر أبريل</h6>--}}
{{--                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 9:34 PM</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="timeline-block mb-3">--}}
{{--                  <span class="timeline-step">--}}
{{--                    <i class="material-icons text-warning text-gradient">credit_card</i>--}}
{{--                  </span>--}}
{{--                            <div class="timeline-content">--}}
{{--                                <h6 class="text-dark text-sm font-weight-bold mb-0">تمت إضافة بطاقة جديدة للطلب #4395133</h6>--}}
{{--                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">20 DEC 2:20 AM</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="timeline-block mb-3">--}}
{{--                  <span class="timeline-step">--}}
{{--                    <i class="material-icons text-primary text-gradient">key</i>--}}
{{--                  </span>--}}
{{--                            <div class="timeline-content">--}}
{{--                                <h6 class="text-dark text-sm font-weight-bold mb-0">فتح الحزم من أجل التطوير</h6>--}}
{{--                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">18 DEC 4:54 AM</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="timeline-block">--}}
{{--                  <span class="timeline-step">--}}
{{--                    <i class="material-icons text-dark text-gradient">payments</i>--}}
{{--                  </span>--}}
{{--                            <div class="timeline-content">--}}
{{--                                <h6 class="text-dark text-sm font-weight-bold mb-0">طلب جديد #9583120</h6>--}}
{{--                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">17 DEC</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <footer class="footer py-4  ">--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row align-items-center justify-content-lg-between">--}}
{{--                <div class="col-lg-6 mb-lg-0 mb-4">--}}
{{--                    <div class="copyright text-center text-sm text-muted text-lg-end">--}}
{{--                        © <script>--}}
{{--                            document.write(new Date().getFullYear())--}}
{{--                        </script>,--}}
{{--                        made with <i class="fa fa-heart"></i> by--}}
{{--                        <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>--}}
{{--                        for a better web.--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-6">--}}
{{--                    <ul class="nav nav-footer justify-content-center justify-content-lg-end">--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </footer>--}}
{{--</div>--}}

@endsection
