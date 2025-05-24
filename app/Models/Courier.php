<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Courier extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'plate',
        'status',
        'restaurant_id',
        'user_id',
        'latitude',
        'longitude',
        'last_location_update'
    ];

    protected $casts = [
        'last_location_update' => 'datetime'
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 