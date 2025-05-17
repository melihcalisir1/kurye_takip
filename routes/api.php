<?php

<<<<<<< HEAD
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SirketController;
use Illuminate\Http\Request;
=======
use App\Http\Controllers\Api\AuthController;
>>>>>>> 50735df (Kurye Takip projesi: login, rol bazlı yönlendirme, modern arayüz ve seeder eklendi)
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

<<<<<<< HEAD
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::middleware(['auth:sanctum', 'role:admin'])->post('/admin/create-sirket', [AdminController::class, 'createSirketSahibi']);


Route::middleware(['auth:sanctum', 'role:şirket_sahibi'])
    ->post('/sirket/create-kurye', [SirketController::class, 'createKurye']);

Route::middleware(['auth:sanctum', 'role:musteri'])
    ->post('/orders', [OrderController::class, 'store']);
=======


Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('/test', function () {
    return 'API çalışıyor';
}); 
>>>>>>> 50735df (Kurye Takip projesi: login, rol bazlı yönlendirme, modern arayüz ve seeder eklendi)
