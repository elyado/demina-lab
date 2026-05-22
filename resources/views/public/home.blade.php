@extends('layouts.public')

@section('title', ($siteSetting->site_name ?? 'DEMINA') . ' — Laboratorio de Artes · Acapulco')

@section('meta_description', $siteSetting->meta_description ?? 'DEMINA Laboratorio de Artes en Acapulco. Espacio autogestionado para creación, exhibición, formación y experimentación contemporánea.')

@section('content')
    <div class="demina-home">
        <canvas id="cursor-trail" data-demina-cursor-trail></canvas>

        {{-- HERO --}}
        <section class="demina-hero" id="hero">
            <div class="demina-hero__image-wrap">
                @php
                    $heroImage = $siteSetting->hero_image_path ?? null;
                @endphp

                @if($heroImage)
                    <img
                        class="demina-hero__image"
                        src="{{ asset('storage/' . $heroImage) }}"
                        alt="{{ $siteSetting->site_name ?? 'DEMINA Laboratorio de Artes' }}"
                        loading="eager"
                    >
              @else
    <div class="demina-hero__fallback" aria-label="DEMINA Laboratorio de Artes"></div>
@endif
            </div>

            <div class="demina-hero__vignette"></div>

            <div class="demina-hero__geo">
                16°51'N · 99°53'O<br>
                ACAPULCO · GRO · MX
            </div>

     

            <div class="demina-hero__body">
                <div class="demina-hero__tag">
                    Laboratorio de Artes · Acapulco
                </div>

                <h1 class="demina-hero__title">
                    <span class="demina-glitch" data-demina-glitch data-text="DEMINA">DEMINA</span>
                    <span class="demina-glitch demina-hero__highlight" data-demina-glitch data-text="LABORATORIO">LABORATORIO</span>
                    <span class="demina-glitch" data-demina-glitch data-text="DE ARTES">DE ARTES</span>
                </h1>

                <div class="demina-hero__strip">
                    <p class="demina-hero__strip-text">
                        {{ $siteSetting->hero_subtitle ?? 'Un espacio autogestionado para la creación, exhibición, formación y experimentación contemporánea. Edificio histórico en el Centro de Acapulco.' }}
                    </p>

                    <div class="demina-hero__strip-actions">
                        <a href="{{ route('agenda.index') }}" class="demina-btn">
                            Ver agenda
                        </a>

                        <a href="{{ route('public.page', 'sobre-demina') }}" class="demina-btn-outline">
                            Conocer DEMINA
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- TICKER --}}
        <div class="demina-ticker">
            <div class="demina-ticker__track">
                @foreach([
                    'Arte Contemporáneo',
                    'Acapulco, Guerrero',
                    'Exhibición',
                    'Formación',
                    'Experimentación',
                    'Autogestionado',
                    'Performance',
                    'Cineclub',
                    'Residencias',
                    'Arte Contemporáneo',
                    'Acapulco, Guerrero',
                    'Exhibición',
                    'Formación',
                    'Experimentación',
                    'Autogestionado',
                    'Performance',
                    'Cineclub',
                    'Residencias',
                ] as $tickerItem)
                    <span class="demina-ticker__item">{{ $tickerItem }}</span>
                    <span class="demina-ticker__dot">◆</span>
                @endforeach
            </div>
        </div>

        {{-- PROGRAMACIÓN --}}
  {{-- PROGRAMACIÓN --}}
