<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CallApplication extends Model
{
    protected $guarded = [];

    protected $casts = [
        'submitted_at' => 'datetime',
        'production_cost' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(CallApplicationPhoto::class);
    }
}