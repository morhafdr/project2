<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Client\OrderController;
use App\Http\Controllers\API\DeliveryController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\API\SMSController;
use App\Http\Controllers\WEB\FavouriteController;
use App\Http\Controllers\WEB\GovernorateController;
use App\Http\Controllers\WEB\OfficeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

        Route::post('send/SMS',[SMSController::class, 'sendSMS']);

        Route::post('/resendOTP', [AuthController::class, 'ResendOTP']);
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('logout', [AuthController::class, 'logout']);
            Route::get('company/details',[SMSController::class, 'index']);
            Route::post('/order/payment', [PaymentController::class, 'payment']);
            Route::post('/verifyOTP', [AuthController::class, 'VerifyOTP']);
            // Favourites routes
            Route::get('/office/location/{office}', [OfficeController::class, 'OfficeLocation']);
            Route::get('/favourites/{office}', [FavouriteController::class, 'add']);
            Route::get('/favourites', [FavouriteController::class, 'index']);
            Route::post('/users/{userId}/wallet/deposit', [PaymentController::class, 'deposit']);
            Route::post('wallet/withdraw', [PaymentController::class, 'withdraw']);
            // Notifications route
            Route::post('/send-notification', [NotificationController::class, 'send']);
            Route::get('/get-notification',[NotificationController::class, 'GetNotification']);
            Route::get('governorates',[GovernorateController::class,'governorates']);
            // Orders routes
            Route::post('/orders/create', [OrderController::class, 'store']);
            Route::get('/orders/user', [OrderController::class, 'showUserOrder']);
            Route::prefix('orders')->controller(OrderController::class)->group(function () {
                Route::get('/', 'index');
                Route::get('/{id}', 'show');
                Route::post('/{id}', 'update');
                Route::delete('/{id}', 'destroy');
            });
            Route::group(['prefix' => "/offices"], function () {
                Route::get('CG/{city?}/{governorate?}', [OfficeController::class, 'index']);
            });

       // Delivery routes
            Route::get('isOnline', [DeliveryController::class, 'updateOnlineStatus']);
            Route::get('Get/Order/location/{order}', [DeliveryController::class, 'OrderLocation']);
            Route::get('Set/delivery/order/{order}', [DeliveryController::class, 'SetDeliveryOrder']);
            Route::get('/update/order-state/{order}', [DeliveryController::class, 'updateOrderState']);
        });
        // Authentication routes
        Route::post('password/forget', [AuthController::class, 'ForgetPassword']);
        Route::post('password/reset', [AuthController::class, 'ResetPassword']);
        Route::post('validate/code', [AuthController::class, 'ValidateResetCode']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
