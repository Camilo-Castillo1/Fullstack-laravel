<div id="sidebar" class="sidebar d-flex flex-column p-3 position-fixed">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none fs-4">
        <i class="bi bi-speedometer2 me-2"></i> AdminPanel
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('usuarios.index') }}" class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill me-2"></i> Usuarios
            </a>
        </li>
        <li>
            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-lines-fill me-2"></i> Perfil
            </a>
        </li>
    </ul>
    <hr>
    <div class="mb-3">
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
