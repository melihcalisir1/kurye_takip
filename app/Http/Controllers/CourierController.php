<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    public function index(Restaurant $restaurant)
    {
        $couriers = $restaurant->couriers;
        return view('admin.couriers', compact('restaurant', 'couriers'));
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'plate' => 'required|string|max:20',
            'status' => 'required|in:active,inactive'
        ]);

        $restaurant->couriers()->create($validated);

        return redirect()->route('admin.restaurants.couriers', $restaurant)->with('success', 'Kurye başarıyla eklendi.');
    }

    public function update(Request $request, Restaurant $restaurant, Courier $courier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'plate' => 'required|string|max:20',
            'status' => 'required|in:active,inactive'
        ]);

        $courier->update($validated);

        return redirect()->route('admin.restaurants.couriers', $restaurant)->with('success', 'Kurye başarıyla güncellendi.');
    }

    public function destroy(Restaurant $restaurant, Courier $courier)
    {
        $courier->delete();
        return redirect()->route('admin.restaurants.couriers', $restaurant)->with('success', 'Kurye başarıyla silindi.');
    }
} 