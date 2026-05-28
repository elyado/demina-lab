@extends('layouts.public')

@section('content')

<main class="bg-neutral-950 text-white">
    <section class="border-b border-neutral-800">
        <div class="mx-auto max-w-6xl px-6 py-20">
            <p class="mb-4 text-xs uppercase tracking-[0.35em] text-cyan-300">
                Memoria / Programación pasada
            </p>

            <h1 class="max-w-4xl text-5xl font-black leading-none md:text-7xl">
                Archivo
            </h1>

            <p class="mt-6 max-w-2xl text-lg leading-relaxed text-neutral-400">
                Registro de actividades, funciones de cineclub, talleres, encuentros y eventos realizados en Demina.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-6 py-16">
        @if($events->count())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($events as $event)
                    @php
                        $isCineclub = $event->activityType?->slug === 'cineclub';

                        $eventImage = $isCineclub
                            ? ($event->film_poster_image ?: $event->cover_image)
                            : $event->cover_image;

                        $eventTitle = $isCineclub
                            ? ($event->film_title ?: $event->title)
                            : $event->title;
                    @endphp

                    <article class="overflow-hidden rounded-3xl border border-neutral-800 bg-neutral-900">
                        @if($eventImage)
                            <a href="{{ route('events.show', $event) }}">
                                <img
                                    src="{{ \Illuminate\Support\Str::startsWith($eventImage, ['http://', 'https://']) ? $eventImage : asset('storage/' . $eventImage) }}"
                                    alt="{{ $eventTitle }}"
                                    class="h-72 w-full object-cover grayscale transition hover:grayscale-0"
                                    loading="lazy"
                                >
                            </a>
                        @endif

                        <div class="p-6">
                            <p class="mb-3 text-xs uppercase tracking-[0.25em] text-neutral-500">
                                {{ $isCineclub ? 'Cineclub' : ($event->activityType?->name ?? 'Evento') }}
                            </p>

                            <h2 class="text-2xl font-bold">
                                <a href="{{ route('events.show', $event) }}" class="hover:text-cyan-300">
                                    {{ $eventTitle }}
                                </a>
                            </h2>

                            @if($isCineclub && ($event->film_director || $event->film_year))
                                <p class="mt-2 text-sm text-neutral-400">
                                    @if($event->film_director)
                                        Dir. {{ $event->film_director }}
                                    @endif

                                    @if($event->film_year)
                                        · {{ $event->film_year }}
                                    @endif
                                </p>
                            @endif

                            <p class="mt-4 text-sm uppercase tracking-wide text-neutral-400">
                                {{ $event->start_date?->translatedFormat('d F Y') }}

                                @if($event->start_time)
                                    · {{ \Illuminate\Support\Carbon::parse($event->start_time)->format('H:i') }} h
                                @endif
                            </p>

                            @if($event->space)
                                <p class="mt-1 text-sm text-neutral-500">
                                    {{ $event->space->name }}
                                </p>
                            @endif

                            <a href="{{ route('events.show', $event) }}" class="mt-6 inline-flex rounded-full border border-neutral-700 px-4 py-2 text-sm font-semibold hover:bg-white hover:text-black">
                                Ver registro
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $events->links() }}
            </div>
        @else
            <div class="rounded-3xl border border-neutral-800 bg-neutral-900 p-10 text-neutral-400">
                Todavía no hay actividades archivadas.
            </div>
        @endif
    </section>
</main>

@endsection