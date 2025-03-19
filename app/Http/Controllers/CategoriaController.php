<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * 📌 Listar todas las categorías.
     */
    public function index()
    {
        return response()->json(Categoria::all(), 200);
    }

    /**
     * 📌 Crear una nueva categoría.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias',
            'descripcion' => 'nullable|string'
        ]);

        $categoria = Categoria::create($request->all());

        return response()->json($categoria, 201);
    }

    /**
     * 📌 Obtener una categoría por ID.
     */
    public function show($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        return response()->json($categoria);
    }

    /**
     * 📌 Actualizar una categoría existente.
     */
    public function update(Request $request, $id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:255|unique:categorias,nombre,' . $id,
            'descripcion' => 'sometimes|string'
        ]);

        $categoria->update($request->all());

        return response()->json($categoria);
    }

    /**
     * 📌 Eliminar una categoría.
     */
    public function destroy($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        $categoria->delete();

        return response()->json(['message' => 'Categoría eliminada correctamente']);
    }
}
