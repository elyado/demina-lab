@extends('layouts.public')

@section('title', $space->name . ' — DEMINA')

@section('meta_description', $space->short_description ?? 'Espacio de DEMINA Laboratorio de Artes.')

@section('content')
    @php
        $images = $space->images->sortBy('sort_order');
        $cover = $images->first();
        $coverUrl = $cover ? asset('storage/' . $cover->image_path) : null;
    @endphp

    <main class="demina-space-show">
        <section class="demina-space-show__hero">
            <div class="demina-space-show__image">
                @if($coverUrl)
                    <img src="{{ $coverUrl }}" alt="{{ $cover->alt_text ?: $space->name }}">
                @else
                    <div class="demina-space-show__fallback"></div>
                @endif
            </div>

            <div class="demina-space-show__overlay"></div>

            <div class="demina-space-show__content">
                <div class="demina-space-show__breadcrumb">
                    <a href="{{ route('spaces.index') }}">Espacios</a> / {{ $space->name }}
                </div>

                <div class="demina-space-show__eyebrow">
                    Espacio DEMINA
                </div>

                <h1 class="demina-space-show__title">
                    {{ $space->name }}
                </h1>

                @if($space->short_description)
                    <p class="demina-space-show__short">
                        {{ $space->short_description }}
                    </p>
                @endif
            </div>
        </section>

        <section class="demina-space-show__body">
            <article>
                @if($space->description)
                    <div class="demina-space-show__prose">
                        {!! $space->description !!}
                    </div>
                @endif

                @if($images->count() > 1)
                    <section class="demina-space-show__section">
                        <h2 class="demina-space-show__section-title">
                            Galería
                        </h2>

                        <div class="demina-space-show__gallery">
                            @foreach($images->skip(1) as $image)
                                <figure class="demina-space-show__gallery-item">
                                    <img
                                        src="{{ asset('storage/' . $image->image_path) }}"
                                        alt="{{ $image->alt_text ?: $space->name }}"
                                        loading="lazy"
                                    >

                                    @if($image->caption)
                                        <figcaption class="demina-space-show__caption">
                                            {{ $image->caption }}
                                        </figcaption>
                                    @endif
                                </figure>
                            @endforeach
                        </div>
                    </section>
                @endif
            </article>

            <aside class="demina-space-show__side">
                <div class="demina-space-show__side-box">
                    <h2 class="demina-space-show__side-title">
                        Equipo disponible
                    </h2>

                    @if($space->equipment->isNotEmpty())
                        <div class="demina-space-show__pills">
                            @foreach($space->equipment as $item)
                                <span class="demina-space-show__pill">
                                    {{ $item->name }}
                                    @if(!empty($item->quantity) && $item->quantity > 1)
                                        × {{ $item->quantity }}
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    @else
                        <div class="demina-space-show__pill">
                            Sin equipo registrado
                        </div>
                    @endif
                </div>

                <a href="{{ route('spaces.index') }}" class="demina-space-show__back">
                    Volver a espacios
                </a>
            </aside>
        </section>
    </main>
@endsection