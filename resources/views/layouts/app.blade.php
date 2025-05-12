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

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
</body>
</html>
