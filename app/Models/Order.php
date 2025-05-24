<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'restaurant_id',
        'courier_id',
        'customer_name',
        'customer_phone',
        'delivery_address',
        'total_amount',
        'status',
        'notes',
        'assigned_at',
        'picked_up_at',
        'delivered_at'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'picked_up_at' => 'datetime',
        'delivered_at' => 'datetime'
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function courier(): BelongsTo
    {
        return $this->belongsTo(Courier::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Beklemede',
            'preparing' => 'Hazırlanıyor',
            'ready' => 'Hazır',
            'assigned' => 'Kuryeye Atandı',
            'picked_up' => 'Kurye Aldı',
            'delivered' => 'Teslim Edildi',
            'cancelled' => 'İptal Edildi',
            default => 'Bilinmiyor'
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'preparing' => 'info',
            'ready' => 'primary',
            'assigned' => 'secondary',
            'picked_up' => 'warning',
            'delivered' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }
} 