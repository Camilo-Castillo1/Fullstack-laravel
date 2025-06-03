<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>LaCrem - Productos Lácteos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #0d1117;
            color: #ffffff;
            font-family: 'Segoe UI', sans-serif;
        }
        .hero-section {
            background: linear-gradient(to bottom right, #173b44, #1e2026);
            border-radius: 15px;
            padding: 40px;
            margin-top: 40px;
        }
        .feature-card {
            background-color: #161b22;
            border: 1px solid #30363d;
            border-radius: 12px;
            padding: 25px;
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            border-color: #58a6ff;
            transform: translateY(-3px);
        }
        .feature-icon {
            font-size: 40px;
            color: #58a6ff;
        }
        .top-bar {
            background: transparent;
            padding: 15px 30px;
        }
        .top-bar a {
            color: #c9d1d9;
            margin-left: 20px;
            text-decoration: none;
        }
        .top-bar a:hover {
            color: #ffffff;
        }
    </style>
</head>
<body>

    {{-- Barra superior --}}
    <div class="top-bar d-flex justify-content-end">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        @endif
    </div>

    {{-- Hero principal --}}
    <div class="container">
        <div class="hero-section text-center text-light shadow-lg">
            <h1 class="display-4">LaCrem</h1>
            <p class="lead mt-3">Especialistas en productos lácteos frescos, saludables y sostenibles.</p>
        </div>

        {{-- Sección de características --}}
        <div class="row text-center mt-5 g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon mb-3">🥛</div>
                    <h5>Leche fresca</h5>
                    <p>Distribución diaria de leche pasteurizada de alta calidad.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon mb-3">🧀</div>
                    <h5>Quesos artesanales</h5>
                    <p>Variedad de quesos elaborados con técnicas tradicionales.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon mb-3">🥣</div>
                    <h5>Yogures naturales</h5>
                    <p>Yogur sin azúcar añadido, ideal para el consumo diario.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon mb-3">🚚</div>
                    <h5>Entrega directa</h5>
                    <p>Logística refrigerada para que el producto llegue en perfecto estado.</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
