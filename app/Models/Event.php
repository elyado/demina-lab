<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Support\VideoEmbed;


class Event extends Model
{
    protected $guarded = [];

    public function activityType(): BelongsTo
    {
        return $this->belongsTo(ActivityType::class);
    }

    public function space(): BelongsTo
    {
        return $this->belongsTo(Space::class);
    }

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'event_people')
            ->withPivot('role_label');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'event_categories');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'event_tags');
    }

    public function filmScreenings(): HasMany
    {
        return $this->hasMany(FilmScreening::class);
    }

    public function workshops(): HasMany
    {
        return $this->hasMany(Workshop::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'published_at' => 'datetime',
        'is_all_day' => 'boolean',
        'is_recurring' => 'boolean',
        'is_free' => 'boolean',
        'requires_registration' => 'boolean',
        'is_featured' => 'boolean',
        'show_on_home' => 'boolean',
    ];

    public function scopeCineclub($query)
    {
        return $query->whereHas('activityType', fn($q) => $q->where('slug', 'cineclub'));
    }

    public function scopeGeneral($query)
    {
        return $query->whereDoesntHave('activityType', fn($q) => $q->where('slug', 'cineclub'));
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->whereDate('start_date', '>=', now()->toDateString());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOnHome($query)
    {
        return $query->where('show_on_home', true);
    }
    public function getFilmTrailerEmbedUrlAttribute(): ?string
    {
        return VideoEmbed::url($this->film_trailer_url);
    }
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
