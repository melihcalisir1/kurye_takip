<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;

class CourierLocationController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $courier = auth()->user()->courier;
        
        if (!$courier) {
            return response()->json(['error' => 'Kurye bulunamadı'], 404);
        }

        $courier->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'last_location_update' => now()
        ]);

        return response()->json([
            'message' => 'Konum güncellendi',
            'courier' => $courier
        ]);
    }

    public function getLocation($courierId)
    {
        $courier = Courier::findOrFail($courierId);
        
        return response()->json([
            'latitude' => $courier->latitude,
            'longitude' => $courier->longitude,
            'last_update' => $courier->last_location_update
        ]);
    }
} 