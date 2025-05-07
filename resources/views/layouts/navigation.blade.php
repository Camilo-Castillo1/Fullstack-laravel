<!-- Estilos Bootstrap y Bi -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- SIDEBAR LATERAL OCULTO -->
<div id="sidebarMenu" class="position-fixed top-0 start-0 bg-white border-end shadow" style="width: 250px; height: 100vh; display: none; z-index: 1050; padding-top: 4.5rem;">
    <ul class="nav flex-column px-3">
        <li class="nav-item mb-2">
            <a class="nav-link text-success fw-semibold" href="#"><i class="bi bi-search me-2"></i>Buscar Datos</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-primary fw-semibold" href="#"><i class="bi bi-clock-history me-2"></i>Acceso 24/7</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-danger fw-semibold" href="#"><i class="bi bi-printer me-2"></i>Impresión Rápida</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link text-info fw-semibold" href="#"><i class="bi bi-shield-lock me-2"></i>Seguridad</a>
        </li>
    </ul>
</div>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-3 fixed-top">
    <div class="container">
        <!-- Botón de menú lateral -->
        <button id="toggleSidebar" class="btn btn-outline-success me-2 d-lg-none" type="button">
            <i class="bi bi-list fs-4"></i>
        </button>

        <a class="navbar-brand d-flex align-items-center fw-bold text-success" href="{{ route('dashboard') }}">
            <img src="https://img.icons8.com/color/48/administrator-male.png" alt="Logo Admin" height="30" class="me-2">
            AdminPanel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold text-success' : 'text-muted' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('usuarios.*') ? 'active fw-bold text-success' : 'text-muted' }}" href="{{ route('usuarios.index') }}">Usuarios</a>
                    </li>
                @endauth

                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark fw-semibold" href="#" data-bs-toggle="dropdown">
                            {{ Auth::user()->nombre }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end rounded-4">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Cerrar sesión</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-success rounded-pill" href="{{ route('login') }}">Iniciar sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-success text-white rounded-pill" href="{{ route('register') }}">Regístrate</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- HERO -->
<header class="text-white text-center py-5 mt-5" style="background: linear-gradient(135deg, #d2f4ea, #c1e0f7);">
    <div class="container">
        <h1 class="display-5 fw-bold text-success">Bienvenido al Panel Administrativo</h1>
        <p class="lead text-dark">Gestiona usuarios, visualiza datos y controla operaciones desde un solo lugar.</p>
        <img src="https://undraw.co/api/illustrations/7a2dd762-2d8f-47c2-a241-b3c181bedbd3" alt="Administrador" class="img-fluid mt-3" style="max-height: 280px;">
    </div>
</header>

<!-- TARJETAS OVALADAS -->
<section class="py-5" style="background-color: #f8fdfd;">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="p-4 shadow-sm rounded-pill bg-white border border-success-subtle">
                    <i class="bi bi-people-fill fs-2 text-success"></i>
                    <h5 class="mt-2">Usuarios activos</h5>
                    <p class="text-muted small mb-0">Consulta el total de usuarios registrados y activos en el sistema.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 shadow-sm rounded-pill bg-white border border-primary-subtle">
                    <i class="bi bi-bar-chart-line-fill fs-2 text-primary"></i>
                    <h5 class="mt-2">Estadísticas</h5>
                    <p class="text-muted small mb-0">Visualiza el rendimiento y los indicadores clave de tu organización.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 shadow-sm rounded-pill bg-white border border-info-subtle">
                    <i class="bi bi-gear-fill fs-2 text-info"></i>
                    <h5 class="mt-2">Configuraciones</h5>
                    <p class="text-muted small mb-0">Administra las opciones generales y de seguridad del sistema.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TARJETAS INFERIORES PASTEL MODERNAS -->
<section class="py-5" style="background-color: #ffffff;">
    <div class="container">
        <div class="row g-5">
            <div class="col-md-6">
                <div class="rounded-4 p-4 h-100 shadow-sm" style="background-color: #e8fdf5;">
                    <div class="d-flex align-items-start">
                        <img src="https://cdn-icons-png.flaticon.com/512/833/833593.png" width="64" class="me-3" alt="Buscar">
                        <div>
                            <h5 class="fw-bold text-dark">Buscar datos</h5>
                            <p class="text-muted">Nuestro motor de búsqueda facilita encontrar información en grandes volúmenes de datos.</p>
                            <a href="#" class="text-decoration-none text-success">Leer más →</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="rounded-4 p-4 h-100 shadow-sm" style="background-color: #f5ecfd;">
                    <div class="d-flex align-items-start">
                        <img src="https://cdn-icons-png.flaticon.com/512/3064/3064197.png" width="64" class="me-3" alt="24 horas">
                        <div>
                            <h5 class="fw-bold text-dark">Acceso 24/7</h5>
                            <p class="text-muted">Accede a tu información desde cualquier dispositivo y a cualquier hora.</p>
                            <a href="#" class="text-decoration-none text-primary">Leer más →</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="rounded-4 p-4 h-100 shadow-sm" style="background-color: #fdeef1;">
                    <div class="d-flex align-items-start">
                        <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" width="64" class="me-3" alt="Imprimir">
                        <div>
                            <h5 class="fw-bold text-dark">Impresión rápida</h5>
                            <p class="text-muted">Genera e imprime reportes de forma eficiente y con diseño profesional.</p>
                            <a href="#" class="text-decoration-none text-danger">Leer más →</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="rounded-4 p-4 h-100 shadow-sm" style="background-color: #e3f4fd;">
                    <div class="d-flex align-items-start">
                        <img src="https://cdn-icons-png.flaticon.com/512/565/565547.png" width="64" class="me-3" alt="Seguridad">
                        <div>
                            <h5 class="fw-bold text-dark">Seguridad avanzada</h5>
                            <p class="text-muted">Tus datos están protegidos mediante cifrado y múltiples capas de autenticación.</p>
                            <a href="#" class="text-decoration-none text-info">Leer más →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JS Bootstrap y Sidebar toggle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebarMenu');

        toggleBtn.addEventListener('click', () => {
            sidebar.style.display = (sidebar.style.display === 'block') ? 'none' : 'block';
        });
    });
</script>
<script>
    // Cerrar el sidebar al hacer clic fuera de él
    document.addEventListener('click', function (event) {
        const sidebar = document.getElementById('sidebarMenu');
        const toggleBtn = document.getElementById('toggleSidebar');

        if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
            sidebar.style.display = 'none';
        }
    });
</script>
<script>
    // Cerrar el sidebar al hacer clic en un enlace
    const sidebarLinks = document.querySelectorAll('#sidebarMenu .nav-link');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', () => {
            document.getElementById('sidebarMenu').style.display = 'none';
        });
    });
</script>
<script>
    // Mostrar el sidebar al cargar la página si es necesario
    window.addEventListener('load', function () {
        const sidebar = document.getElementById('sidebarMenu');
        if (window.innerWidth >= 992) {
            sidebar.style.display = 'block';
        }
    });
    // Ajustar el sidebar al redimensionar la ventana
