<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Mostrar el formulario de registro.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Manejar la solicitud de registro.
     */
    public function store(Request $request): RedirectResponse
    {
        // 🔐 Verificar si ya existe un usuario con el rol admin
        $adminExists = Role::where('name', 'admin')
            ->first()
            ?->users()
            ->exists();

        if ($adminExists) {
            return redirect()->route('login')->withErrors([
                'correo' => 'Ya existe un usuario administrador. No se permiten más registros públicos.',
            ]);
        }

        // 🛡 Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'required|string|email|max:255|unique:users,correo',
            'password' => 'required|string|min:6',
        ]);

        // 🧠 Crear usuario
        $user = User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'estado' => 'activo',
        ]);

        // ✅ Crear rol 'admin' si no existe
        if (!Role::where('name', 'admin')->exists()) {
            Role::create([
                'name' => 'admin',
                'guard_name' => 'web',
            ]);
        }

        // ✅ Asignar rol 'admin' al primer usuario creado desde el registro
        $user->assignRole('admin');

        // 🔔 Evento y login automático
        event(new Registered($user));
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
