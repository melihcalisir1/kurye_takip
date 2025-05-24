<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function getStats()
    {
        $totalRestaurants = Restaurant::count();
        $activeRestaurants = Restaurant::where('status', 'active')->count();
        $inactiveRestaurants = Restaurant::where('status', 'inactive')->count();
        $totalCouriers = Restaurant::withCount('couriers')->get()->sum('couriers_count');

        return [
            'totalRestaurants' => $totalRestaurants,
            'activeRestaurants' => $activeRestaurants,
            'inactiveRestaurants' => $inactiveRestaurants,
            'totalCouriers' => $totalCouriers
        ];
    }

    public function index()
    {
        $restaurants = Restaurant::withCount('couriers')->get();
        return view('admin.restaurants', compact('restaurants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'status' => 'required|in:active,inactive'
        ]);

        // Otomatik e-posta ve şifre oluştur
        $email = Str::slug($request->name) . rand(1000, 9999) . '@restoran.com';
        $password = Str::random(8);

        // Users tablosuna ekle
        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => 'restaurant',
        ]);

        // Restoranı oluştur
        Restaurant::create([
            ...$validated,
            'user_id' => $user->id
        ]);

        // Başarı mesajı ile birlikte giriş bilgilerini göster
        return redirect()->route('admin.restaurants')->with('success', [
            'message' => 'Restoran başarıyla eklendi.',
            'credentials' => [
                'email' => $email,
                'password' => $password
            ]
        ]);
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'status' => 'required|in:active,inactive'
        ]);

        $restaurant->update($validated);

        return redirect()->route('admin.restaurants')->with('success', 'Restoran başarıyla güncellendi.');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return redirect()->route('admin.restaurants')->with('success', 'Restoran başarıyla silindi.');
    }

    public function dashboard()
    {
        $restaurant = Restaurant::where('user_id', Auth::user()->id)->with('couriers')->first();
        
        if (!$restaurant) {
            return redirect()->route('login')->with('error', 'Restoran bulunamadı.');
        }
        
        return view('restaurant.dashboard', compact('restaurant'));
    }
} 