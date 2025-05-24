<?php

namespace Database\Seeders;

use App\Models\Courier;
use Illuminate\Database\Seeder;

class CourierLocationSeeder extends Seeder
{
    public function run()
    {
        // İstanbul'un merkezi koordinatları
        $centerLat = 41.0082;
        $centerLng = 28.9784;
        
        // Tüm kuryeleri al
        $couriers = Courier::all();
        
        foreach ($couriers as $courier) {
            // Merkez noktasından ±0.1 derece (yaklaşık 11km) rastgele konum oluştur
            $latitude = $centerLat + (rand(-100, 100) / 1000);
            $longitude = $centerLng + (rand(-100, 100) / 1000);
            
            $courier->update([
                'latitude' => $latitude,
                'longitude' => $longitude,
                'last_location_update' => now()
            ]);
        }
    }
} 