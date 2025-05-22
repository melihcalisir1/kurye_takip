<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'status'
    ];

    public function couriers(): HasMany
    {
        return $this->hasMany(Courier::class);
    }
} 