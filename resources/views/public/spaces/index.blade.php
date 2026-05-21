@extends('layouts.public')

@section('title', 'Espacios — DEMINA')

@section('meta_description', 'Espacios de DEMINA Laboratorio de Artes: áreas de exhibición, creación, formación, proyección y encuentro.')

@section('content')
    <main class="demina-spaces-page">
        <section class="demina-spaces-page__hero">
            <div class="demina-spaces-page__hero-inner">
                <div class="demina-spaces-page__eyebrow">
                    Infraestructura
                </div>

                <h1 class="demina-spaces-page__title">
                    Espacios
                </h1>

                <p class="demina-spaces-page__intro">
                    Áreas de exhibición, creación, formación, proyección, encuentro y experimentación artística dentro de DEMINA.
                </p>
            </div>
        </section>

        <section class="demina-spaces-page__content">
            @if($spaces->count())
                <div class="demina-spaces-page__grid">
                    @foreach($spaces as $space)
                        @php
                            $cover = $space->images->sortBy('sort_order')->first();
                            $imageUrl = $cover ? asset('storage/' . $cover->image_path) : null;
                        @endphp

                        <a href="{{ route('spaces.show', $space->slug) }}" class="demina-space-list-card">
                            <div class="demina-space-list-card__image">
                                @if($imageUrl)
                                    <img src="{{ $imageUrl }}" alt="{{ $cover->alt_text ?: $space->name }}" loading="lazy">
                                @else
                                    <div class="demina-space-list-card__fallback"></div>
                                @endif
                            </div>

                            <div class="demina-space-list-card__overlay"></div>

                            <div class="demina-space-list-card__content">
                                <div class="demina-space-list-card__num">
                                    E_{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </div>

                                <h2 class="demina-space-list-card__title">
                                    {{ $space->name }}
                                </h2>

                                @if($space->short_description)
                                    <p class="demina-space-list-card__description">
                                        {{ $space->short_description }}
                                    </p>
                                @elseif($space->description)
                                    <p class="demina-space-list-card__description">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($space->description), 120) }}
                                    </p>
                                @endif

                                @if($space->equipment->isNotEmpty())
                                    <div class="demina-space-list-card__equipment">
                                        @foreach($space->equipment->take(3) as $item)
                                            <span class="demina-space-list-card__pill">
                                                {{ $item->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="demina-spaces-page__pagination">
                    {{ $spaces->links() }}
                </div>
            @else
                <div class="demina-spaces-page__empty">
                    Todavía no hay espacios activos publicados.
                </div>
            @endif
        </section>
    </main>
@endsection