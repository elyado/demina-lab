@extends('layouts.public')

@section('title', $workshop->title . ' — DEMINA')

@section('meta_description', 'Taller de DEMINA Laboratorio de Artes.')

@section('content')
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

<main class="demina-workshops">
    <section class="demina-workshop-show">
        <div class="demina-workshop-show__hero">
            <div class="demina-workshop-show__breadcrumb">
                <a href="{{ route('workshops.index') }}">Talleres</a> / {{ $workshop->title }}
            </div>

            <div class="demina-workshop-show__status">
                {{ $statusLabel }}
            </div>

            <h1 class="demina-workshop-show__title">
                {{ $workshop->title }}
            </h1>

            <div class="demina-workshop-show__facts">
                <div>
                    <span>Imparte</span>
                    <strong>{{ $workshop->facilitator?->name ?? 'Por confirmar' }}</strong>
                </div>

                <div>
                    <span>Cupo</span>
                    <strong>{{ $workshop->capacity ? $workshop->capacity . ' personas' : 'Por confirmar' }}</strong>
                </div>

                <div>
                    <span>Costo</span>
                    <strong>{{ $costLabel }}</strong>
                </div>

                @if($workshop->event)
                <div>
                    <span>Actividad relacionada</span>
                    <strong>{{ $workshop->event->title }}</strong>
                </div>
                @endif
            </div>
        </div>

        <div class="demina-workshop-show__body">
            <article>
                @if($workshop->description)
                <section class="demina-workshop-show__section">
                    <h2>Descripción</h2>
                    <div class="demina-workshop-show__prose">
                        {!! $workshop->description !!}
                    </div>
                </section>
                @endif

                @if($workshop->materials)
                <section class="demina-workshop-show__section">
                    <h2>Materiales</h2>
                    <div class="demina-workshop-show__prose">
                        {!! $workshop->materials !!}
                    </div>
                </section>
                @endif

                @if($workshop->registration_instructions)
                <section class="demina-workshop-show__section">
                    <h2>Inscripción</h2>
                    <div class="demina-workshop-show__prose">
                        {!! $workshop->registration_instructions !!}
                    </div>
                </section>
                @endif

                @if(!empty($workshop->payment_methods))
                <section class="demina-workshop-show__section">
                    <h2>Formas de pago</h2>

                    <div class="demina-workshop-show__prose">
                        @if(is_array($workshop->payment_methods))
                        <ul>
                            @foreach($workshop->payment_methods as $method)
                            @php
                            $methodLabel = match ($method) {
                            'cash' => 'Efectivo',
                            'transfer' => 'Transferencia',
                            'card' => 'Tarjeta',
                            'other' => 'Otro',
                            'deposit' => 'Depósito',
                            'paypal' => 'PayPal',
                            'mercado_pago' => 'Mercado Pago',
                            default => ucfirst(str_replace('_', ' ', $method)),
                            };
                            @endphp

                            <li>{{ $methodLabel }}</li>
                            @endforeach
                        </ul>
                        @else
                        {!! $workshop->payment_methods !!}
                        @endif
                    </div>
                </section>
                @endif
            </article>

            <aside class="demina-workshop-show__side">
                <div class="demina-workshop-show__box">
                    <h2>Información</h2>

                    <div class="demina-workshop-show__pill">{{ $statusLabel }}</div>
                    <div class="demina-workshop-show__pill">{{ $costLabel }}</div>

                    @if($workshop->capacity)
                    <div class="demina-workshop-show__pill">
                        Cupo: {{ $workshop->capacity }}
                    </div>
                    @endif

                    @if($workshop->facilitator)
                    <a href="{{ route('people.show', $workshop->facilitator->slug) }}" class="demina-workshop-show__button">
                        Ver facilitador/a
                    </a>
                    @endif

                    @if($workshop->event)
                    <a href="{{ route('events.show', $workshop->event->slug) }}" class="demina-workshop-show__button">
                        Ver evento
                    </a>
                    @endif
                </div>

                <a href="{{ route('workshops.index') }}" class="demina-workshop-show__back">
                    Volver a talleres
                </a>
            </aside>
        </div>
    </section>
</main>
@endsection