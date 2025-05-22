<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CourierController;
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

// Default Route
Route::get('/', function () {
    return redirect()->route('login');
});
