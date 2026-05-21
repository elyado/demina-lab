@extends('layouts.public')

@section('title', $exhibition->title . ' — DEMINA')

@section('meta_description', $exhibition->short_description ?? 'Exposición de DEMINA Laboratorio de Artes.')

@section('content')
    @php
        $image = $exhibition->cover_image ?: $exhibition->poster_image;

        $imageUrl = $image
            ? (\Illuminate\Support\Str::startsWith($image, ['http://', 'https://'])
                ? $image
                : asset('storage/' . $image))
            : null;

        $statusLabel = match ($exhibition->status) {
            'current' => 'Actual',
            'upcoming' => 'Próxima',
            'past' => 'Pasada',
            default => 'Exposición',
        };

        $startDate = $exhibition->start_date
            ? \Illuminate\Support\Carbon::parse($exhibition->start_date)->format('d/m/Y')
            : 'Por confirmar';

        $endDate = $exhibition->end_date
            ? \Illuminate\Support\Carbon::parse($exhibition->end_date)->format('d/m/Y')
            : 'Por confirmar';
    @endphp

    <main class="demina-exhibition-show">
        <section class="demina-exhibition-show__hero">
            <div class="demina-exhibition-show__image">
                @if($imageUrl)
                    <img src="{{ $imageUrl }}" alt="{{ $exhibition->title }}">
                @else
                    <div class="demina-exhibition-show__fallback"></div>
                @endif
            </div>

            <div class="demina-exhibition-show__overlay"></div>

            <div class="demina-exhibition-show__content">
                <div class="demina-exhibition-show__breadcrumb">
                    <a href="{{ route('exhibitions.index') }}">Exposiciones</a> / {{ $exhibition->title }}
                </div>

                <div class="demina-exhibition-show__status">
                    {{ $statusLabel }}
                </div>

                <h1 class="demina-exhibition-show__title">
                    {{ $exhibition->title }}
                </h1>

                @if($exhibition->subtitle)
                    <p class="demina-exhibition-show__subtitle">
                        {{ $exhibition->subtitle }}
                    </p>
                @endif

                <div class="demina-exhibition-show__facts">
                    <div class="demina-exhibition-show__fact">
                        <div class="demina-exhibition-show__fact-label">Inicio</div>
                        <div class="demina-exhibition-show__fact-value">{{ $startDate }}</div>
                    </div>

                    <div class="demina-exhibition-show__fact">
                        <div class="demina-exhibition-show__fact-label">Cierre</div>
                        <div class="demina-exhibition-show__fact-value">{{ $endDate }}</div>
                    </div>

                    <div class="demina-exhibition-show__fact">
                        <div class="demina-exhibition-show__fact-label">Curaduría</div>
                        <div class="demina-exhibition-show__fact-value">
                            {{ $exhibition->curator?->name ?? '—' }}
                        </div>
                    </div>

                    <div class="demina-exhibition-show__fact">
                        <div class="demina-exhibition-show__fact-label">Espacio</div>
                        <div class="demina-exhibition-show__fact-value">
                            {{ $exhibition->spaces->pluck('name')->join(', ') ?: '—' }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="demina-exhibition-show__body">
            <article>
                @if($exhibition->short_description)
                    <p class="demina-exhibition-show__lead">
                        {{ $exhibition->short_description }}
                    </p>
                @endif

                @if($exhibition->description)
                    <div class="demina-exhibition-show__prose">
                        {!! $exhibition->description !!}
                    </div>
                @endif

                @if($exhibition->people->isNotEmpty())
                    <section class="demina-exhibition-show__section">
                        <h2 class="demina-exhibition-show__section-title">Participan</h2>

                        <div class="demina-exhibition-show__pills">
                            @foreach($exhibition->people as $person)
                                <span class="demina-exhibition-show__pill">
                                    {{ $person->name }}
                                </span>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if($exhibition->artworks->isNotEmpty())
                    <section class="demina-exhibition-show__section">
                        <h2 class="demina-exhibition-show__section-title">Obras</h2>

                        <div class="demina-exhibition-show__pills">
                            @foreach($exhibition->artworks as $artwork)
                                <span class="demina-exhibition-show__pill">
                                    {{ $artwork->title }}
                                </span>
                            @endforeach
                        </div>
                    </section>
                @endif
            </article>

            <aside class="demina-exhibition-show__side">
                <div class="demina-exhibition-show__side-box">
                    <h2 class="demina-exhibition-show__side-title">
                        Información
                    </h2>

                    <div class="demina-exhibition-show__pills">
                        <span class="demina-exhibition-show__pill">{{ $statusLabel }}</span>
                        <span class="demina-exhibition-show__pill">Inicio: {{ $startDate }}</span>
                        <span class="demina-exhibition-show__pill">Cierre: {{ $endDate }}</span>
                    </div>
                </div>

                <a href="{{ route('exhibitions.index') }}" class="demina-exhibition-show__back">
                    Volver a exposiciones
                </a>
            </aside>
        </section>
    </main>
@endsection