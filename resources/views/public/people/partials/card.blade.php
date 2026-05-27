@php
    $image = $person->portrait_image;

    $imageUrl = $image
        ? (\Illuminate\Support\Str::startsWith($image, ['http://', 'https://'])
            ? $image
            : asset('storage/' . $image))
        : null;

    $initial = \Illuminate\Support\Str::of($person->name)->substr(0, 1)->upper();

    $roleLabel = match ($person->role_type) {
        'team' => 'Equipo',
        'artist' => 'Artista',
        'curator' => 'Curaduría',
        'workshop_leader' => 'Tallerista',
        'collaborator' => 'Colaboradorx',
        default => $person->role_type ?? 'Persona',
    };
@endphp

<a href="{{ route('people.show', $person->slug) }}" class="demina-person-card">
    <div class="demina-person-card__image">
        @if($imageUrl)
            <img src="{{ $imageUrl }}" alt="{{ $person->name }}" loading="lazy">
        @else
            <div class="demina-person-card__fallback">
                {{ $initial }}
            </div>
        @endif
    </div>

    <div class="demina-person-card__body">
        <div class="demina-person-card__role">
            {{ $roleLabel }}
        </div>

        <h3 class="demina-person-card__name">
            {{ $person->name }}
        </h3>

        @if($person->short_bio)
            <p class="demina-person-card__bio">
                {{ $person->short_bio }}
            </p>
        @endif
    </div>
</a>