<section class="demina-program" id="programacion">
    <div class="demina-program__head">
        <div class="demina-program__number">
            <div class="demina-section-number">01</div>
        </div>

        <div class="demina-program__title">
            <h2>Próximas<br>actividades</h2>

            <a href="{{ route('agenda.index') }}" class="demina-link-more">
                Ver toda la agenda →
            </a>
        </div>
    </div>

    @if($featuredEvents->isNotEmpty())
        <div class="demina-events-grid">
            @foreach($featuredEvents as $event)
                @php
                    $isCineclub = $event->activityType?->slug === 'cineclub';

                    $eventImage = $isCineclub
                        ? ($event->film_poster_image ?: $event->cover_image)
                        : $event->cover_image;

                    $eventTitle = $isCineclub
                        ? ($event->film_title ?: $event->title)
                        : $event->title;
                @endphp

                <article class="demina-event-card">
                    <a href="{{ route('events.show', $event) }}" class="demina-event-card__image">
                        @if($eventImage)
                            <img
                                src="{{ \Illuminate\Support\Str::startsWith($eventImage, ['http://', 'https://']) ? $eventImage : asset('storage/' . $eventImage) }}"
                                alt="{{ $eventTitle }}"
                                loading="lazy"
                            >
                        @else
                            <div class="demina-event-card__placeholder">
                                Sin imagen del evento
                            </div>
                        @endif
                    </a>

                    <div class="demina-event-card__body">
                        <div class="demina-event-card__top">
                            <div class="demina-event-card__date">
                                @if($event->start_date)
                                    {{ \Illuminate\Support\Carbon::parse($event->start_date)->format('d') }}<br>
                                    {{ \Illuminate\Support\Carbon::parse($event->start_date)->format('m / Y') }}
                                @else
                                    Fecha<br>por confirmar
                                @endif
                            </div>

                            @if($event->activityType)
                                <span class="demina-event-card__tag">
                                    {{ $event->activityType->name }}
                                </span>
                            @endif
                        </div>

                        <h3 class="demina-event-card__title">
                            <a href="{{ route('events.show', $event) }}">
                                {{ $eventTitle }}
                            </a>
                        </h3>

                        @if($isCineclub)
                            @if($event->film_director || $event->film_year || $event->film_classification)
                                <p class="demina-event-card__description">
                                    @if($event->film_director)
                                        Dir. {{ $event->film_director }}
                                    @endif

                                    @if($event->film_year)
                                        · {{ $event->film_year }}
                                    @endif

                                    @if($event->film_classification)
                                        · {{ $event->film_classification }}
                                    @endif
                                </p>
                            @endif
                        @else
                            @if(!empty($event->short_description))
                                <p class="demina-event-card__description">
                                    {{ $event->short_description }}
                                </p>
                            @elseif(!empty($event->description))
                                <p class="demina-event-card__description">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 120) }}
                                </p>
                            @endif
                        @endif

                        @if($event->space)
                            <div class="demina-event-card__place">
                                ↳ {{ $event->space->name }}
                            </div>
                        @endif

                        <div class="demina-event-card__actions">
                            <a href="{{ route('events.show', $event) }}" class="demina-event-card__button">
                                Ver detalle
                            </a>

                            @if($isCineclub && $event->film_trailer_url)
                                <a
                                    href="{{ $event->film_trailer_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="demina-event-card__button demina-event-card__button--ghost"
                                >
                                    Ver trailer
                                </a>
                            @endif
                        </div>

                        <span class="demina-event-card__arrow">→</span>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="demina-empty-state">
            Todavía no hay actividades publicadas.
        </div>
    @endif
</section>

