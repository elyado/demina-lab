<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    protected $guarded = [];

    public function curatedExhibitions(): HasMany
    {
        return $this->hasMany(Exhibition::class, 'curator_id');
    }

    public function artworks(): HasMany
    {
        return $this->hasMany(Artwork::class, 'artist_id');
    }

    public function workshops(): HasMany
    {
        return $this->hasMany(Workshop::class, 'facilitator_id');
    }
}