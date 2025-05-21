<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesa el login usando el campo 'correo'.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Autenticar con el campo 'correo'
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // Redireccionar según el rol del usuario
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('administrador de bodega')) {
            return redirect()->route('bodega.dashboard');
        } elseif ($user->hasRole('bodeguero')) {
            return redirect()->route('bodeguero.productos.index');
        }

        // Si no tiene ningún rol esperado, redirigir al home
        return redirect('/');
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
