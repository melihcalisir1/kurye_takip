<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'last_location_update',
        'is_active',
        'current_location',
        'last_active_at'
    ];

    protected $casts = [
        'last_location_update' => 'datetime',
        'is_active' => 'boolean',
        'last_active_at' => 'datetime'
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getActiveOrdersCountAttribute(): int
    {
        return $this->orders()
            ->whereIn('status', ['assigned', 'picked_up'])
            ->count();
    }
} 