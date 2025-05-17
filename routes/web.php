<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', function() {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/restaurant/dashboard', function() {
    return view('restaurant.dashboard');
})->name('restaurant.dashboard');

Route::get('/courier/dashboard', function() {
    return view('courier.dashboard');
})->name('courier.dashboard');
