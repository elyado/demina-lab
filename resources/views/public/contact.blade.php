@extends('layouts.public')

@section('title', 'Contacto — DEMINA')

@section('meta_description', 'Contacto de DEMINA Laboratorio de Artes en Acapulco, Guerrero.')

@section('content')
<main class="demina-contact">
    <section class="demina-contact__hero">
        <div class="demina-contact__hero-inner">
            <div class="demina-contact__eyebrow">
                Contacto
            </div>

            <h1 class="demina-contact__title">
                Visítanos
            </h1>

            <p class="demina-contact__intro">
                DEMINA Laboratorio de Artes es un espacio para creación, exhibición, formación y encuentro en Acapulco.
            </p>
        </div>
    </section>

    <section class="demina-contact__content">
        <div class="demina-contact__panel">
            <h2 class="demina-contact__panel-title">
                Información
            </h2>

            <div class="demina-contact__list">
                @if(!empty($siteSetting?->address))
                <div>
                    <div class="demina-contact__item-label">Dirección</div>
                    <div class="demina-contact__item-value">
                        {{ $siteSetting->address }}
                        @if(!empty($siteSetting->city) || !empty($siteSetting->state) || !empty($siteSetting->country))
                        <br>
                        {{ collect([$siteSetting->city, $siteSetting->state, $siteSetting->country])->filter()->join(', ') }}
                        @endif
                    </div>
                </div>
                @endif

                @if(!empty($siteSetting?->email))
                <div>
                    <div class="demina-contact__item-label">Correo</div>
                    <div class="demina-contact__item-value">
                        <a href="mailto:{{ $siteSetting->email }}">
                            {{ $siteSetting->email }}
                        </a>
                    </div>
                </div>
                @endif

                @if(!empty($siteSetting?->phone))
                <div>
                    <div class="demina-contact__item-label">Teléfono</div>
                    <div class="demina-contact__item-value">
                        <a href="tel:{{ preg_replace('/\D+/', '', $siteSetting->phone) }}">
                            {{ $siteSetting->phone }}
                        </a>
                    </div>
                </div>
                @endif

                @if(!empty($siteSetting?->whatsapp))
                <div>
                    <div class="demina-contact__item-label">WhatsApp</div>
                    <div class="demina-contact__item-value">
                        <a href="https://wa.me/{{ preg_replace('/\D+/', '', $siteSetting->whatsapp) }}" target="_blank" rel="noopener noreferrer">
                            {{ $siteSetting->whatsapp }}
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <div class="demina-contact__actions">
                @if(!empty($siteSetting?->email))
                <a href="mailto:{{ $siteSetting->email }}" class="demina-contact__button">
                    Escribir correo
                </a>
                @endif

                @if(!empty($siteSetting?->whatsapp))
                <a href="https://wa.me/{{ preg_replace('/\D+/', '', $siteSetting->whatsapp) }}" target="_blank" rel="noopener noreferrer" class="demina-contact__button demina-contact__button--ghost">
                    WhatsApp
                </a>
                @endif
            </div>

            <div class="demina-contact__socials">
                @if(!empty($siteSetting?->instagram_url))
                <a href="{{ $siteSetting->instagram_url }}" target="_blank" rel="noopener noreferrer" class="demina-contact__social">Instagram</a>
                @endif

                @if(!empty($siteSetting?->facebook_url))
                <a href="{{ $siteSetting->facebook_url }}" target="_blank" rel="noopener noreferrer" class="demina-contact__social">Facebook</a>
                @endif

                @if(!empty($siteSetting?->youtube_url))
                <a href="{{ $siteSetting->youtube_url }}" target="_blank" rel="noopener noreferrer" class="demina-contact__social">YouTube</a>
                @endif

                @if(!empty($siteSetting?->tiktok_url))
                <a href="{{ $siteSetting->tiktok_url }}" target="_blank" rel="noopener noreferrer" class="demina-contact__social">TikTok</a>
                @endif
            </div>
        </div>

        <div class="demina-contact__panel">
            <h2 class="demina-contact__panel-title">
                Mapa
            </h2>

            @if(!empty($siteSetting?->google_maps_url))
            <iframe
                src="{{ $siteSetting->google_maps_url }}"
                class="demina-contact__map"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen></iframe>

            <div style="height: 1rem;"></div>

            <a href="{{ $siteSetting->google_maps_url }}" target="_blank" rel="noopener noreferrer" class="demina-contact__button">
                Abrir en Google Maps
            </a>
            @else
            <div class="demina-contact__map-placeholder">
                Google Maps no configurado
            </div>
            @endif
        </div>
    </section>
</main>
@endsection