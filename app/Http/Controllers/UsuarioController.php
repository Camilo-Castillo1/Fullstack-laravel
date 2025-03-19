<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * 📌 Listar todos los usuarios.
     */
    public function index()
    {
        return response()->json(Usuario::all(), 200);
    }

    /**
     * 📌 Crear un nuevo usuario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'password' => 'required|string|min:6',
            'telefono' => 'nullable|string|max:20',
            'id_rol' => 'required|exists:roles,id',
            'estado' => 'required|in:activo,inactivo'
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
            'password' => Hash::make($request->password), // Encriptar contraseña
            'telefono' => $request->telefono,
            'id_rol' => $request->id_rol,
            'estado' => $request->estado,
            'ultimo_acceso' => now()
        ]);

        return response()->json($usuario, 201);
    }

    /**
     * 📌 Obtener un usuario por ID.
     */
    public function show($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario);
    }

    /**
     * 📌 Actualizar un usuario existente.
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'correo' => 'sometimes|email|unique:usuarios,correo,' . $id,
            'password' => 'sometimes|string|min:6',
            'telefono' => 'sometimes|string|max:20',
            'id_rol' => 'sometimes|exists:roles,id',
            'estado' => 'sometimes|in:activo,inactivo'
        ]);

        if ($request->has('password')) {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        $usuario->update($request->all());

        return response()->json($usuario);
    }

    /**
     * 📌 Eliminar un usuario.
     */
    public function destroy($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }
}
