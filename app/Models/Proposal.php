<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proposal extends Model
{
    protected $guarded = [];

    public function call(): BelongsTo
    {
        return $this->belongsTo(Call::class);
    }

    public function preferredSpace(): BelongsTo
    {
        return $this->belongsTo(Space::class, 'preferred_space_id');
    }
}