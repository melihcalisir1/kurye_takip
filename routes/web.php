<?php

<<<<<<< HEAD
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
=======
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
>>>>>>> 50735df (Kurye Takip projesi: login, rol bazlı yönlendirme, modern arayüz ve seeder eklendi)
