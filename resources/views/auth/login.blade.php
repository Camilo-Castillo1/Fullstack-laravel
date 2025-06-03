<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Iniciar sesión - InvenTrack</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #f0f4ff, #e6f0ff);
            color: #333;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-container {
            display: flex;
            flex-direction: row;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            max-width: 960px;
            width: 100%;
        }

        .login-left {
            flex: 1;
            background: #4dabf7;
            color: white;
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .login-left svg {
            width: 100px;
            height: 100px;
            margin-bottom: 1.5rem;
        }

        .login-left h2 {
            font-size: 2rem;
            font-weight: 700;
        }

        .login-left p {
            margin-top: 1rem;
            font-size: 1rem;
            opacity: 0.9;
            text-align: center;
        }

        .login-right {
            flex: 1;
            padding: 3rem 2rem;
            background: #f9fbfd;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-box {
            width: 100%;
            max-width: 400px;
        }

        .form-box h3 {
            margin-bottom: 0.5rem;
            font-size: 1.75rem;
            font-weight: 700;
            color: #4dabf7;
        }

        .form-box p {
            margin-bottom: 2rem;
            font-size: 0.95rem;
            color: #555;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.3rem;
            display: block;
        }

        .form-control {
            width: 100%;
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #ced4da;
            font-size: 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4dabf7;
            box-shadow: 0 0 0 0.25rem rgba(77, 171, 247, 0.25);
            outline: none;
        }

        .btn-login {
            width: 100%;
            background: #4dabf7;
            border: none;
            color: white;
            font-weight: 600;
            padding: 14px;
            border-radius: 10px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background: #339af0;
        }

        .text-links {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .text-links a {
            color: #4dabf7;
            text-decoration: none;
        }

        .text-links a:hover {
            text-decoration: underline;
        }

        .text-danger {
            color: #e03131;
            font-size: 0.85rem;
            margin-top: -0.5rem;
            margin-bottom: 0.75rem;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                border-radius: 12px;
            }

            .login-left,
            .login-right {
                width: 100%;
                padding: 2rem;
            }

            .login-left {
                border-radius: 12px 12px 0 0;
            }

            .login-right {
                border-radius: 0 0 12px 12px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-left">
    <!-- Ícono SVG tipo QUESO -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="100" height="100">
        <path fill="#fff4cc" d="M4 26v24l28 14 28-14V26L32 12z"/>
        <circle cx="20" cy="38" r="4" fill="#f6c453"/>
        <circle cx="36" cy="48" r="3" fill="#f6c453"/>
        <circle cx="44" cy="32" r="2.5" fill="#f6c453"/>
        <path fill="#e0b645" d="M32 12L60 26 32 40 4 26z" opacity="0.3"/>
    </svg>
    <h2>Bienvenido a InvenTrack</h2>
    <p>Controla tu inventario de quesos, lácteos y mucho más con estilo y precisión</p>
</div>

            <div class="login-right">
                <div class="form-box">
                    <h3>Iniciar sesión</h3>
                    <p>Ingresa tus credenciales para acceder a tu cuenta</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <label for="correo" class="form-label">Correo electrónico</label>
                        <input id="correo" type="email" name="correo" value="{{ old('correo') }}" required autofocus class="form-control">
                        @error('correo')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" type="password" name="password" required class="form-control">
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="btn-login">Entrar</button>

                        <div class="text-links">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Registrarse</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
