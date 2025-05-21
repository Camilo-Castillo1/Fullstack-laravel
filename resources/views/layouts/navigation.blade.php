<!-- SIDEBAR MEJORADO -->
<div id="sidebar" class="sidebar d-flex flex-column position-fixed bg-dark text-white" style="width: 250px; height: 100vh;">

    <!-- Encabezado -->
    <div class="p-3 border-bottom border-secondary">
        <a href="/" class="d-flex align-items-center mb-0 text-white text-decoration-none fs-5 fw-bold">
            <i class="bi bi-speedometer2 me-2"></i> AdminPanel
        </a>
    </div>

    <!-- Contenido Scrollable -->
  @role('admin')
<div class="flex-grow-1 overflow-auto px-3 py-2">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.usuarios.index') }}" class="nav-link text-white {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill me-2"></i> Usuarios
            </a>
        </li>
        <li>
            <a href="{{ route('profile.edit') }}" class="nav-link text-white {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-lines-fill me-2"></i> Perfil
            </a>
        </li>
        <li>
            <a href="{{ route('admin.roles.index') }}" class="nav-link text-white {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                <i class="bi bi-shield-lock-fill me-2"></i> Roles y Permisos
            </a>
        </li>
        <li>
            <a href="{{ route('admin.almacenes.index') }}" class="nav-link text-white {{ request()->routeIs('admin.almacenes.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam me-2"></i> Almacenes
            </a>
        </li>
        <li>
            <a href="{{ route('admin.categorias.index') }}" class="nav-link text-white {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill me-2"></i> Categorías
            </a>
        </li>
        <li>
            <a href="{{ route('admin.ubicaciones.index') }}" class="nav-link text-white {{ request()->routeIs('admin.ubicaciones.*') ? 'active' : '' }}">
                <i class="bi bi-box2-fill me-2"></i> Ubicaciones
            </a>
        </li>
        <li>
            <a href="{{ route('admin.productos.index') }}" class="nav-link text-white {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam me-2"></i> Productos
            </a>
        </li>
        <li>
            <a href="{{ route('admin.lotes.index') }}" class="nav-link text-white {{ request()->routeIs('admin.lotes.*') ? 'active' : '' }}">
                <i class="bi bi-layers-fill me-2"></i> Lotes
            </a>
        </li>
        <li>
            <a href="{{ route('admin.alertas.index') }}" class="nav-link text-white {{ request()->routeIs('admin.alertas.*') ? 'active' : '' }}">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Alertas Vencimiento
            </a>
        </li>
        <li>
            <a href="{{ route('admin.entradas.index') }}" class="nav-link text-white {{ request()->routeIs('admin.entradas.*') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-in-down me-2"></i> Entradas de Inventario
            </a>
        </li>
        <li>
            <a href="{{ route('admin.salidas.index') }}" class="nav-link text-white {{ request()->routeIs('admin.salidas.*') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-up me-2"></i> Salidas de Inventario
            </a>
        </li>
        <li>
            <a href="{{ route('admin.temperaturas.index') }}" class="nav-link text-white {{ request()->routeIs('admin.temperaturas.*') ? 'active' : '' }}">
                <i class="bi bi-thermometer-half me-2"></i> Control de Temperatura
            </a>
        </li>
        <li>
            <a href="{{ route('admin.politicas.index') }}" class="nav-link text-white {{ request()->routeIs('admin.politicas.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check me-2"></i> Políticas de Inventario
            </a>
        </li>
        <li>
            <a href="{{ route('admin.lote-ubicacion.index') }}" class="nav-link text-white {{ request()->routeIs('admin.lote-ubicacion.*') ? 'active' : '' }}">
                <i class="bi bi-pin-map-fill me-2"></i> Lote por Ubicación
            </a>
        </li>
    </ul>
</div>
@endrole



    <!-- Acciones Fijas Inferiores -->
    <div class="border-top border-secondary p-3 bg-dark">
        <button id="toggleDarkMode" class="btn btn-outline-light w-100 mb-2">
            <i class="bi bi-moon me-2"></i> Modo Oscuro
        </button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-light w-100">
                <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
            </button>
        </form>
    </div>
</div>

<!-- Sidebar Toggle para móviles -->
<button class="btn btn-primary d-lg-none position-fixed top-0 start-0 m-2" id="toggleSidebar">
    <i class="bi bi-list"></i>
</button>

<!-- Estilos responsive y modo oscuro -->
<style>
    @media (max-width: 991px) {
        #sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 2000;
        }
        #sidebar.show {
            transform: translateX(0);
        }
    }

    body.dark-mode {
        background-color: #1e1e2f;
        color: #e2e8f0;
    }

    .dark-mode .sidebar {
        background-color: #0f172a !important;
    }

    .dark-mode .nav-link {
        color: #cbd5e1 !important;
    }

    .dark-mode .nav-link.active {
        background-color: #334155 !important;
        font-weight: 600;
    }

    .dark-mode .nav-link:hover {
        background-color: rgba(255,255,255,0.1) !important;
    }

    .dark-mode .card,
    .dark-mode .table,
    .dark-mode .form-control,
    .dark-mode .form-select,
    .dark-mode .alert {
        background-color: #1e293b !important;
        color: #f8fafc !important;
        border-color: #475569 !important;
    }

    .dark-mode .table thead {
        background-color: #334155;
        color: #f1f5f9;
    }

    .dark-mode .btn-outline-light {
        color: #f8f9fa;
        border-color: #f8f9fa;
    }

    .dark-mode .btn-outline-light:hover {
        background-color: #f8f9fa;
        color: #1e293b;
    }

    .dark-mode input::placeholder,
    .dark-mode select,
    .dark-mode option {
        color: #e2e8f0 !important;
    }

    .dark-mode .text-white {
        color: #f1f5f9 !important;
    }
</style>

<!-- Script toggle -->
<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');

    toggleBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('show');
    });

    // Activar modo oscuro si está guardado
    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark-mode');
    }

    // Toggle manual modo oscuro
    document.getElementById('toggleDarkMode')?.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
    });
</script>
