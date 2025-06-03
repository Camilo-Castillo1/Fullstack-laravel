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

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar {
            height: 100vh;
            background-color: #1e3a8a;
            color: white;
            width: 250px;
            transition: width 0.3s ease;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar a {
            color: white;
        }

        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 0.375rem;
        }

        .content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        .content.collapsed {
            margin-left: 80px;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        }

        .card, .bg-body {
            background-color: #ffffff !important;
            color: #1e293b !important;
        }

        .table thead, .table td, .table th {
            color: #1e293b;
        }

        .form-check-label {
            color: #1e293b;
        }

        .form-control {
            background-color: #ffffff;
            color: #1e293b;
            border-color: #cbd5e1;
        }

        .alert {
            background-color: #e2e8f0;
            color: #1e293b;
            border: none;
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    @include('layouts.navigation')

    {{-- Contenido dinámico --}}
    <div class="content" id="mainContent">
        <main class="p-4">
            @hasSection('header')
                <h4 class="mb-4">@yield('header')</h4>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
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

    @stack('scripts')
</body>
</html>
