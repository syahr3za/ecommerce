<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TestimonyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function () {
    Route::post('admin', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    // Route::post('login', [AuthController::class, 'login_member']);
});

Route::group([
    'middleware' => 'api'
], function () {
    Route::resources([
        'categories' => CategoryController::class,
        'sub_categories' => SubCategoryController::class,
        'sliders' => SliderController::class,
        'products' => ProductController::class,
        'members' => MemberController::class,
        'testimonies' => TestimonyController::class,
        'reviews' => ReviewController::class,
        'orders' => OrderController::class,
        'payments' => PaymentController::class,
    ]);

    // Order Status
    Route::get('order/new', [OrderController::class, 'new']);
    Route::get('order/confirmed', [OrderController::class, 'confirmed']);
    Route::get('order/packed', [OrderController::class, 'packed']);
    Route::get('order/sent', [OrderController::class, 'sent']);
    Route::get('order/accepted', [OrderController::class, 'accepted']);
    Route::get('order/finished', [OrderController::class, 'finished']);
    Route::post('order/changeStatus/{order}', [OrderController::class, 'changeStatus']);

    // Report
    Route::get('reports', [ReportController::class, 'get_reports']);
});
