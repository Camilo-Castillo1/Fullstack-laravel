<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ControlTemperatura;

class ControlTemperaturaController extends Controller
{
    /**
     * 📌 Listar todos los registros de temperatura.
     */
    public function index()
    {
        return response()->json(ControlTemperatura::all(), 200);
    }

    /**
     * 📌 Crear un nuevo registro de temperatura.
     */
    public function store(Request $request)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'temperatura' => 'required|numeric|min:-50|max:100',
        ]);

        $controlTemperatura = ControlTemperatura::create([
            'almacen_id' => $request->almacen_id,
            'temperatura' => $request->temperatura,
            'fecha_registro' => now() // Se establece automáticamente
        ]);

        return response()->json($controlTemperatura, 201);
    }

    /**
     * 📌 Obtener un registro de temperatura por ID.
     */
    public function show($id)
    {
        $controlTemperatura = ControlTemperatura::find($id);

        if (!$controlTemperatura) {
            return response()->json(['error' => 'Registro de temperatura no encontrado'], 404);
        }

        return response()->json($controlTemperatura);
    }

    /**
     * 📌 Actualizar un registro de temperatura existente.
     */
    public function update(Request $request, $id)
    {
        $controlTemperatura = ControlTemperatura::find($id);

        if (!$controlTemperatura) {
            return response()->json(['error' => 'Registro de temperatura no encontrado'], 404);
        }

        $request->validate([
            'almacen_id' => 'sometimes|exists:almacenes,id',
            'temperatura' => 'sometimes|numeric|min:-50|max:100',
        ]);

        $controlTemperatura->update($request->all());

        return response()->json($controlTemperatura);
    }

    /**
     * 📌 Eliminar un registro de temperatura.
     */
    public function destroy($id)
    {
        $controlTemperatura = ControlTemperatura::find($id);

        if (!$controlTemperatura) {
            return response()->json(['error' => 'Registro de temperatura no encontrado'], 404);
        }

        $controlTemperatura->delete();

        return response()->json(['message' => 'Registro de temperatura eliminado correctamente']);
    }
}
