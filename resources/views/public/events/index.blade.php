@extends('layouts.public')

@section('content')

<main class="mx-auto max-w-6xl px-6 py-16">
    <header class="mb-12">
        <p class="mb-3 text-sm uppercase tracking-[0.3em] text-neutral-400">Demina</p>
        <h1 class="text-4xl font-bold md:text-6xl">Agenda</h1>
    </header>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($events as $event)
            @if($event->activityType?->slug === 'cineclub')
                <article class="overflow-hidden rounded-3xl border border-neutral-800 bg-neutral-900">
                    @if($event->film_poster_image || $event->cover_image)
                        <img
                            src="{{ asset('storage/' . ($event->film_poster_image ?: $event->cover_image)) }}"
                            alt="{{ $event->film_title ?: $event->title }}"
                            class="h-72 w-full object-cover"
                        >
                    @endif

                    <div class="p-6">
                        <p class="mb-3 text-xs uppercase tracking-[0.25em] text-neutral-400">
                            Cineclub · Película de la semana
                        </p>

                        <h2 class="text-2xl font-semibold">
                            {{ $event->film_title ?: $event->title }}
                        </h2>

                        <p class="mt-2 text-sm text-neutral-400">
                            @if($event->film_director)
                                Dir. {{ $event->film_director }}
                            @endif

                            @if($event->film_year)
                                · {{ $event->film_year }}
                            @endif

                            @if($event->film_classification)
                                · {{ $event->film_classification }}
                            @endif
                        </p>

                        <p class="mt-4 text-sm uppercase tracking-wide text-neutral-300">
                            {{ $event->start_date?->translatedFormat('l d F') }}
                            @if($event->start_time)
                                · {{ \Illuminate\Support\Carbon::parse($event->start_time)->format('H:i') }} h
                            @endif
                        </p>

                        <p class="mt-1 text-sm text-neutral-400">
                            {{ $event->space?->name }}
                        </p>

                        <div class="mt-6 flex gap-3">
                            <a href="{{ route('events.show', $event) }}" class="rounded-full bg-white px-4 py-2 text-sm font-medium text-black">
                                Ver detalle
                            </a>

                            @if($event->film_trailer_url)
                                <a href="{{ $event->film_trailer_url }}" target="_blank" class="rounded-full border border-neutral-700 px-4 py-2 text-sm">
                                    Ver trailer
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            @else
                <article class="overflow-hidden rounded-3xl border border-neutral-800 bg-neutral-900">
                    @if($event->cover_image)
                        <img
                            src="{{ asset('storage/' . $event->cover_image) }}"
                            alt="{{ $event->title }}"
                            class="h-72 w-full object-cover"
                        >
                    @endif

                    <div class="p-6">
                        <p class="mb-3 text-xs uppercase tracking-[0.25em] text-neutral-400">
                            {{ $event->activityType?->name ?? 'Evento' }}
                        </p>

                        <h2 class="text-2xl font-semibold">
                            {{ $event->title }}
                        </h2>

                        <p class="mt-4 text-sm uppercase tracking-wide text-neutral-300">
                            {{ $event->start_date?->translatedFormat('l d F') }}
                            @if($event->start_time)
                                · {{ \Illuminate\Support\Carbon::parse($event->start_time)->format('H:i') }} h
                            @endif
                        </p>

                        <p class="mt-1 text-sm text-neutral-400">
                            {{ $event->space?->name }}
                        </p>

                        <a href="{{ route('events.show', $event) }}" class="mt-6 inline-block rounded-full bg-white px-4 py-2 text-sm font-medium text-black">
                            Ver detalle
                        </a>
                    </div>
                </article>
            @endif
        @empty
            <p class="text-neutral-400">No hay eventos publicados por ahora.</p>
        @endforelse
    </div>
</main>

@endsection