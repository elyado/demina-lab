@extends('layouts.public')

@section('title', $event->title . ' — DEMINA')

@section('meta_description', $event->short_description ?? 'Actividad de DEMINA Laboratorio de Artes.')

@section('content')
    @php
        $coverImage = $event->cover_image;
        $coverUrl = $coverImage
            ? (\Illuminate\Support\Str::startsWith($coverImage, ['http://', 'https://'])
                ? $coverImage
                : asset('storage/' . $coverImage))
            : null;

        $eventDate = $event->start_date
            ? \Illuminate\Support\Carbon::parse($event->start_date)
            : null;

        $eventTime = $event->start_time
            ? \Illuminate\Support\Carbon::parse($event->start_time)->format('H:i')
            : null;

        $priceLabel = 'Información próxima';

        if ($event->is_free) {
            $priceLabel = 'Entrada libre';
        } elseif (!is_null($event->price)) {
            $priceLabel = '$' . number_format((float) $event->price, 2) . ' MXN';
        }
    @endphp

    <main class="demina-event-show">
        <section class="demina-event-hero">
            <div class="demina-event-hero__image">
                @if($coverUrl)
                    <img src="{{ $coverUrl }}" alt="{{ $event->title }}">
                @else
                    <div class="demina-event-hero__fallback"></div>
                @endif
            </div>

            <div class="demina-event-hero__overlay"></div>

            <div class="demina-event-hero__content">
                <div class="demina-event-hero__breadcrumb">
                    <a href="{{ route('agenda.index') }}">Agenda</a>
                    <span>/</span>
                    <span>{{ $event->title }}</span>
                </div>

                @if($event->activityType)
                    <div class="demina-event-hero__tag">
                        {{ $event->activityType->name }}
                    </div>
                @endif

                <h1 class="demina-event-hero__title">
                    {{ $event->title }}
                </h1>

                @if(!empty($event->subtitle))
                    <p class="demina-event-hero__subtitle">
                        {{ $event->subtitle }}
                    </p>
                @endif

                <div class="demina-event-facts">
                    <div class="demina-event-fact">
                        <div class="demina-event-fact__label">Fecha</div>
                        <div class="demina-event-fact__value">
                            {{ $eventDate ? $eventDate->format('d/m/Y') : 'Por confirmar' }}
                        </div>
                    </div>

                    <div class="demina-event-fact">
                        <div class="demina-event-fact__label">Hora</div>
                        <div class="demina-event-fact__value">
                            {{ $eventTime ? $eventTime . ' h' : 'Por confirmar' }}
                        </div>
                    </div>

                    <div class="demina-event-fact">
                        <div class="demina-event-fact__label">Espacio</div>
                        <div class="demina-event-fact__value">
                            {{ $event->space?->name ?? 'Por confirmar' }}
                        </div>
                    </div>

                    <div class="demina-event-fact">
                        <div class="demina-event-fact__label">Costo</div>
                        <div class="demina-event-fact__value">
                            {{ $priceLabel }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="demina-event-body">
            <article class="demina-event-content">
                @if(!empty($event->short_description))
                    <p class="demina-event-lead">
                        {{ $event->short_description }}
                    </p>
                @endif

                @if(!empty($event->description))
                    <div class="demina-event-prose">
                        {!! $event->description !!}
                    </div>
                @endif

                @if($event->people->isNotEmpty())
                    <section class="demina-event-section">
                        <h2 class="demina-event-section__title">Participan</h2>

                        <div class="demina-event-pills">
                            @foreach($event->people as $person)
                                <span class="demina-event-pill">
                                    {{ $person->name }}
                                </span>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if($event->filmScreenings->isNotEmpty())
                    <section class="demina-event-section">
                        <h2 class="demina-event-section__title">Proyección</h2>

                        <div class="demina-event-pills">
                            @foreach($event->filmScreenings as $screening)
                                @if($screening->film)
                                    <span class="demina-event-pill">
                                        {{ $screening->film->title }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </section>
                @endif

                @if($event->workshops->isNotEmpty())
                    <section class="demina-event-section">
                        <h2 class="demina-event-section__title">Talleres relacionados</h2>

                        <div class="demina-event-pills">
                            @foreach($event->workshops as $workshop)
                                <span class="demina-event-pill">
                                    {{ $workshop->title }}
                                </span>
                            @endforeach
                        </div>
                    </section>
                @endif
            </article>

            <aside class="demina-event-side">
                <div class="demina-event-side__box">
                    <h2 class="demina-event-side__title">
                        Información
                    </h2>

                    <dl>
                        <div>
                            <dt>Fecha</dt>
                            <dd>{{ $eventDate ? $eventDate->format('d/m/Y') : 'Por confirmar' }}</dd>
                        </div>

                        <div>
                            <dt>Hora</dt>
                            <dd>{{ $eventTime ? $eventTime . ' h' : 'Por confirmar' }}</dd>
                        </div>

                        <div>
                            <dt>Espacio</dt>
                            <dd>{{ $event->space?->name ?? 'Por confirmar' }}</dd>
                        </div>

                        <div>
                            <dt>Costo</dt>
                            <dd>{{ $priceLabel }}</dd>
                        </div>
                    </dl>
                </div>

                <a href="{{ route('agenda.index') }}" class="demina-event-back">
                    Volver a agenda
                </a>
            </aside>
        </section>
    </main>
@endsection