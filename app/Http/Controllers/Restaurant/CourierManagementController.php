<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CourierManagementController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $userId = auth()->id();
        $restaurant = \App\Models\Restaurant::where('user_id', $userId)->first();

        if (!$restaurant) {
            return redirect()->route('restaurant.dashboard')->with('error', 'Restoran bilgisi bulunamadı!');
        }

        $couriers = $restaurant->couriers()->with(['user', 'orders' => function($q) {
            $q->where('status', 'delivered')
              ->whereDate('delivered_at', today());
        }])->get();

        return view('restaurant.couriers.index', compact('couriers'));
    }

    public function create()
    {
        return view('restaurant.couriers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'courier'
        ]);

        $courier = $user->courier()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'plate' => 'PLAKA-' . strtoupper(Str::random(6)),
            'status' => 'active',
            'restaurant_id' => \App\Models\Restaurant::where('user_id', auth()->id())->value('id'),
        ]);

        return redirect()->route('restaurant.couriers.index')
            ->with('success', 'Kurye başarıyla eklendi.');
    }

    public function show(Courier $courier)
    {
        
        $todayDeliveries = $courier->orders()
            ->where('status', 'delivered')
            ->whereDate('delivered_at', today())
            ->count();
            
        $monthlyDeliveries = $courier->orders()
            ->where('status', 'delivered')
            ->whereMonth('delivered_at', now()->month)
            ->count();
            
        $activeOrders = $courier->orders()
            ->whereIn('status', ['assigned', 'picked_up'])
            ->get();
            
        $recentDeliveries = $courier->orders()
            ->where('status', 'delivered')
            ->orderBy('delivered_at', 'desc')
            ->take(10)
            ->get();

        return view('restaurant.couriers.show', compact(
            'courier', 
            'todayDeliveries', 
            'monthlyDeliveries',
            'activeOrders',
            'recentDeliveries'
        ));
    }

    public function edit(Courier $courier)
    {
        return view('restaurant.couriers.edit', compact('courier'));
    }

    public function update(Request $request, Courier $courier)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $courier->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);

        if ($request->filled('password')) {
            $courier->user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('restaurant.couriers.show', $courier)
            ->with('success', 'Kurye bilgileri güncellendi.');
    }

    public function destroy(Courier $courier)
    {
        
        $courier->user->delete();
        $courier->delete();

        return redirect()->route('restaurant.couriers.index')
            ->with('success', 'Kurye başarıyla silindi.');
    }

    public function toggleStatus(Courier $courier)
    {
        
        $courier->update([
            'status' => $courier->status === 'active' ? 'inactive' : 'active'
        ]);

        return back()->with('success', 'Kurye durumu güncellendi.');
    }
} 