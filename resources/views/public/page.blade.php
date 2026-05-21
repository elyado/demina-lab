@extends('layouts.public')

@section('title', $page->seo_title ?? $page->title . ' — DEMINA')

@section('meta_description', $page->seo_description ?? $page->excerpt ?? 'Página de DEMINA Laboratorio de Artes.')

@section('content')
    <article class="bg-neutral-950">
        <header class="border-b border-neutral-800">
            <div class="mx-auto max-w-4xl px-4 py-20 sm:px-6 lg:px-8">
                <p class="mb-5 text-sm font-semibold uppercase tracking-[0.2em] text-neutral-400">
                    DEMINA
                </p>

                <h1 class="text-4xl font-black tracking-tight text-white sm:text-6xl">
                    {{ $page->title }}
                </h1>

                @if(!empty($page->excerpt))
                    <p class="mt-6 text-lg leading-8 text-neutral-300">
                        {{ $page->excerpt }}
                    </p>
                @endif
            </div>
        </header>

        <section class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="prose prose-invert max-w-none prose-headings:font-black prose-a:text-fuchsia-300 prose-strong:text-white">
                {!! $page->content !!}
            </div>
        </section>
    </article>
@endsection