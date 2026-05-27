@extends('layouts.public')

@section('title', 'Aliados — DEMINA')

@section('meta_description', 'Aliados, instituciones, colectivos y colaboraciones de DEMINA Laboratorio de Artes.')

@section('content')
    <main class="demina-partners">
        <section class="demina-partners__hero">
            <div class="demina-partners__hero-inner">
                <div class="demina-partners__eyebrow">
                    Red de colaboración
                </div>

                <h1 class="demina-partners__title">
                    Aliados
                </h1>

                <p class="demina-partners__intro">
                    Instituciones, colectivos, proyectos, medios y personas aliadas que acompañan procesos de creación, exhibición, formación y comunidad.
                </p>
            </div>
        </section>

        <section class="demina-partners__content">
            @if($partners->count())
                @foreach($partners as $type => $items)
                    <section class="demina-partners__group">
                        <div class="demina-partners__group-head">
                            <h2 class="demina-partners__group-title">
                                {{ $type ?: 'Aliados' }}
                            </h2>
                        </div>

                        <div class="demina-partners__grid">
                            @foreach($items as $partner)
                                @php
                                    $logo = $partner->logo_path;
                                    $logoUrl = $logo
                                        ? (\Illuminate\Support\Str::startsWith($logo, ['http://', 'https://'])
                                            ? $logo
                                            : asset('storage/' . $logo))
                                        : null;
                                @endphp

                                <a
                                    href="{{ $partner->website_url ?: '#' }}"
                                    class="demina-partner-card"
                                    @if($partner->website_url) target="_blank" rel="noopener noreferrer" @endif
                                >
                                    <div class="demina-partner-card__logo">
                                        @if($logoUrl)
                                            <img src="{{ $logoUrl }}" alt="{{ $partner->name }}" loading="lazy">
                                        @else
                                            <span>{{ \Illuminate\Support\Str::of($partner->name)->substr(0, 1)->upper() }}</span>
                                        @endif
                                    </div>

                                    <div class="demina-partner-card__body">
                                        <h3 class="demina-partner-card__name">
                                            {{ $partner->name }}
                                        </h3>

                                        @if($partner->description)
                                            <p class="demina-partner-card__description">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($partner->description), 180) }}
                                            </p>
                                        @endif

                                        @if($partner->website_url)
                                            <span class="demina-partner-card__link">
                                                Visitar sitio →
                                            </span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            @else
                <div class="demina-partners__empty">
                    Todavía no hay aliados publicados.
                </div>
            @endif
        </section>
    </main>
@endsection