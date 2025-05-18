<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return 'Hoş geldin! Giriş başarılı.';
});

Route::get('/admin', function () {
    return view('admin');
});
Route::get('/restaurant', function () {
    return view('restaurant');
});
Route::get('/courier', function () {
    return view('courier');
});
