@extends('layouts.public')

@section('title', 'Exposiciones — DEMINA')

@section('meta_description', 'Exposiciones actuales, próximas y pasadas de DEMINA Laboratorio de Artes.')

@section('content')
<main class="demina-exhibitions">
    <section class="demina-exhibitions__hero">
        <div class="demina-exhibitions__hero-inner">
            <div class="demina-exhibitions__eyebrow">
                Programa expositivo
            </div>

            <h1 class="demina-exhibitions__title">
                Exposiciones
            </h1>

            <p class="demina-exhibitions__intro">
                Muestras, procesos curatoriales, proyectos site-specific y cruces entre prácticas contemporáneas, territorio y comunidad.
            </p>
        </div>
    </section>

    <section class="demina-exhibitions__content">
        @if($exhibitions->count())
        <div class="demina-exhibitions__grid">
            @foreach($exhibitions as $exhibition)
            @php
            $statusLabel = match ($exhibition->status) {
            'current' => 'Actual',
            'upcoming' => 'Próxima',
            'past' => 'Pasada',
            default => 'Exposición',
            };

            $statusClass = match ($exhibition->status) {
            'upcoming' => 'demina-exhibition-card__status--upcoming',
            'past' => 'demina-exhibition-card__status--past',
            default => '',
            };

            $startDate = $exhibition->start_date
            ? \Illuminate\Support\Carbon::parse($exhibition->start_date)->format('d/m/Y')
            : null;

            $endDate = $exhibition->end_date
            ? \Illuminate\Support\Carbon::parse($exhibition->end_date)->format('d/m/Y')
            : null;

            $image = $exhibition->cover_image ?: $exhibition->poster_image;

            $imageUrl = $image
            ? (\Illuminate\Support\Str::startsWith($image, ['http://', 'https://'])
            ? $image
            : asset('storage/' . $image))
            : null;
            @endphp

            <a href="{{ route('exhibitions.show', $exhibition->slug) }}" class="demina-exhibition-card">
                <div class="demina-exhibition-card__image">
                    @if($imageUrl)
                    <img src="{{ $imageUrl }}" alt="{{ $exhibition->title }}" loading="lazy">
                    @else
                    <div class="demina-exhibition-card__placeholder">
                        Sin imagen
                    </div>
                    @endif
                </div>

                <div class="demina-exhibition-card__body">
                    <span class="demina-exhibition-card__status {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>

                    <h2 class="demina-exhibition-card__title">
                        {{ $exhibition->title }}
                    </h2>

                    @if(!empty($exhibition->subtitle))
                    <p class="demina-exhibition-card__subtitle">
                        {{ $exhibition->subtitle }}
                    </p>
                    @endif

                    @if(!empty($exhibition->short_description))
                    <p class="demina-exhibition-card__description">
                        {{ $exhibition->short_description }}
                    </p>
                    @endif

                    <div class="demina-exhibition-card__meta">
                        @if($startDate)
                        Inicio: {{ $startDate }}<br>
                        @endif

                        @if($endDate)
                        Cierre: {{ $endDate }}<br>
                        @endif

                        @if($exhibition->curator)
                        Curaduría: {{ $exhibition->curator->name }}
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="demina-exhibitions__pagination">
            {{ $exhibitions->links() }}
        </div>
        @else
        <div class="demina-exhibitions__empty">
            Todavía no hay exposiciones publicadas.
        </div>
        @endif
    </section>
</main>
@endsection