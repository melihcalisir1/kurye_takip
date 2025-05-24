<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    protected $fillable = [
        'restaurant_id',
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
        'is_active',
        'images'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'calories' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'images' => 'array'
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
} 