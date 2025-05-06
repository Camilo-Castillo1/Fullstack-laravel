<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #f6f0ff, #f0f7ff);
            font-family: 'Quicksand', sans-serif;
        }
        .login-wrapper {
            min-height: 100vh;
        }
        .login-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            border-color: #667eea;
        }
        .brand-logo {
            width: 70px;
        }
    </style>
</head>
<body>
    <div class="container-fluid login-wrapper d-flex justify-content-center align-items-center">
        <div class="card login-card p-4" style="width: 100%; max-width: 1120px; height: 650px;">
            <div class="text-center mb-3">
                <img src="https://laravel.com/img/logomark.min.svg" class="brand-logo" alt="Logo">
                <h4 class="mt-2 fw-bold text-primary">Bienvenido de nuevo</h4>
            </div>

            {{ $slot }}

            <div class="text-center mt-3">
                <small class="text-muted">© {{ now()->year }} Todos los derechos reservados.</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
