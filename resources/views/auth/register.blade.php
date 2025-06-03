<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registrarse</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #edf2ff, #f8faff);
            height: 100%;
            overflow: hidden;
        }

        .register-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .register-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.08);
            display: flex;
            overflow: hidden;
            width: 70%;
            max-width: 700px;
        }

        .left-panel {
            background: linear-gradient(135deg, #4dabf7, #74c0fc);
            color: white;
            padding: 2rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .left-panel .icon {
            font-size: 3.2rem;
            background-color: white;
            color: #4dabf7;
            border-radius: 50%;
            padding: 15px;
            margin-bottom: 1rem;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .left-panel h2 {
            font-weight: 700;
            font-size: 1.5rem;
            text-align: center;
        }

        .left-panel p {
            font-size: 0.95rem;
            margin-top: 0.8rem;
            text-align: center;
            line-height: 1.4;
        }

        .right-panel {
            flex: 1;
            background: #f9fbfd;
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-box {
            width: 100%;
            max-width: 320px;
        }

        .form-box h3 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #4dabf7;
            margin-bottom: 0.5rem;
        }

        .form-box p {
            color: #6c757d;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.2rem;
            display: block;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            border-radius: 8px;
            padding: 10px;
            font-size: 0.95rem;
            border: 1px solid #ced4da;
            margin-bottom: 0.9rem;
        }

        .form-control:focus {
            border-color: #4dabf7;
            outline: none;
            box-shadow: 0 0 0 0.15rem rgba(77, 171, 247, 0.2);
        }

        .btn-register {
            width: 100%;
            padding: 11px;
            font-weight: 600;
            font-size: 0.95rem;
            background-color: #4dabf7;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-register:hover {
            background-color: #339af0;
        }

        .text-muted {
            font-size: 0.82rem;
            text-align: center;
            margin-top: 1rem;
        }

        .text-muted a {
            color: #4dabf7;
            text-decoration: none;
            font-weight: 500;
        }

        .text-muted a:hover {
            text-decoration: underline;
        }

        .text-danger {
            color: #e03131;
            font-size: 0.8rem;
            margin-top: -0.4rem;
            margin-bottom: 0.6rem;
        }

        footer {
            margin-top: 2rem;
            font-size: 0.75rem;
            text-align: center;
            color: #6c757d;
        }

        footer a {
            margin: 0 5px;
            color: #4dabf7;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            html, body {
                overflow: auto;
            }

            .register-card {
                flex-direction: column;
                width: 92%;
                height: auto;
            }

            .left-panel, .right-panel {
                width: 100%;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="left-panel">
                <div class="icon">🐄</div>
                <h2>¡Bienvenido a InvenTrack!</h2>
                <p>
                    Tu aliado en el mundo de los productos lácteos.
                    Organiza, controla y optimiza con estilo.
                </p>
            </div>

            <div class="right-panel">
                <div class="form-box">
                    <h3>¡Crea tu cuenta!</h3>


                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <label for="nombre" class="form-label">Nombre</label>
                        <input id="nombre" type="text" name="nombre" value="{{ old('nombre') }}" required class="form-control">
                        @error('nombre') <div class="text-danger">{{ $message }}</div> @enderror

                        <label for="apellido" class="form-label">Apellido</label>
                        <input id="apellido" type="text" name="apellido" value="{{ old('apellido') }}" required class="form-control">
                        @error('apellido') <div class="text-danger">{{ $message }}</div> @enderror

                        <label for="correo" class="form-label">Correo electrónico</label>
                        <input id="correo" type="email" name="correo" value="{{ old('correo') }}" required class="form-control">
                        @error('correo') <div class="text-danger">{{ $message }}</div> @enderror

                        <label for="telefono" class="form-label">Teléfono</label>
                        <input id="telefono" type="text" name="telefono" value="{{ old('telefono') }}" class="form-control">
                        @error('telefono') <div class="text-danger">{{ $message }}</div> @enderror

                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" type="password" name="password" required class="form-control">
                        @error('password') <div class="text-danger">{{ $message }}</div> @enderror

                        <button type="submit" class="btn-register">Registrar</button>

                        <div class="text-muted">
                            ¿Ya tienes cuenta?
                            <a href="{{ route('login') }}">Iniciar sesión</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <footer>
            © {{ date('Y') }} InvenTrack, todos los derechos reservados.
        </footer>
    </div>
</body>
</html>
