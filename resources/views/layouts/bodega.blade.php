<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Bodega</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


    <style>
        body {
            background-color: #f8fafc;
        }

        .navbar-brand {
            font-size: 1.3rem;
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 0.25rem;
        }

        .btn-logout:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        footer {
            margin-top: 4rem;
            padding: 1rem 0;
            background-color: #e9ecef;
            text-align: center;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <!--NAVBAR SUPERIOR-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('bodega.dashboard') }}">
                <i class="bi bi-shop-window me-2"></i> Panel Bodega
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBodega" aria-controls="navbarBodega" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarBodega">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bodega.dashboard') ? 'active' : '' }}" href="{{ route('bodega.dashboard') }}">
                            <i class="bi bi-house-door-fill"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bodega.productos.*') ? 'active' : '' }}" href="{{ route('bodega.productos.index') }}">
                            <i class="bi bi-box-seam"></i> Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bodega.salidas.*') ? 'active' : '' }}" href="{{ route('bodega.salidas.index') }}">
                            <i class="bi bi-truck"></i> Salidas
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <span class="navbar-text text-white me-3">
                        <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->nombre }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-outline-light btn-sm btn-logout">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="container py-4">
        @yield('content')
    </main>

    {{-- Footer opcional --}}
    <footer class="text-muted">
        &copy; {{ date('Y') }} Sistema de Inventario - Bodega
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
