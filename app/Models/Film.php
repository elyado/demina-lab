<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Film extends Model
{
    protected $guarded = [];

    public function screenings(): HasMany
    {
        return $this->hasMany(FilmScreening::class);
    }
}