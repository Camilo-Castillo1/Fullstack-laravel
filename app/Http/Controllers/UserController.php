<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Listar todos los usuarios.
     */
    public function index()
    {
        $usuarios = User::with('roles')->get();
        return view('usuarios.usuarios', compact('usuarios'));
    }

    /**
     * Mostrar formulario para crear usuario.
     */
    public function create()
    {
        $roles = Role::all(); // Lista de roles para asignar
        return view('usuarios.create', compact('roles'));
    }

    /**
     * Almacenar usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|unique:users,correo',
            'password' => 'required|string|min:6',
            'roles' => 'required|array'
        ]);

        $usuario = User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'estado' => 'activo'
        ]);

        $usuario->syncRoles($request->roles); // Asignar roles

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(User $usuario)
    {
        $roles = Role::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Actualizar datos de un usuario.
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|unique:users,correo,' . $usuario->id,
            'roles' => 'required|array'
        ]);

        $usuario->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo
        ]);

        if ($request->filled('password')) {
            $usuario->update(['password' => Hash::make($request->password)]);
        }

        $usuario->syncRoles($request->roles);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario.
     */
    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado.');
    }
}
