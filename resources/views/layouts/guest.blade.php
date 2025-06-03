<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2; /* A complementary purple */
            --light-gray: #f8f9fa;
            --dark-gray: #343a40;
            --card-bg: #ffffff;
            --shadow: rgba(0, 0, 0, 0.08);
            --border-radius: 12px;
        }

        body {
            background: linear-gradient(135deg, #f6f0ff, #e0eaff); /* Softer, more modern gradient */
            font-family: 'Lato', sans-serif;
            color: var(--dark-gray);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden; /* Hide scrollbar if content doesn't fit perfectly */
        }

        .login-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px; /* Add some padding for smaller screens */
            box-sizing: border-box; /* Include padding in element's total width and height */
        }

        .login-card {
            background-color: var(--card-bg);
            border: none;
            border-radius: var(--border-radius);
            box-shadow: 0 15px 45px var(--shadow); /* More pronounced, professional shadow */
            width: 100%;
            max-width: 900px; /* Slightly adjusted max-width for better balance */
            min-height: 580px; /* Maintain a good minimum height */
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Distribute space for content */
            padding: 40px; /* Increased padding inside the card */
            transform: translateY(0);
            opacity: 1;
            transition: transform 0.6s ease-out, opacity 0.6s ease-out; /* Smooth entrance animation */
        }

        @media (max-width: 768px) {
            .login-card {
                padding: 30px;
                min-height: auto; /* Allow height to adjust on smaller screens */
            }
        }

        .card-header-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-logo {
            width: 80px; /* Slightly larger logo */
            margin-bottom: 15px;
            transition: transform 0.3s ease; /* Subtle hover effect */
        }
        .brand-logo:hover {
            transform: scale(1.05);
        }

        .welcome-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700; /* Bolder for impact */
            color: var(--primary-color);
            margin-top: 10px;
            font-size: 1.8rem; /* Larger font size */
        }

        .form-control {
            border-radius: 8px; /* Slightly softer corners for input fields */
            padding: 12px 15px; /* More padding for better feel */
            border: 1px solid #e0e6ed;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            border-color: var(--primary-color);
            background-color: #fafffe; /* Slight background change on focus */
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 8px;
            padding: 12px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.2);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color); /* Change color on hover */
            border-color: var(--secondary-color);
            transform: translateY(-2px); /* Lift button on hover */
            box-shadow: 0 6px 15px rgba(118, 75, 162, 0.3);
        }

        .text-muted-footer {
            color: #9da3ae !important; /* Slightly darker muted text for better contrast */
            font-size: 0.85rem;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container-fluid login-wrapper">
        <div class="card login-card">
            <div class="card-header-section">
                <img src="https://laravel.com/img/logomark.min.svg" class="brand-logo" alt="Logo">
                <h4 class="welcome-title">Bienvenido de nuevo</h4>
                <p class="text-muted mt-2">Inicia sesión para continuar.</p>
            </div>

            {{ $slot }}

            <div class="text-center text-muted-footer">
                <small>© {{ now()->year }} Todos los derechos reservados. | Desarrollado con ❤️</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
