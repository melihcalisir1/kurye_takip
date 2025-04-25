<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'pickup_address' => 'required|string',
            'delivery_address' => 'required|string',
        ]);

        $order = Order::create([
            'customer_id' => Auth::id(),
            'pickup_address' => $request->pickup_address,
            'delivery_address' => $request->delivery_address,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Sipariş oluşturuldu',
            'data' => $order
        ], 201);
    }
}
