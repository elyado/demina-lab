@extends('layouts.public')

@section('title', 'Talleres — DEMINA')

@section('meta_description', 'Talleres, procesos formativos y laboratorios de creación de DEMINA Laboratorio de Artes.')

@section('content')
    <main class="demina-workshops">
        <section class="demina-workshops__hero">
            <div class="demina-workshops__hero-inner">
                <div class="demina-workshops__eyebrow">
                    Formación · Laboratorio · Procesos
                </div>

                <h1 class="demina-workshops__title">
                    Talleres
                </h1>

                <p class="demina-workshops__intro">
                    Procesos formativos, laboratorios de creación, experimentación artística y espacios de aprendizaje vinculados a la programación de DEMINA.
                </p>
            </div>
        </section>

        <section class="demina-workshops__content">
            @if($workshops->count())
                <div class="demina-workshops__grid">
                    @foreach($workshops as $workshop)
                        @php
                            $statusLabel = match ($workshop->status) {
                                'published' => 'Publicado',
                                'open' => 'Inscripción abierta',
                                'active' => 'Activo',
                                default => 'Taller',
                            };

                            $costLabel = !is_null($workshop->cost)
                                ? '$' . number_format((float) $workshop->cost, 2) . ' MXN'
                                : 'Costo por confirmar';
                        @endphp

                        <a href="{{ route('workshops.show', $workshop->slug) }}" class="demina-workshop-card">
                            <div class="demina-workshop-card__body">
                                <div class="demina-workshop-card__status">
                                    {{ $statusLabel }}
                                </div>

                                <h2 class="demina-workshop-card__title">
                                    {{ $workshop->title }}
                                </h2>

                                <div class="demina-workshop-card__meta">
                                    @if($workshop->facilitator)
                                        Imparte: {{ $workshop->facilitator->name }}<br>
                                    @endif

                                    @if($workshop->capacity)
                                        Cupo: {{ $workshop->capacity }} personas<br>
                                    @endif

                                    {{ $costLabel }}
                                </div>

                                @if($workshop->description)
                                    <p class="demina-workshop-card__description">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($workshop->description), 160) }}
                                    </p>
                                @endif

                                <div class="demina-workshop-card__footer">
                                    Ver taller →
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="demina-workshops__pagination">
                    {{ $workshops->links() }}
                </div>
            @else
                <div class="demina-workshops__empty">
                    No hay talleres abiertos por el momento.
                </div>
            @endif
        </section>
    </main>
@endsection