<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpaceImage extends Model
{
    protected $guarded = [];

    public function space(): BelongsTo
    {
        return $this->belongsTo(Space::class);
    }
}