@if(!empty($featuredCalls) && $featuredCalls->count())
    <section class="demina-home-calls">
        <div class="demina-home-calls__head">
            <div>
                <div class="demina-home-calls__eyebrow">
                    Convocatorias abiertas
                </div>

                <h2 class="demina-home-calls__title">
                    Participa<br>
                    en DEMINA
                </h2>
            </div>

            <a href="{{ route('calls.index') }}" class="demina-home-calls__link">
                Ver todas →
            </a>
        </div>

        <div class="demina-home-calls__grid">
            @foreach($featuredCalls as $call)
                @php
                    $callImage = $call->cover_image;
                    $callImageUrl = $callImage
                        ? (\Illuminate\Support\Str::startsWith($callImage, ['http://', 'https://'])
                            ? $callImage
                            : asset('storage/' . $callImage))
                        : null;

                    $callEndDate = $call->end_date
                        ? \Illuminate\Support\Carbon::parse($call->end_date)->format('d/m/Y')
                        : null;
                @endphp

                <a href="{{ route('calls.show', $call->slug) }}" class="demina-home-call-card">
                    <div class="demina-home-call-card__image">
                        @if($callImageUrl)
                            <img src="{{ $callImageUrl }}" alt="{{ $call->title }}" loading="lazy">
                        @else
                            <div class="demina-home-call-card__fallback"></div>
                        @endif
                    </div>

                    <div class="demina-home-call-card__body">
                        <div class="demina-home-call-card__status">
                            Abierta
                        </div>

                        <h3 class="demina-home-call-card__title">
                            {{ $call->title }}
                        </h3>

                        @if($call->short_description)
                            <p class="demina-home-call-card__description">
                                {{ $call->short_description }}
                            </p>
                        @endif

                        @if($callEndDate)
                            <div class="demina-home-call-card__date">
                                Cierre: {{ $callEndDate }}
                            </div>
                        @endif

                        <span class="demina-home-call-card__button">
                            Ver convocatoria →
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endif


        {{-- ESPACIOS --}}
        <section class="demina-spaces" id="espacios">
            <div class="demina-spaces__head">
                <div>
                    <div class="demina-spaces__eyebrow">
                        Espacios
                    </div>

                    <h2>Infraestructura<br>para crear</h2>
                </div>

                <div class="demina-section-number">
                    02
                </div>
            </div>

            @if($spaces->isNotEmpty())
                <div class="demina-spaces-grid">
                    @foreach($spaces as $space)
                        @php
                            $spaceCover = $space->images?->sortBy('sort_order')->first();
                        @endphp

                        <a
                            href="{{ route('spaces.show', $space->slug) }}"
                            class="demina-space-card"
                            data-demina-space-card
                        >
                            @if($spaceCover)
                                <img
                                    class="demina-space-card__image"
                                    data-demina-space-image
                                    src="{{ asset('storage/' . $spaceCover->image_path) }}"
                                    alt="{{ $spaceCover->alt_text ?: $space->name }}"
                                    loading="lazy"
                                >
                            @else
    <div
        class="demina-space-card__image demina-space-card__fallback"
        data-demina-space-image
        aria-label="{{ $space->name }}"
        loading="lazy"
    ></div>
@endif

                            <canvas
                                class="demina-space-card__canvas"
                                data-demina-space-canvas
                            ></canvas>

                            <div class="demina-space-card__info">
                                <div class="demina-space-card__num">
                                    E_{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </div>

                                <div class="demina-space-card__name">
                                    {!! str_replace(' ', '<br>', e($space->name)) !!}
                                </div>

                                <div class="demina-space-card__description">
                                    {{ $space->short_description ?? 'Espacio DEMINA' }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="demina-empty-state">
                    Todavía no hay espacios activos publicados.
                </div>
            @endif
        </section>

        {{-- COMUNIDAD --}}
        <section class="demina-community" id="comunidad">
            <div class="demina-community__image-wrap">
                @php
    $communityImage = $siteSetting->community_image_path ?? null;
@endphp

@if($communityImage)
    <img
        class="demina-community__image"
        src="{{ asset('storage/' . $communityImage) }}"
        alt="Comunidad DEMINA"
        loading="lazy"
    >
@else
    <div class="demina-community__image demina-community__fallback" aria-label="Comunidad DEMINA"></div>
@endif

                <div class="demina-community__overlay">
                    <div class="demina-community__eyebrow">
                        03 — Comunidad
                    </div>

                    <h2 class="demina-community__title">
                        Un laboratorio<br>
                        abierto para<br>
                        prácticas artísticas,<br>
                        procesos colectivos<br>
                        y experimentación.
                    </h2>

                    <div class="demina-community__actions">
                        <a href="{{ route('public.page', 'sobre-demina') }}" class="demina-btn-blue">
                            Sobre DEMINA
                        </a>

                        <a href="{{ route('contact') }}" class="demina-btn-light-outline">
                            Contacto
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection