<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\CourierMapController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        $stats = app(RestaurantController::class)->getStats();
        return view('admin.dashboard', compact('stats'));
    })->name('admin.dashboard');

    // Restaurant Routes
    Route::get('/restaurants', [RestaurantController::class, 'index'])->name('admin.restaurants');
    Route::post('/restaurants', [RestaurantController::class, 'store'])->name('admin.restaurants.store');
    Route::put('/restaurants/{restaurant}', [RestaurantController::class, 'update'])->name('admin.restaurants.update');
    Route::delete('/restaurants/{restaurant}', [RestaurantController::class, 'destroy'])->name('admin.restaurants.destroy');

    // Courier Routes
    Route::get('/restaurants/{restaurant}/couriers', [CourierController::class, 'index'])->name('admin.restaurants.couriers');
    Route::post('/restaurants/{restaurant}/couriers', [CourierController::class, 'store'])->name('admin.restaurants.couriers.store');
    Route::put('/restaurants/{restaurant}/couriers/{courier}', [CourierController::class, 'update'])->name('admin.restaurants.couriers.update');
    Route::delete('/restaurants/{restaurant}/couriers/{courier}', [CourierController::class, 'destroy'])->name('admin.restaurants.couriers.destroy');
});

// Restoran Dashboard


Route::prefix('restaurant')->name('restaurant.')->group(function () {
    Route::get('/dashboard', function () {
        return view('restaurant.dashboard');
    })->name('dashboard');
    Route::get('/menus', [MenuController::class, 'index'])->name('menus');
    Route::get('/menus/create', [MenuController::class, 'create'])->name('menus.create');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/menus/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
});

// Kurye Dashboard
Route::get('/courier/dashboard', function () {
    return view('courier.dashboard');
})->name('courier.dashboard');

// Sipariş Yönetimi

// Default Route
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/courier-map', [CourierMapController::class, 'index'])->name('courier.map');
});


