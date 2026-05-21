<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exhibition extends Model
{
    protected $guarded = [];

    public function curator(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'curator_id');
    }

    public function spaces(): BelongsToMany
    {
        return $this->belongsToMany(Space::class, 'exhibition_spaces')
            ->withPivot('notes');
    }

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'exhibition_people')
            ->withPivot('role_label');
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'exhibition_events')
            ->withPivot('relation_label');
    }

    public function artworks(): HasMany
    {
        return $this->hasMany(Artwork::class);
    }
}