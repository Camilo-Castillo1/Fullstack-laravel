<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Animate.css (opcional para animaciones suaves) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }
        .sidebar {
            height: 100vh;
            background-color: #1e3a8a;
            color: white;
            transition: width 0.3s ease;
            width: 250px;
        }
        .sidebar.collapsed {
            width: 80px;
        }
        .sidebar a {
            color: white;
        }
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.15);
            border-radius: 0.375rem;
        }
        .content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }
        .content.collapsed {
            margin-left: 80px;
        }
        .dark-mode {
            background-color: #1e293b;
            color: #e2e8f0;
        }
        .dark-mode .sidebar {
            background-color: #0f172a;
        }
        .dark-mode .bg-white {
            background-color: #1e293b !important;
        }
    </style>
</head>
<body id="body">

    {{-- Sidebar --}}
    @include('layouts.navigation')

    {{-- Contenido dinámico --}}
    <div class="content" id="mainContent">
        <main class="p-4">
            {{-- Si hay encabezado --}}
            @hasSection('header')
                <h4 class="mb-4 text-white">@yield('header')</h4>
            @endif

            {{-- Contenido de la vista --}}
            @yield('content')
        </main>
    </div>

    <!-- jQuery primero -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    {{-- Scripts para dark mode y sidebar --}}
    <script>
        // Modo oscuro persistente
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }

        document.getElementById('toggleDarkMode')?.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
        });

        // Sidebar colapsable
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('mainContent');

        if (localStorage.getItem('sidebar') === 'collapsed') {
            sidebar?.classList.add('collapsed');
            content?.classList.add('collapsed');
        }

        document.getElementById('toggleSidebar')?.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');
            localStorage.setItem('sidebar', sidebar.classList.contains('collapsed') ? 'collapsed' : 'expanded');
        });
    </script>

    {{-- Sección de scripts adicionales desde las vistas --}}
    @stack('scripts')
</body>
</html>
