<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $restaurant = \App\Models\Restaurant::where('user_id', $user->id)->first();
        if (!$restaurant) {
            return redirect()->route('restaurant.dashboard')->with('error', 'Restoran bilgisi bulunamadı!');
        }
        return view('restaurant.profile', compact('user', 'restaurant'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $restaurant = \App\Models\Restaurant::where('user_id', $user->id)->first();
        if (!$restaurant) {
            return redirect()->route('restaurant.dashboard')->with('error', 'Restoran bilgisi bulunamadı!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $restaurant->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => \Hash::make($request->password)
            ]);
        }

        return redirect()->route('restaurant.profile.show')->with('success', 'Profil başarıyla güncellendi.');
    }
} 