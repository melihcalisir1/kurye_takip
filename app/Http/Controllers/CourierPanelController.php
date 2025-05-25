<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CourierPanelController extends Controller
{
    public function dashboard()
    {
        $courier = Auth::user()->courier;
        $activeOrders = Order::where('courier_id', $courier->id)
            ->whereIn('status', ['assigned', 'picked_up'])
            ->orderBy('created_at', 'desc')
            ->get();
        $deliveredOrders = Order::where('courier_id', $courier->id)
            ->where('status', 'delivered')
            ->orderBy('delivered_at', 'desc')
            ->take(10)
            ->get();
        return view('courier.dashboard', compact('activeOrders', 'deliveredOrders'));
    }

    public function showOrder($orderId)
    {
        $courier = auth()->user()->courier;
        $order = \App\Models\Order::with(['items.menu', 'restaurant'])
            ->where('courier_id', $courier->id)
            ->where('id', $orderId)
            ->firstOrFail();
        return view('couriers.orders.show', compact('order'));
    }

    public function updateOrderStatus($orderId, Request $request)
    {
        $courier = auth()->user()->courier;
        $order = \App\Models\Order::where('courier_id', $courier->id)
            ->where('id', $orderId)
            ->firstOrFail();
        $request->validate([
            'status' => 'required|in:picked_up,delivered'
        ]);
        $order->status = $request->status;
        if ($request->status === 'picked_up') {
            $order->picked_up_at = now();
        }
        if ($request->status === 'delivered') {
            $order->delivered_at = now();
        }
        $order->save();
        return redirect()->route('courier.orders.show', $order->id)->with('success', 'Sipariş durumu güncellendi!');
    }

    public function activeOrders()
    {
        $courier = auth()->user()->courier;
        $orders = \App\Models\Order::where('courier_id', $courier->id)
            ->whereIn('status', ['assigned', 'picked_up'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('couriers.orders.active', compact('orders'));
    }

    public function deliveredOrders()
    {
        $courier = auth()->user()->courier;
        $orders = \App\Models\Order::where('courier_id', $courier->id)
            ->where('status', 'delivered')
            ->orderBy('delivered_at', 'desc')
            ->take(30)
            ->get();
        return view('couriers.orders.delivered', compact('orders'));
    }

    public function profile()
    {
        $courier = auth()->user()->courier;
        return view('couriers.profile', compact('courier'));
    }

    public function updateProfile(\Illuminate\Http\Request $request)
    {
        $courier = auth()->user()->courier;
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        $courier->name = $request->name;
        $courier->phone = $request->phone;
        $courier->save();
        if ($request->filled('password')) {
            $courier->user->password = bcrypt($request->password);
            $courier->user->save();
        }
        return back()->with('success', 'Profiliniz başarıyla güncellendi!');
    }
} 