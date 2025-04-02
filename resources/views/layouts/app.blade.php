<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fuentes (opcional) -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<body>

    @include('layouts.navigation') {{-- Este menú puedes ajustarlo con Bootstrap --}}

    <div class="container mt-4">
        {{-- Encabezado opcional --}}
        @isset($header)
            <div class="alert alert-secondary">
                <h4 class="mb-0">{{ $header }}</h4>
            </div>
        @endisset

        {{-- Contenido principal --}}
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Bootstrap JS desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
{{-- Este es el layout principal de la aplicación. Puedes personalizarlo según tus necesidades. --}}
{{-- Aquí se incluye Bootstrap y se define la estructura básica de la página. --}}
{{-- El contenido de cada vista se inyectará en el slot definido en este layout. --}}
{{-- Puedes agregar más estilos o scripts según lo necesites. --}}
