<x-guest-layout>
    <div class="container-fluid max-vh-10000 d-flex justify-content-center align-items-center bg-light">
        <div class="row w-100 shadow-lg rounded overflow-hidden" style="max-width: 90vw; max-height: 600px;">
            <!-- Panel izquierdo -->
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center text-white"
                style="background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%); padding: 40px;">
                <div class="text-center px-4">
                    <img src="https://laravel.com/img/logomark.min.svg" alt="Logo" width="100" class="mb-4">
                    <h2 class="fw-bold">Bienvenido a nuestra plataforma</h2>
                    <p class="mt-3">Conéctate con tu cuenta y comienza a explorar todas las funciones que tenemos para ti.</p>
                </div>
            </div>

            <!-- Panel derecho (login) -->
            <div class="col-md-6 bg-white d-flex align-items-center justify-content-center">
                <div class="w-100 px-4" style="max-width: 500px;"> <!-- Aumenté el max-width del formulario para equilibrar -->
                    <div class="text-center mb-4">
                        <img src="https://laravel.com/img/logomark.min.svg" alt="Logo" width="60">
                        <h4 class="mt-3 fw-bold text-primary">Iniciar sesión</h4>
                    </div>

                    <x-auth-session-status class="mb-3" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Correo -->
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo electrónico</label>
                            <input id="correo" type="email" name="correo" class="form-control" :value="old('correo')" required autofocus>
                            <x-input-error :messages="$errors->get('correo')" class="text-danger mt-1" />
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
                            <x-input-error :messages="$errors->get('password')" class="text-danger mt-1" />
                        </div>

                        <!-- Recordarme -->
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                            <label class="form-check-label" for="remember_me">
                                Recordarme
                            </label>
                        </div>

                        <!-- Botón -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                        </div>

                        <!-- Links -->
                        <div class="d-flex justify-content-between text-muted small">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Regístrate</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
