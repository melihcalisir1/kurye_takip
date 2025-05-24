<?php

namespace App\Console\Commands;

use App\Models\Courier;
use Illuminate\Console\Command;

class UpdateCourierLocations extends Command
{
    protected $signature = 'couriers:update-locations';
    protected $description = 'Tüm kuryelere rastgele konumlar atar';

    public function handle()
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

            $this->info("Kurye {$courier->name} için konum güncellendi: {$latitude}, {$longitude}");
        }

        $this->info('Tüm kuryelerin konumları güncellendi!');
    }
} 