<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourierController extends Controller
{
    public function index()
    {
        $restaurant = auth()->user()->restaurant;
        $couriers = $restaurant->couriers()
            ->withCount(['orders as today_deliveries' => function($query) {
                $query->whereDate('delivered_at', today())
                    ->where('status', 'delivered');
            }])
            ->withCount(['orders as total_deliveries' => function($query) {
                $query->where('status', 'delivered');
            }])
            ->get()
            ->map(function($courier) {
                // Performans hesaplama (son 7 günlük teslimat sayısı / önceki 7 günlük teslimat sayısı)
                $lastWeekDeliveries = Order::where('courier_id', $courier->id)
                    ->where('status', 'delivered')
                    ->whereBetween('delivered_at', [now()->subDays(7), now()])
                    ->count();
                
                $previousWeekDeliveries = Order::where('courier_id', $courier->id)
                    ->where('status', 'delivered')
                    ->whereBetween('delivered_at', [now()->subDays(14), now()->subDays(7)])
                    ->count();
                
                $courier->performance = $previousWeekDeliveries > 0 
                    ? round((($lastWeekDeliveries - $previousWeekDeliveries) / $previousWeekDeliveries) * 100)
                    : 0;
                
                return $courier;
            });

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
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        DB::transaction(function() use ($request) {
            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'courier'
            ]);

            $user->courier()->create([
                'name' => $request->name,
                'phone' => $request->phone,
                'restaurant_id' => auth()->user()->restaurant->id,
                'status' => 'active'
            ]);
        });

        return redirect()->route('restaurant.couriers.index')
            ->with('success', 'Kurye başarıyla eklendi.');
    }

    public function show(Courier $courier)
    {
        $this->authorize('view', $courier);
        
        $stats = [
            'today_deliveries' => $courier->orders()
                ->whereDate('delivered_at', today())
                ->where('status', 'delivered')
                ->count(),
            'weekly_deliveries' => $courier->orders()
                ->whereBetween('delivered_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->where('status', 'delivered')
                ->count(),
            'monthly_deliveries' => $courier->orders()
                ->whereMonth('delivered_at', now()->month)
                ->where('status', 'delivered')
                ->count(),
            'average_delivery_time' => $courier->orders()
                ->where('status', 'delivered')
                ->avg(DB::raw('TIMESTAMPDIFF(MINUTE, created_at, delivered_at)'))
        ];

        $recentDeliveries = $courier->orders()
            ->with(['restaurant', 'items.menu'])
            ->where('status', 'delivered')
            ->latest('delivered_at')
            ->take(10)
            ->get();

        return view('restaurant.couriers.show', compact('courier', 'stats', 'recentDeliveries'));
    }

    public function edit(Courier $courier)
    {
        $this->authorize('update', $courier);
        return view('restaurant.couriers.edit', compact('courier'));
    }

    public function update(Request $request, Courier $courier)
    {
        $this->authorize('update', $courier);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        DB::transaction(function() use ($request, $courier) {
            $courier->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'status' => $request->status,
            ]);

            if ($request->filled('password')) {
                $courier->user->update([
                    'password' => bcrypt($request->password)
                ]);
            }
        });

        return redirect()->route('restaurant.couriers.index')
            ->with('success', 'Kurye bilgileri güncellendi.');
    }

    public function destroy(Courier $courier)
    {
        $this->authorize('delete', $courier);

        DB::transaction(function() use ($courier) {
            $courier->user->delete();
            $courier->delete();
        });

        return redirect()->route('restaurant.couriers.index')
            ->with('success', 'Kurye başarıyla silindi.');
    }
} 