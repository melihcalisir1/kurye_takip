<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourierController extends Controller
{
    public function index(Restaurant $restaurant)
    {
        $couriers = $restaurant->couriers;
        return view('admin.couriers', compact('restaurant', 'couriers'));
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        // Otomatik e-posta ve şifre oluştur
        $email = Str::slug($request->name) . '@kurye.com';
        $password = Str::random(8);

        // Önce users tablosuna ekle
        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => 'courier'
        ]);

        // Sonra kurye oluştur
        $courier = $restaurant->couriers()->create([
            'name' => $request->name,
            'email' => $email,
            'password' => bcrypt($password),
            'phone' => $request->phone,
            'status' => $request->status,
            'plate' => 'PLAKA-' . strtoupper(Str::random(6)), // Otomatik plaka oluştur
            'user_id' => $user->id // User ID'yi ekle
        ]);

        // Başarı mesajı ile birlikte giriş bilgilerini göster
        return redirect()->back()->with('success', [
            'message' => 'Kurye başarıyla eklendi.',
            'credentials' => [
                'email' => $email,
                'password' => $password
            ]
        ]);
    }

    public function update(Request $request, Restaurant $restaurant, Courier $courier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        // Kurye bilgilerini güncelle
        $courier->update($request->only(['name', 'phone', 'status']));

        // User bilgilerini de güncelle
        if ($courier->user) {
            $courier->user->update([
                'name' => $request->name
            ]);
        }

        return redirect()->back()->with('success', 'Kurye bilgileri güncellendi.');
    }

    public function destroy(Restaurant $restaurant, Courier $courier)
    {
        // Önce user'ı sil
        if ($courier->user) {
            $courier->user->delete();
        }
        
        // Sonra kuryeyi sil
        $courier->delete();
        
        return redirect()->back()->with('success', 'Kurye silindi.');
    }
} 