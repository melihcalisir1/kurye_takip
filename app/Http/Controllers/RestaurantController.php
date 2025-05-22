<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

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

        Restaurant::create($validated);

        return redirect()->route('admin.restaurants')->with('success', 'Restoran başarıyla eklendi.');
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
} 