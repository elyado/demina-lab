@extends('layouts.public')

@section('title', $person->name . ' — DEMINA')

@section('meta_description', $person->short_bio ?? 'Persona vinculada a DEMINA Laboratorio de Artes.')

@section('content')
    @php
        $image = $person->portrait_image;

        $imageUrl = $image
            ? (\Illuminate\Support\Str::startsWith($image, ['http://', 'https://'])
                ? $image
                : asset('storage/' . $image))
            : null;

        $roleLabel = match ($person->role_type) {
            'team' => 'Equipo DEMINA',
            'artist' => 'Artista',
            'curator' => 'Curaduría',
            'workshop_leader' => 'Tallerista',
            'collaborator' => 'Colaboradorx',
            default => $person->role_type ?? 'Persona',
        };
    @endphp

    <main class="demina-people">
        <section class="demina-person-show">
            <div class="demina-person-show__media">
                @if($imageUrl)
                    <img src="{{ $imageUrl }}" alt="{{ $person->name }}">
                @else
                    <div class="demina-person-show__fallback">
                        {{ \Illuminate\Support\Str::of($person->name)->substr(0, 1)->upper() }}
                    </div>
                @endif
            </div>

            <div class="demina-person-show__content">
                <div class="demina-person-show__breadcrumb">
                    <a href="{{ route('people.index') }}">Personas</a> / {{ $person->name }}
                </div>

                <div class="demina-person-show__role">
                    {{ $roleLabel }}
                </div>

                <h1 class="demina-person-show__title">
                    {{ $person->name }}
                </h1>

                @if($person->short_bio)
                    <p class="demina-person-show__short">
                        {{ $person->short_bio }}
                    </p>
                @endif

                @if($person->bio)
                    <div class="demina-person-show__bio">
                        {!! $person->bio !!}
                    </div>
                @endif

                <div class="demina-person-show__links">
                    @if($person->website_url)
                        <a href="{{ $person->website_url }}" target="_blank" rel="noopener noreferrer">
                            Sitio web
                        </a>
                    @endif

                    @if($person->instagram_url)
                        <a href="{{ $person->instagram_url }}" target="_blank" rel="noopener noreferrer">
                            Instagram
                        </a>
                    @endif

                    @if($person->facebook_url)
                        <a href="{{ $person->facebook_url }}" target="_blank" rel="noopener noreferrer">
                            Facebook
                        </a>
                    @endif

                    @if($person->email)
                        <a href="mailto:{{ $person->email }}">
                            Correo
                        </a>
                    @endif
                </div>

                <a href="{{ route('people.index') }}" class="demina-person-show__back">
                    Volver a personas
                </a>
            </div>
        </section>
    </main>
@endsection