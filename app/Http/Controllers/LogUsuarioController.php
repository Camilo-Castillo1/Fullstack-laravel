<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogUsuario;

class LogUsuarioController extends Controller
{
    /**
     * 📌 Listar todos los logs de usuarios.
     */
    public function index()
    {
        return response()->json(LogUsuario::all(), 200);
    }

    /**
     * 📌 Crear un nuevo registro de log (se suele hacer automáticamente).
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id',
            'tipo_evento' => 'required|in:INSERT,UPDATE,DELETE',
            'campo_modificado' => 'nullable|string|max:50',
            'valor_anterior' => 'nullable|string',
            'valor_nuevo' => 'nullable|string',
            'usuario_modifico' => 'nullable|exists:usuarios,id'
        ]);

        $log = LogUsuario::create([
            'id_usuario' => $request->id_usuario,
            'tipo_evento' => $request->tipo_evento,
            'campo_modificado' => $request->campo_modificado,
            'valor_anterior' => $request->valor_anterior,
            'valor_nuevo' => $request->valor_nuevo,
            'usuario_modifico' => $request->usuario_modifico,
            'fecha_evento' => now() // Se establece automáticamente
        ]);

        return response()->json($log, 201);
    }

    /**
     * 📌 Obtener un log por ID.
     */
    public function show($id)
    {
        $log = LogUsuario::find($id);

        if (!$log) {
            return response()->json(['error' => 'Registro de log no encontrado'], 404);
        }

        return response()->json($log);
    }

    /**
     * 📌 No es recomendable actualizar logs, por lo que este método se omite.
     */
    public function update(Request $request, $id)
    {
        return response()->json(['error' => 'No se permite actualizar registros de log'], 403);
    }

    /**
     * 📌 No es recomendable eliminar logs, pero se puede implementar una política de eliminación.
     */
    public function destroy($id)
    {
        return response()->json(['error' => 'No se permite eliminar registros de log'], 403);
    }
}
