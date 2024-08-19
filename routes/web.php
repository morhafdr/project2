<?php

use App\Http\Controllers\WEB\DashboardController;
use App\Http\Controllers\WEB\DriverController;
use App\Http\Controllers\WEB\EmployeeController;
use App\Http\Controllers\WEB\GovernorateController;
use App\Http\Controllers\WEB\OfficeController;
use App\Http\Controllers\WEB\OrderController;
use App\Http\Controllers\WEB\PaymentController;
use App\Http\Controllers\WEB\PdfController;
use App\Http\Controllers\WEB\ProfileController;
use App\Http\Controllers\WEB\RateController;
use App\Http\Controllers\WEB\TripsController;
use App\Http\Controllers\WEB\TruckController;
use App\Http\Controllers\WEB\VariableValueController;
use App\Models\Trips;
use App\Models\VariableValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard',[DashboardController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard-data', [DashboardController::class, 'getDashboardData']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('offices', OfficeController::class);
    Route::get('governorates',[GovernorateController::class,'getDovernorates']);
    Route::resource('employees', EmployeeController::class);
    Route::resource('trucks', TruckController::class);
    Route::post('/rates', [RateController::class, 'store'])->name('rates.store');
    Route::resource('drivers',DriverController::class);
    Route::put('/orders/{id}/updateStatus', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::resource('orders',OrderController::class);
    Route::post('/trips/{trip}/update-status', [TripsController::class, 'updateStatus'])->name('trips.updateStatus');
    Route::resource('trips', TripsController::class);
    Route::get('/download-monthly-report', [PdfController::class, 'downloadMonthlyReport'])->name('download.report');

    Route::get('/payments/deposit', [PaymentController::class, 'showDepositForm'])->name('deposit.form');
    Route::post('/payments/deposit/{email}', [PaymentController::class, 'deposit'])->name('deposit');
    Route::post('/api/get-order-total', [OrderController::class, 'getOrderTotal']);
    Route::get('/order/delivery/{order}', [OrderController::class, 'delivery'])->name('order.delivery');
    Route::get('/calculate-price', [OrderController::class, 'calculatePrice']);
    Route::resource('variable-values', VariableValueController::class);
});

// Display a listing of the resource.


require __DIR__.'/auth.php';
