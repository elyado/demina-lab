@extends('layouts.public')

@section('title', $call->title . ' — DEMINA')

@section('meta_description', $call->short_description ?? 'Convocatoria de DEMINA Laboratorio de Artes.')

@section('content')
    @php
        $image = $call->cover_image;
        $imageUrl = $image
            ? (\Illuminate\Support\Str::startsWith($image, ['http://', 'https://'])
                ? $image
                : asset('storage/' . $image))
            : null;

        $startDate = $call->start_date ? \Illuminate\Support\Carbon::parse($call->start_date)->format('d/m/Y') : 'Por confirmar';
        $endDate = $call->end_date ? \Illuminate\Support\Carbon::parse($call->end_date)->format('d/m/Y') : 'Por confirmar';

        $statusLabel = match ($call->status) {
            'open' => 'Abierta',
            'closed' => 'Cerrada',
            'archived' => 'Archivada',
            default => 'Borrador',
        };
    @endphp

    <main class="demina-call-show">
        <section class="demina-call-show__hero">
            <div class="demina-call-show__image">
                @if($imageUrl)
                    <img src="{{ $imageUrl }}" alt="{{ $call->title }}">
                @else
                    <div class="demina-call-show__fallback"></div>
                @endif
            </div>

            <div class="demina-call-show__overlay"></div>

            <div class="demina-call-show__content">
                <div class="demina-call-show__breadcrumb">
                    <a href="{{ route('calls.index') }}">Convocatorias</a> / {{ $call->title }}
                </div>

                <h1 class="demina-call-show__title">
                    {{ $call->title }}
                </h1>

                @if($call->short_description)
                    <p class="demina-call-show__short">
                        {{ $call->short_description }}
                    </p>
                @endif

                <div class="demina-call-show__facts">
                    <div class="demina-call-show__fact">
                        <div class="demina-call-show__fact-label">Estado</div>
                        <div class="demina-call-show__fact-value">{{ $statusLabel }}</div>
                    </div>

                    <div class="demina-call-show__fact">
                        <div class="demina-call-show__fact-label">Apertura</div>
                        <div class="demina-call-show__fact-value">{{ $startDate }}</div>
                    </div>

                    <div class="demina-call-show__fact">
                        <div class="demina-call-show__fact-label">Cierre</div>
                        <div class="demina-call-show__fact-value">{{ $endDate }}</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="demina-call-show__body">
            @if($call->description)
                <div class="demina-call-show__section">
                    <h2>Descripción</h2>
                    <div class="demina-call-show__prose">
                        {!! $call->description !!}
                    </div>
                </div>
            @endif

            @if($call->requirements)
                <div class="demina-call-show__section">
                    <h2>Requisitos</h2>
                    <div class="demina-call-show__prose">
                        {!! $call->requirements !!}
                    </div>
                </div>
            @endif

            <div class="demina-call-show__actions">
                @if($call->status === 'open' && $call->form_url)
                    <a href="{{ $call->form_url }}" target="_blank" rel="noopener noreferrer" class="demina-call-show__button">
                        Aplicar / llenar formulario
                    </a>
                @endif

                <a href="{{ route('calls.index') }}" class="demina-call-show__button demina-call-show__button--ghost">
                    Volver a convocatorias
                </a>
            </div>
        </section>
    </main>
@endsection