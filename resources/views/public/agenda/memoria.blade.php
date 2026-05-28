@extends('layouts.public')

@section('title', 'Agenda — DEMINA Laboratorio de Artes')

@section('meta_description', 'Agenda de actividades, talleres, cineclub, exposiciones y procesos públicos de DEMINA Laboratorio de Artes en Acapulco.')

@section('content')
<main class="demina-agenda">
    <section class="demina-agenda__hero">
        <div class="demina-agenda__hero-inner">
            <div class="demina-agenda__eyebrow">
                Programación pública
            </div>

            <h1 class="demina-agenda__title">
                Memoria
            </h1>
         
            <p class="demina-agenda__intro">
                Actividades, cineclub, talleres y procesos realizados anteriormente en DEMINA.   </p>

            <div class="demina-agenda__meta">
                <span class="demina-agenda__meta-item">
                    Acapulco · Guerrero
                </span>

                <span class="demina-agenda__meta-item">
                    Arte contemporáneo
                </span>

                <span class="demina-agenda__meta-item">
                    Formación · Exhibición · Comunidad
                </span>
            </div>
        </div>
    </section>

    <section class="demina-agenda__content">
        @if($events->count())
        <div class="demina-agenda__grid">
            @foreach($events as $event)
            @php
            $eventImage = $event->cover_image;
            $eventImageUrl = $eventImage
            ? (\Illuminate\Support\Str::startsWith($eventImage, ['http://', 'https://'])
            ? $eventImage
            : asset('storage/' . $eventImage))
            : null;

            $eventDate = $event->start_date
            ? \Illuminate\Support\Carbon::parse($event->start_date)
            : null;

            $eventTime = $event->start_time
            ? \Illuminate\Support\Carbon::parse($event->start_time)->format('H:i')
            : null;
            @endphp

            <a href="{{ route('events.show', $event->slug) }}" class="demina-agenda-card">
                <div class="demina-agenda-card__image">
                    @if($eventImageUrl)
                    <img
                        src="{{ $eventImageUrl }}"
                        alt="{{ $event->title }}"
                        loading="lazy">
                    @else
                    <div class="demina-agenda-card__placeholder">
                        Sin imagen
                    </div>
                    @endif
                </div>

                <div class="demina-agenda-card__body">
                    <div class="demina-agenda-card__top">
                        <div class="demina-agenda-card__date">
                            @if($eventDate)
                            {{ $eventDate->format('d') }}<br>
                            {{ $eventDate->format('m / Y') }}
                            @else
                            Fecha<br>
                            por confirmar
                            @endif
                        </div>

                        @if($event->activityType)
                        <span class="demina-agenda-card__type">
                            {{ $event->activityType->name }}
                        </span>
                        @endif
                    </div>

                    <h2 class="demina-agenda-card__title">
                        {{ $event->title }}
                    </h2>

                    @if($event->space)
                    <div class="demina-agenda-card__place">
                        ↳ {{ $event->space->name }}
                    </div>
                    @endif

                    @if($eventTime)
                    <div class="demina-agenda-card__time">
                        {{ $eventTime }} h
                    </div>
                    @endif

                    @if(!empty($event->short_description))
                    <p class="demina-agenda-card__description">
                        {{ $event->short_description }}
                    </p>
                    @elseif(!empty($event->description))
                    <p class="demina-agenda-card__description">
                        {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 130) }}
                    </p>
                    @endif

                    <div class="demina-agenda-card__footer">
                        <span class="demina-agenda-card__price">
                            @if($event->is_free)
                            Entrada libre
                            @elseif(!is_null($event->price))
                            ${{ number_format((float) $event->price, 2) }} MXN
                            @else
                            Información próxima
                            @endif
                        </span>

                        <span class="demina-agenda-card__arrow">
                            →
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="demina-agenda__pagination">
            {{ $events->links() }}
        </div>
        @else
        <div class="demina-agenda__empty">
            Todavía no hay actividades publicadas.
        </div>
        @endif
    </section>
</main>
@endsection