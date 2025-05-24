<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'discount_price',
        'currency',
        'portion',
        'calories',
        'ingredients',
        'extras',
        'tags',
        'is_featured',
        'images',
        'restaurant_id',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
} 