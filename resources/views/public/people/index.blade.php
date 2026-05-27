@extends('layouts.public')

@section('title', 'Personas — DEMINA')

@section('meta_description', 'Personas, equipo, artistas, talleristas, curadorxs y colaboradorxs de DEMINA Laboratorio de Artes.')

@section('content')
    <main class="demina-people">
        <section class="demina-people__hero">
            <div class="demina-people__hero-inner">
                <div class="demina-people__eyebrow">
                    Comunidad DEMINA
                </div>

                <h1 class="demina-people__title">
                    Personas
                </h1>

                <p class="demina-people__intro">
                    Equipo, artistas, talleristas, curadorxs, colaboradorxs y personas que participan en los procesos de DEMINA.
                </p>
            </div>
        </section>

        @if($teamPeople->count())
            <section class="demina-people__section" id="equipo">
                <div class="demina-people__section-head">
                    <h2 class="demina-people__section-title">
                        Equipo<br>DEMINA
                    </h2>

                    <p class="demina-people__section-note">
                        Personas que sostienen la gestión, programación, producción y operación cotidiana del laboratorio.
                    </p>
                </div>

                <div class="demina-people-grid">
                    @foreach($teamPeople as $person)
                        @include('public.people.partials.card', ['person' => $person])
                    @endforeach
                </div>
            </section>
        @endif

        <section class="demina-people__section">
            <div class="demina-people__section-head">
                <h2 class="demina-people__section-title">
                    Red<br>creativa
                </h2>

                <p class="demina-people__section-note">
                    Artistas, talleristas, curadorxs, colaboradorxs y participantes vinculados a exposiciones, talleres, archivo y programación.
                </p>
            </div>

            @if($people->count())
                <div class="demina-people-grid">
                    @foreach($people as $person)
                        @include('public.people.partials.card', ['person' => $person])
                    @endforeach
                </div>
            @else
                <div class="demina-people__empty">
                    Todavía no hay personas publicadas.
                </div>
            @endif
        </section>
    </main>
@endsection