@extends('layouts.public')

@section('title', 'Archivo — DEMINA')

@section('meta_description', 'Archivo, prensa, documentación y registros de DEMINA Laboratorio de Artes.')

@section('content')
    <main class="demina-archive">
        <section class="demina-archive__hero">
            <div class="demina-archive__hero-inner">
                <div class="demina-archive__eyebrow">
                    Documentación
                </div>

                <h1 class="demina-archive__title">
                    Archivo
                </h1>

                <p class="demina-archive__intro">
                    Prensa, registros, notas, documentos, publicaciones y materiales relacionados con los procesos de DEMINA.
                </p>
            </div>
        </section>

        <section class="demina-archive__content">
            @if($archiveItems->count())
                <div class="demina-archive-list">
                    @foreach($archiveItems as $item)
                        @php
                            $image = $item['cover_image'] ?? null;

                            $imageUrl = $image
                                ? (\Illuminate\Support\Str::startsWith($image, ['http://', 'https://'])
                                    ? $image
                                    : asset('storage/' . $image))
                                : null;

                            $publishedDate = !empty($item['date'])
                                ? \Illuminate\Support\Carbon::parse($item['date'])->format('d/m/Y')
                                : null;

                            $href = $item['external_url'] ?: '#';
                        @endphp

                        <a
                            href="{{ $href }}"
                            class="demina-archive-item"
                            @if($item['external_url']) target="_blank" rel="noopener noreferrer" @endif
                        >
                            <div class="demina-archive-item__image">
                                @if($imageUrl)
                                    <img src="{{ $imageUrl }}" alt="{{ $item['title'] }}" loading="lazy">
                                @else
                                    <div class="demina-archive-item__placeholder">
                                        Sin imagen
                                    </div>
                                @endif
                            </div>

                            <div class="demina-archive-item__body">
                                <div class="demina-archive-item__label demina-archive-item__label--{{ $item['type'] }}">
                                    {{ $item['label'] }}
                                </div>

                                <h2 class="demina-archive-item__title">
                                    {{ $item['title'] }}
                                </h2>

                                <div class="demina-archive-item__meta">
                                    @if(!empty($item['medium']))
                                        {{ $item['medium'] }}
                                    @endif

                                    @if(!empty($item['medium']) && $publishedDate)
                                        ·
                                    @endif

                                    @if($publishedDate)
                                        {{ $publishedDate }}
                                    @endif

                                    @if(!empty($item['author']))
                                        · {{ $item['author'] }}
                                    @endif
                                </div>

                                @if(!empty($item['excerpt']))
                                    <p class="demina-archive-item__excerpt">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($item['excerpt']), 260) }}
                                    </p>
                                @endif

                                @if(!empty($item['tags']) && $item['tags']->isNotEmpty())
                                    <div class="demina-archive-item__tags">
                                        @foreach($item['tags'] as $tag)
                                            <span class="demina-archive-item__tag">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                @if($item['external_url'])
                                    <span class="demina-archive-item__external">
                                        Ver publicación →
                                    </span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="demina-archive__pagination">
                    {{ $archiveItems->links() }}
                </div>
            @else
                <div class="demina-archive__empty">
                    Todavía no hay elementos publicados en archivo.
                </div>
            @endif
        </section>
    </main>
@endsection