<?php

use App\Events\TestEvent;
use App\Http\Controllers\AuthController;
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
    return view('welcome');
});

Route::get('/test-event', function () {
    event(new TestEvent('Vue bileşenine selam Web üzerinden!'));
    return 'Event gönderildi!';
});



Route::get('/test', function () {
    return response()->json(['message' => 'Mobil bağlantı başarılı!']);
});
