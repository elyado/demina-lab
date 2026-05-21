@extends('layouts.public')

@section('content')

<main class="bg-neutral-950 text-white">
    <section class="border-b border-neutral-800">
        <div class="mx-auto grid max-w-6xl gap-10 px-6 py-16 lg:grid-cols-[0.9fr_1.1fr] lg:py-24">

            <div>
                @if($event->film_poster_image || $event->cover_image)
                    <img
                        src="{{ asset('storage/' . ($event->film_poster_image ?: $event->cover_image)) }}"
                        alt="{{ $event->film_title ?: $event->title }}"
                        class="aspect-[3/4] w-full rounded-3xl object-cover"
                    >
                @endif
            </div>

            <div class="flex flex-col justify-center">
                <p class="mb-4 text-xs uppercase tracking-[0.35em] text-cyan-300">
                    Cineclub · Película de la semana
                </p>

                <h1 class="text-5xl font-black leading-none md:text-7xl">
                    {{ $event->film_title ?: $event->title }}
                </h1>

                @if($event->film_original_title)
                    <p class="mt-4 text-xl text-neutral-400">
                        {{ $event->film_original_title }}
                    </p>
                @endif

                <div class="mt-6 space-y-2 text-neutral-300">
                    <p>
                        @if($event->film_director)
                            Dir. {{ $event->film_director }}
                        @endif

                        @if($event->film_year)
                            · {{ $event->film_year }}
                        @endif

                        @if($event->film_classification)
                            · {{ $event->film_classification }}
                        @endif

                        @if($event->film_duration_minutes)
                            · {{ $event->film_duration_minutes }} min
                        @endif
                    </p>

                    @if($event->film_country || $event->film_genre)
                        <p>
                            {{ $event->film_country }}
                            @if($event->film_country && $event->film_genre)
                                ·
                            @endif
                            {{ $event->film_genre }}
                        </p>
                    @endif
                </div>

                <div class="mt-10 rounded-3xl border border-neutral-800 bg-neutral-900 p-6">
                    <p class="text-sm uppercase tracking-[0.25em] text-neutral-400">
                        Función
                    </p>

                    <div class="mt-4 grid gap-4 text-lg md:grid-cols-2">
                        <div>
                            <p class="text-neutral-500">Fecha</p>
                            <p class="font-semibold">
                                {{ $event->start_date?->translatedFormat('l d F Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-neutral-500">Hora</p>
                            <p class="font-semibold">
                                @if($event->start_time)
                                    {{ \Illuminate\Support\Carbon::parse($event->start_time)->format('H:i') }} h
                                @else
                                    Por confirmar
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-neutral-500">Espacio</p>
                            <p class="font-semibold">
                                {{ $event->space?->name ?? 'Por confirmar' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-neutral-500">Entrada</p>
                            <p class="font-semibold">
                                @if($event->is_free)
                                    Entrada libre
                                @elseif($event->recovery_fee)
                                    ${{ number_format($event->recovery_fee, 2) }} MXN
                                @elseif($event->price)
                                    ${{ number_format($event->price, 2) }} MXN
                                @else
                                    Por confirmar
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('agenda.index') }}" class="rounded-full border border-neutral-700 px-5 py-3 text-sm hover:bg-white hover:text-black">
                        Volver a agenda
                    </a>

                    @if($event->film_trailer_url)
                        <a href="#trailer" class="rounded-full bg-white px-5 py-3 text-sm font-semibold text-black">
                            Ver trailer
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-6 py-16">
        @if($event->film_synopsis)
            <div class="prose prose-invert max-w-none prose-p:text-xl prose-p:leading-relaxed">
                {!! $event->film_synopsis !!}
            </div>
        @endif

        @if($event->description)
            <div class="prose prose-invert mt-10 max-w-none border-t border-neutral-800 pt-10 prose-p:text-lg prose-p:leading-relaxed">
                {!! $event->description !!}
            </div>
        @endif
    </section>

    @if($event->film_trailer_embed_url)
        <section id="trailer" class="mx-auto max-w-5xl px-6 pb-20">
            <h2 class="mb-6 text-3xl font-bold">Trailer</h2>

            <div class="overflow-hidden rounded-3xl border border-neutral-800">
                <iframe
                    src="{{ $event->film_trailer_embed_url }}"
                    class="aspect-video w-full"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen
                ></iframe>
            </div>
        </section>
    @endif
</main>

@endsection