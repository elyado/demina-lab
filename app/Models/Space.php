<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Space extends Model
{
    protected $guarded = [];

    public function equipment(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class)
            ->withPivot('notes');
    }

    public function images(): HasMany
    {
        return $this->hasMany(SpaceImage::class);
    }
}