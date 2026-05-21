@extends('layouts.public')

@section('title', 'Convocatorias — DEMINA')

@section('meta_description', 'Convocatorias abiertas, cerradas y procesos de participación de DEMINA Laboratorio de Artes.')

@section('content')
    <main class="demina-calls">
        <section class="demina-calls__hero">
            <div class="demina-calls__hero-inner">
                <div class="demina-calls__eyebrow">Participación pública</div>

                <h1 class="demina-calls__title">Convocatorias</h1>

                <p class="demina-calls__intro">
                    Procesos abiertos para artistas, creadorxs, talleristas, colectivos, investigadores y comunidades interesadas en colaborar con DEMINA.
                </p>
            </div>
        </section>

        <section class="demina-calls__content">
            @if($calls->count())
                <div class="demina-calls__grid">
                    @foreach($calls as $call)
                        @php
                            $image = $call->cover_image;
                            $imageUrl = $image
                                ? (\Illuminate\Support\Str::startsWith($image, ['http://', 'https://'])
                                    ? $image
                                    : asset('storage/' . $image))
                                : null;

                            $startDate = $call->start_date ? \Illuminate\Support\Carbon::parse($call->start_date)->format('d/m/Y') : null;
                            $endDate = $call->end_date ? \Illuminate\Support\Carbon::parse($call->end_date)->format('d/m/Y') : null;

                            $statusLabel = match ($call->status) {
                                'open' => 'Abierta',
                                'closed' => 'Cerrada',
                                'archived' => 'Archivada',
                                default => 'Borrador',
                            };
                        @endphp

                        <a href="{{ route('calls.show', $call->slug) }}" class="demina-call-card">
                            <div class="demina-call-card__image">
                                @if($imageUrl)
                                    <img src="{{ $imageUrl }}" alt="{{ $call->title }}" loading="lazy">
                                @else
                                    <div class="demina-call-card__placeholder">Sin imagen</div>
                                @endif
                            </div>

                            <div class="demina-call-card__body">
                                <span class="demina-call-card__status {{ $call->status === 'closed' ? 'demina-call-card__status--closed' : '' }}">
                                    {{ $statusLabel }}
                                </span>

                                <h2 class="demina-call-card__title">
                                    {{ $call->title }}
                                </h2>

                                @if($call->short_description)
                                    <p class="demina-call-card__description">
                                        {{ $call->short_description }}
                                    </p>
                                @endif

                                <div class="demina-call-card__dates">
                                    @if($startDate)
                                        Apertura: {{ $startDate }}<br>
                                    @endif

                                    @if($endDate)
                                        Cierre: {{ $endDate }}
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="demina-calls__pagination">
                    {{ $calls->links() }}
                </div>
            @else
                <div class="demina-calls__empty">
                    No hay convocatorias publicadas por el momento.
                </div>
            @endif
        </section>
    </main>
@endsection