@extends('layouts.public')

@section('content')

<main class="mx-auto max-w-4xl px-6 py-16">
    <header class="mb-10">
        <p class="mb-3 text-sm uppercase tracking-[0.3em] text-neutral-400">
            Convocatoria
        </p>

        <h1 class="text-4xl font-bold md:text-6xl">
            Convocatoria Fotográfica Gatillo
        </h1>

        <p class="mt-6 max-w-2xl text-neutral-400">
            Llena el formulario y sube tres fotografías. Cada archivo debe pesar máximo 3 MB.
        </p>
    </header>

    @if ($errors->any())
    <div class="mb-8 rounded-2xl border border-red-500/40 bg-red-950/40 p-5 text-red-100">
        <strong>Revisa los campos marcados.</strong>
        <ul class="mt-3 list-disc pl-5 text-sm">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form
        action="{{ route('gatillo.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-10">
        @csrf

        <section class="demina-form-section">
            <h2 class="mb-6 text-2xl font-bold">Datos del postulante</h2>

            <div class="grid gap-5 md:grid-cols-2">
                <div class="demina-field">
                    <label>Nombre *</label>
                    <input name="name" value="{{ old('name') }}" required class="demina-input">
                </div>

                <div class="demina-field">
                    <label>Edad</label>
                    <input type="number" name="age" value="{{ old('age') }}" class="demina-input">
                </div>

                <div class="demina-field">
                    <label>Correo *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="demina-input">
                </div>

                <div class="demina-field">
                    <label>Teléfono</label>
                    <input name="phone" value="{{ old('phone') }}" class="demina-input">
                </div>

                <div class="demina-field">
                    <label>WhatsApp</label>
                    <input name="whatsapp" value="{{ old('whatsapp') }}" class="demina-input">
                </div>

                <div class="demina-field">
                    <label>Seudónimo</label>
                    <input name="pseudonym" value="{{ old('pseudonym') }}" class="demina-input">
                </div>
            </div>
        </section>

        <section class="rounded-3xl border border-neutral-800 bg-neutral-900 p-6">
            <h2 class="mb-6 text-2xl font-bold">Datos de la obra / serie</h2>

            <div class="grid gap-5 md:grid-cols-2">
                <div class="demina-field">
                    <label>Año de captura</label>
                    <input name="capture_year" value="{{ old('capture_year') }}" class="demina-input">
                </div>

                <div class="demina-field">
                    <label>Técnica y soporte</label>
                    <input name="technique_support" value="{{ old('technique_support') }}" class="demina-input">
                </div>

                <div class="demina-field">
                    <label>Dimensiones</label>
                    <input name="dimensions" value="{{ old('dimensions') }}" class="demina-input">
                </div>

                <div class="demina-field">
                    <label>Tiraje</label>
                    <input name="edition" value="{{ old('edition') }}" class="demina-input">
                </div>

                <div class="demina-field">
                    <label>Costo de producción</label>
                    <input type="number" step="0.01" name="production_cost" value="{{ old('production_cost') }}" class="demina-input">
                </div>

                <div class="demina-field">
                    <label>Valor de venta</label>
                    <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" class="demina-input">
                </div>
            </div>

            <div class="mt-5">
                <label>Nota de intención, máximo 100 palabras</label>
                <textarea name="intention_note" rows="5" class="demina-input">{{ old('intention_note') }}</textarea>
            </div>

            <div class="mt-5">
                <label>Semblanza</label>
                <textarea name="bio" rows="5" class="demina-input">{{ old('bio') }}</textarea>
            </div>
        </section>

        <section class="rounded-3xl border border-neutral-800 bg-neutral-900 p-6">
            <h2 class="mb-6 text-2xl font-bold">Fotografías</h2>

            <p class="mb-6 text-sm text-neutral-400">
                Sube mínimo 1 imagen y máximo 3. Formatos permitidos: JPG, JPEG, PNG o WEBP. Peso máximo: 3 MB por archivo. </p>

            @for ($i = 0; $i < 3; $i++)
                <div class="mb-6 rounded-2xl border border-neutral-800 p-5">
                <h3 class="mb-4 font-bold">Fotografía {{ $i + 1 }}</h3>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="demina-field">
                        <label>Título {{ $i === 0 ? '*' : '(opcional)' }}</label>
                        <input
                            name="photo_titles[]"
                            value="{{ old('photo_titles.' . $i) }}"
                            @if($i===0) required @endif
                            class="demina-input">
                    </div>

                    <div class="demina-field">
                        <label>Archivo {{ $i === 0 ? '*' : '(opcional)' }}</label>
                        <input
                            type="file"
                            name="photos[]"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            @if($i===0) required @endif
                            class="demina-input">
                    </div>
                </div>
                </div>
                @endfor
        </section>

        <button
            type="submit"
           class="demina-submit-btn">
            Enviar postulación
        </button>
    </form>
</main>

@endsection