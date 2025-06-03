<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Bodeguero - @yield('title', 'Inicio')</title>

    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .nav-link {
            transition: all 0.2s ease-in-out;
            padding: 0.5rem 0.9rem;
            border-radius: 2rem;
            color: rgba(255, 255, 255, 0.85);
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.15);
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff !important;
            font-weight: 600;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background: #f1f3f5;
            font-size: 0.9rem;
        }
    </style>

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #198754;">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('bodeguero.dashboard') }}">
                <i class="bi bi-shop fs-5 me-2"></i> Panel Bodega
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBodega">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarBodega">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bodeguero.dashboard') ? 'active' : '' }}" href="{{ route('bodeguero.dashboard') }}">
                            <i class="bi bi-house-door-fill me-2"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bodeguero.productos.*') ? 'active' : '' }}" href="{{ route('bodeguero.productos.index') }}">
                            <i class="bi bi-box-seam me-2"></i> Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bodeguero.entradas.*') ? 'active' : '' }}" href="{{ route('bodeguero.entradas.index') }}">
                            <i class="bi bi-box-arrow-in-down me-2"></i> Entradas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bodeguero.salidas.*') ? 'active' : '' }}" href="{{ route('bodeguero.salidas.index') }}">
                            <i class="bi bi-truck me-2"></i> Salidas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bodeguero.lotes.*') ? 'active' : '' }}" href="{{ route('bodeguero.lotes.index') }}">
                            <i class="bi bi-layers me-2"></i> Lotes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bodeguero.alertas.*') ? 'active' : '' }}" href="{{ route('bodeguero.alertas.index') }}">
                            <i class="bi bi-exclamation-triangle me-2"></i> Alertas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bodeguero.ubicaciones.*') ? 'active' : '' }}" href="{{ route('bodeguero.ubicaciones.index') }}">
                            <i class="bi bi-map me-2"></i> Ubicaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bodeguero.reportes.*') ? 'active' : '' }}" href="{{ route('bodeguero.reportes.create') }}">
                            <i class="bi bi-clipboard-plus me-2"></i> Reportar Novedad
                        </a>
                    </li>

                </ul>

                <div class="d-flex align-items-center gap-3">
                    <span class="text-white fw-semibold d-flex align-items-center">
                        <i class="bi bi-person-circle me-2"></i> {{ Auth::user()->nombre }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-light btn-sm d-flex align-items-center">
                            <i class="bi bi-box-arrow-left me-1"></i> Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- CONTENIDO --}}
    <main class="container py-4 flex-grow-1">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer>
        &copy; {{ date('Y') }} Sistema de Inventario | Todos los derechos reservados.
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.6.2/dist/countUp.umd.js"></script>
    @stack('scripts')
</body>
</html>
