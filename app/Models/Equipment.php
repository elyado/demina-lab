<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipment extends Model
{
    protected $guarded = [];

    public function spaces(): BelongsToMany
    {
        return $this->belongsToMany(Space::class)
            ->withPivot('notes');
    }
}