<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $restaurant = Restaurant::where('user_id', auth()->id())->first();
        if (!$restaurant) {
            return back()->with('error', 'Restoran bulunamadı!');
        }

        $orders = Order::with(['courier', 'items.menu'])
            ->where('restaurant_id', $restaurant->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('restaurant.orders', compact('orders'));
    }

    public function create()
    {
        $restaurant = Restaurant::where('user_id', auth()->id())->first();
        if (!$restaurant) {
            return back()->with('error', 'Restoran bulunamadı!');
        }

        $menus = Menu::where('restaurant_id', $restaurant->id)
            ->where('is_active', true)
            ->get();

        $couriers = Courier::where('restaurant_id', $restaurant->id)
            ->where('is_active', true)
            ->get();

        return view('restaurant.order_create', compact('menus', 'couriers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'delivery_address' => 'required|string',
            'courier_id' => 'required|exists:couriers,id',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $restaurant = Restaurant::where('user_id', auth()->id())->first();
        if (!$restaurant) {
            return back()->with('error', 'Restoran bulunamadı!');
        }

        try {
            DB::beginTransaction();

            // Toplam tutarı hesapla
            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $menu = Menu::find($item['menu_id']);
                $price = $menu->discount_price ?? $menu->price;
                $totalAmount += $price * $item['quantity'];
            }

            // Siparişi oluştur
            $order = Order::create([
                'restaurant_id' => $restaurant->id,
                'courier_id' => $validated['courier_id'],
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'delivery_address' => $validated['delivery_address'],
                'total_amount' => $totalAmount,
                'status' => 'assigned',
                'notes' => $validated['notes'],
                'assigned_at' => now()
            ]);

            // Sipariş kalemlerini ekle
            foreach ($validated['items'] as $item) {
                $menu = Menu::find($item['menu_id']);
                $order->items()->create([
                    'menu_id' => $item['menu_id'],
                    'quantity' => $item['quantity'],
                    'price' => $menu->price,
                    'discount_price' => $menu->discount_price,
                    'notes' => $item['notes'] ?? null
                ]);
            }

            DB::commit();
            return redirect()->route('restaurant.orders')->with('success', 'Sipariş başarıyla oluşturuldu!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Sipariş oluşturulurken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        $restaurant = Restaurant::where('user_id', auth()->id())->first();
        if (!$restaurant || $order->restaurant_id !== $restaurant->id) {
            return back()->with('error', 'Bu siparişi görüntüleme yetkiniz yok!');
        }

        $order->load(['courier', 'items.menu']);
        return view('restaurant.order_show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:preparing,ready,picked_up,delivered,cancelled'
        ]);

        $restaurant = Restaurant::where('user_id', auth()->id())->first();
        if (!$restaurant || $order->restaurant_id !== $restaurant->id) {
            return back()->with('error', 'Bu siparişi güncelleme yetkiniz yok!');
        }

        try {
            $order->status = $validated['status'];
            
            // Duruma göre zaman damgası ekle
            switch ($validated['status']) {
                case 'picked_up':
                    $order->picked_up_at = now();
                    break;
                case 'delivered':
                    $order->delivered_at = now();
                    break;
            }

            $order->save();
            return back()->with('success', 'Sipariş durumu güncellendi!');
        } catch (\Exception $e) {
            return back()->with('error', 'Sipariş durumu güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }
} 