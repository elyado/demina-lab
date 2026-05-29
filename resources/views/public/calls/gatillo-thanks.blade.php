@extends('layouts.public')

@section('content')

<main class="mx-auto max-w-3xl px-6 py-20">
    <section class="rounded-3xl border border-neutral-800 bg-neutral-900 p-8 md:p-12">
        <p class="mb-4 text-sm uppercase tracking-[0.3em] text-neutral-400">
            Acuse de recibido
        </p>

        <h1 class="text-4xl font-bold md:text-6xl">
            Postulación recibida
        </h1>

        <p class="mt-6 text-lg text-neutral-300">
            Gracias, {{ $application->name }}. Tu postulación a la
            <strong>{{ $application->call_name }}</strong> fue recibida correctamente.
        </p>

        <div class="mt-8 rounded-2xl border border-neutral-700 bg-neutral-950 p-6">
            <p class="text-sm uppercase tracking-[0.25em] text-neutral-500">
                Folio de postulación
            </p>

            <p class="mt-3 text-3xl font-black text-white">
                {{ $application->folio }}
            </p>
        </div>

        <div class="mt-8 space-y-2 text-neutral-400">
            <p>
                Conserva este folio. Servirá para identificar tu postulación durante el proceso de revisión.
            </p>

            <p>
                Fecha de recepción:
                {{ $application->submitted_at?->format('d/m/Y H:i') }}
            </p>
        </div>

        <div class="mt-10 flex flex-wrap gap-3">
            <a
                href="{{ route('gatillo.form') }}"
                class="rounded-full border border-neutral-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white hover:text-black"
            >
                Enviar otra postulación
            </a>

            <a
                href="{{ url('/') }}"
                class="rounded-full bg-white px-5 py-3 text-sm font-semibold text-black transition hover:bg-neutral-300"
            >
                Volver al inicio
            </a>
        </div>
    </section>
</main>

@endsection