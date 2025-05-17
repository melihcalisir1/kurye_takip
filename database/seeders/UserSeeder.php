<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin kullanıcısı
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Restoran kullanıcısı
        User::create([
            'name' => 'Restaurant Owner',
            'email' => 'restaurant@example.com',
            'password' => Hash::make('password123'),
            'role' => 'restaurant',
        ]);

        // Kurye kullanıcısı
        User::create([
            'name' => 'Courier User',
            'email' => 'courier@example.com',
            'password' => Hash::make('password123'),
            'role' => 'courier',
        ]);
    }
} 