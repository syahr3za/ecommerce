<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TestimonyController;
use Illuminate\Support\Facades\Route;

// Admin routes
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout']);

// Member routes
Route::get('login_member', [AuthController::class, 'login_member']);
Route::post('login_member', [AuthController::class, 'login_member_action']);
Route::get('logout_member', [AuthController::class, 'logout_member']);
Route::get('register_member', [AuthController::class, 'register_member']);
Route::post('register_member', [AuthController::class, 'register_member_action']);

// Dashboard routes
Route::get('/dashboard', [DashboardController::class, 'index']);

// Categories routes
Route::get('/categories', [CategoryController::class, 'list']);

// Sub Categories routes
Route::get('/sub_categories', [SubCategoryController::class, 'list']);

// Sliders routes
Route::get('/sliders', [SliderController::class, 'list']);

// Products routes
Route::get('/products', [ProductController::class, 'list']);

// Testimonies routes
Route::get('/testimonies', [TestimonyController::class, 'list']);

// Review routes
Route::get('/reviews', [ReviewController::class, 'list']);

// Order routes
Route::get('/order/new', [OrderController::class, 'list']);
Route::get('/order/confirmed', [OrderController::class, 'confirmed_list']);
Route::get('/order/sent', [OrderController::class, 'sent_list']);
Route::get('/order/packed', [OrderController::class, 'packed_list']);
Route::get('/order/accepted', [OrderController::class, 'accepted_list']);
Route::get('/order/finished', [OrderController::class, 'finished_list']);

// Report routes
Route::get('/report', [ReportController::class, 'index']);

// Payment routes
Route::get('/payments', [PaymentController::class, 'list']);

// About routes
Route::get('/abouts', [AboutController::class, 'index']);
Route::post('/abouts/{about}', [AboutController::class, 'update']);

// Home routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/products/{category}', [HomeController::class, 'products']);
Route::get('/product/{id}', [HomeController::class, 'product']);
Route::get('/cart', [HomeController::class, 'cart']);
Route::get('/checkout', [HomeController::class, 'checkout']);
Route::get('/orders', [HomeController::class, 'orders']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::post('/add_to_cart', [HomeController::class, 'add_to_cart']);
Route::get('/delete_from_cart/{cart}', [HomeController::class, 'delete_from_cart']);
Route::get('/get_city/{id}', [HomeController::class, 'get_city']);
Route::get('/get_shipping/{destination}/{weight}', [HomeController::class, 'get_shipping']);
Route::post('/checkout_orders', [HomeController::class, 'checkout_orders']);
Route::post('/payments', [HomeController::class, 'payments']);
