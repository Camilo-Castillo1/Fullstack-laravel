<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>LaCrem - Inventario Lácteo Inteligente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #2b2d42;
            scroll-behavior: smooth;
        }

        .navbar {
            background-color: #fff;
            padding: 1.25rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-weight: 700;
            color: #4dabf7;
            font-size: 1.6rem;
        }

        .nav-link {
            color: #2b2d42;
            font-weight: 500;
            margin-left: 1rem;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: #4dabf7;
        }

        .btn-custom {
            background: linear-gradient(to right, #4dabf7, #3a8be0);
            color: white;
            border: none;
            padding: 10px 22px;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.3s ease-in-out;
        }

        .btn-custom:hover {
            background: linear-gradient(to right, #339af0, #2684ef);
            transform: scale(1.03);
        }

        .hero {
            padding: 100px 0 60px;
            background: linear-gradient(to right, #e8f3ff, #f2faff);
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            color: #212529;
        }

        .hero p {
            font-size: 1.15rem;
            color: #495057;
        }

        .hero .btn {
            margin-top: 20px;
            margin-right: 10px;
        }

        .hero-img {
            max-width: 100%;
            height: auto;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .contact-section {
            background: #f9fcff;
            padding: 100px 0 80px;
        }

        .contact-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            padding: 40px;
            transition: transform 0.2s ease-in-out;
        }

        .contact-card:hover {
            transform: translateY(-6px);
        }

        .contact-card img {
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .form-control {
            border-radius: 10px;
        }

        .form-control:focus {
            border-color: #4dabf7;
            box-shadow: 0 0 0 0.25rem rgba(77, 171, 247, 0.2);
        }

        footer {
            background: #f1f3f7;
            text-align: center;
            padding: 24px 0;
            font-size: 0.9rem;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
        }

        footer a {
            color: #4dabf7;
            margin: 0 10px;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">InvenTrack</a>
        <div class="ms-auto">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-link">Panel</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Iniciar sesión</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-custom ms-2">Crear cuenta</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center text-lg-start">
                <h1>Gestiona tu inventario lácteo con frescura y precisión</h1>
                <p class="mt-3">Distribuye, organiza y controla tu stock de productos lácteos desde una plataforma sencilla y poderosa.</p>
                <a href="{{ route('register') }}" class="btn btn-custom">Empieza ahora</a>
                <a href="#contacto" class="btn btn-outline-primary">Contáctanos</a>
            </div>
            <div class="col-lg-6 mt-4 mt-lg-0 text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/4743/4743031.png" alt="Ilustración sistema" class="hero-img" width="360">
            </div>
        </div>
    </div>
</section>

<!-- CONTACTO + TARJETAS -->
<section class="contact-section" id="contacto">
    <div class="container">
        <div class="row justify-content-center mb-5 text-center">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3">¿Tienes dudas o deseas contactarnos?</h2>
                <p class="text-muted">Estamos aquí para ayudarte. Escríbenos directamente o comunícate con nuestro equipo.</p>
            </div>
        </div>

        <!-- Tarjetas de presentación -->
        <div class="row g-4 justify-content-center mb-5">
            <div class="col-sm-6 col-lg-4">
                <div class="contact-card text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/2922/2922561.png" width="80" class="mb-3" alt="Soporte">
                    <h5 class="fw-bold">Soporte Técnico</h5>
                    <p class="small text-muted">¿Problemas con la plataforma? Nuestro equipo está listo para ayudarte.</p>
                    <p class="mb-1"><strong>Email:</strong> LeoRoa@gmail.com</p>
                    <p><strong>Teléfono:</strong> +57 300 123 4567</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="contact-card text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140037.png" width="80" class="mb-3" alt="Ventas">
                    <h5 class="fw-bold">Ventas & Comercial</h5>
                    <p class="small text-muted">¿Deseas implementar InvenTrack en tu empresa? Escríbenos y agenda una demo.</p>
                    <p class="mb-1"><strong>Email:</strong> sebastian-castillo128291@gmail.com</p>
                    <p><strong>WhatsApp:</strong> +57 301 987 6543</p>
                </div>
            </div>
        </div>

        <!-- Formulario de contacto -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="contact-card">
                    <form method="POST" action="#">
                        <div class="mb-3">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mensaje</label>
                            <textarea class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-custom">Enviar mensaje</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    © {{ date('Y') }} LaCrem. Todos los derechos reservados.
    <a href="#">Política de privacidad</a> |
    <a href="#">Términos</a> |
    <a href="#">Soporte</a>
</footer>

</body>
</html>
