<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title', $siteSetting->site_name ?? 'DEMINA Laboratorio de Artes')
    </title>

    <meta name="description" content="@yield('meta_description', $siteSetting->meta_description ?? 'Laboratorio de artes, creación, experimentación y comunidad en Acapulco.')">
    @if (!empty($siteSetting?->favicon_path))
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $siteSetting->favicon_path) }}">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-neutral-950 text-neutral-100 antialiased">
    <div class="min-h-screen flex flex-col">

        <header class="public-header">
            <div class="public-header__inner">
                <a href="{{ route('home') }}" class="public-header__brand" aria-label="{{ $siteSetting->site_name ?? 'DEMINA Laboratorio de Artes' }}">
                    @if (!empty($siteSetting?->logo_path))
                    <img
                        src="{{ asset('storage/' . $siteSetting->logo_path) }}"
                        alt="{{ $siteSetting->site_name ?? 'DEMINA Laboratorio de Artes' }}"
                        class="public-header__logo">
                    @else
                    <span class="public-header__fallback">
                        DEMINA
                    </span>
                    @endif
                </a>

                <nav class="public-header__nav" aria-label="Navegación principal">
                    <a href="{{ route('home') }}" class="public-header__link {{ request()->routeIs('home') ? 'is-active' : '' }}">
                        Inicio
                    </a>

                    <a href="{{ route('agenda.index') }}" class="public-header__link {{ request()->routeIs('agenda.index') || request()->routeIs('events.show') ? 'is-active' : '' }}">
                        Agenda
                    </a>

                    <a href="{{ route('exhibitions.index') }}" class="public-header__link {{ request()->routeIs('exhibitions.index') || request()->routeIs('exhibitions.show') ? 'is-active' : '' }}">
                        Exposiciones
                    </a>

                    <a href="{{ route('spaces.index') }}" class="public-header__link {{ request()->routeIs('spaces.index') || request()->routeIs('spaces.show') ? 'is-active' : '' }}">
                        Espacios
                    </a>
                    <a href="{{ route('calls.index') }}" class="public-header__link {{ request()->routeIs('calls.index') || request()->routeIs('calls.show') ? 'is-active' : '' }}">
                        Convocatorias
                    </a>

                    <a href="{{ route('archive.index') }}" class="public-header__link {{ request()->routeIs('archive.index') ? 'is-active' : '' }}">
                        Archivo
                    </a>

                    <a href="{{ route('contact') }}" class="public-header__link {{ request()->routeIs('contact') ? 'is-active' : '' }}">
                        Contacto
                    </a>
                </nav>

                <div class="public-header__actions">
                    <a href="{{ route('agenda.index') }}" class="public-header__cta">
                        Ver agenda
                    </a>
                </div>
            </div>
        </header>

        <main class="flex-1">
            @yield('content')
        </main>

        <footer class="public-footer">
            <div class="public-footer__inner">
                <div class="public-footer__grid">
                    <div>
                        <div class="public-footer__brand">
                            @if (!empty($siteSetting?->logo_path))
                            <img
                                src="{{ asset('storage/' . $siteSetting->logo_path) }}"
                                alt="{{ $siteSetting->site_name ?? 'DEMINA Laboratorio de Artes' }}"
                                class="public-footer__logo">
                            @else
                            <div class="public-footer__fallback">
                                DEMINA<br>
                                LAB. DE ARTES
                            </div>
                            @endif
                        </div>

                        <p class="public-footer__tagline">
                            {{ $siteSetting->tagline ?? 'Laboratorio de artes, creación, experimentación y comunidad. Acapulco, Guerrero.' }}
                        </p>
                    </div>

                    <div>
                        <div class="public-footer__label">
                            Navegación
                        </div>

                        <ul class="public-footer__links">
                            <li><a href="{{ route('home') }}">Inicio</a></li>
                            <li><a href="{{ route('agenda.index') }}">Agenda</a></li>
                            <li><a href="{{ route('people.index') }}">Personas</a></li>
                            <li><a href="{{ route('spaces.index') }}">Espacios</a></li>
                            <li><a href="{{ route('partners.index') }}">Aliados</a></li>

                        </ul>
                    </div>

                    <div>
                        <div class="public-footer__label">
                            Contacto
                        </div>

                        <div class="public-footer__contact">
                            @if(!empty($siteSetting?->email))
                            <a href="mailto:{{ $siteSetting->email }}">
                                {{ $siteSetting->email }}
                            </a>
                            @endif

                            @if(!empty($siteSetting?->phone))
                            <a href="tel:{{ preg_replace('/\D+/', '', $siteSetting->phone) }}">
                                {{ $siteSetting->phone }}
                            </a>
                            @endif

                            @if(!empty($siteSetting?->address))
                            <div>
                                {{ $siteSetting->address }}<br>
                                {{ collect([$siteSetting->city, $siteSetting->state, $siteSetting->country])->filter()->join(', ') }}
                            </div>
                            @endif
                        </div>

                        <div class="public-footer__socials">
                            @if(!empty($siteSetting?->instagram_url))
                            <a href="{{ $siteSetting->instagram_url }}" target="_blank" rel="noopener noreferrer" class="public-footer__social">
                                Instagram
                            </a>
                            @endif

                            @if(!empty($siteSetting?->facebook_url))
                            <a href="{{ $siteSetting->facebook_url }}" target="_blank" rel="noopener noreferrer" class="public-footer__social">
                                Facebook
                            </a>
                            @endif

                            @if(!empty($siteSetting?->youtube_url))
                            <a href="{{ $siteSetting->youtube_url }}" target="_blank" rel="noopener noreferrer" class="public-footer__social">
                                YouTube
                            </a>
                            @endif

                            @if(!empty($siteSetting?->tiktok_url))
                            <a href="{{ $siteSetting->tiktok_url }}" target="_blank" rel="noopener noreferrer" class="public-footer__social">
                                TikTok
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="public-footer__bottom">
                    <span>
                        © {{ now()->year }} {{ $siteSetting->site_name ?? 'DEMINA Laboratorio de Artes' }} · Hecho con ❤️ x <a href="https://palmerasoft.com" target="_new">🌴</a>
                    </span>

                    <span>
                        Acapulco · Guerrero · México
                    </span>
                </div>
            </div>
        </footer>

    </div>
</body>

</html>