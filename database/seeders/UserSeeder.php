<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@kuryetakip.com',
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Restoran Sahibi',
                'email' => 'restoran@kuryetakip.com',
                'password' => Hash::make('123456'),
                'role' => 'restaurant',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kurye Çalışanı',
                'email' => 'kurye@kuryetakip.com',
                'password' => Hash::make('123456'),
                'role' => 'courier',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 