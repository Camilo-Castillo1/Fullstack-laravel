<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

/**
* @OA\Info(
*     title="API de Categorías",
*     version="1.0",
*     description="Documentación de la API para el manejo de categorías"
* )
*
* * @OA\Server(
*     url="{{scheme}}://127.0.0.1:8000"
* )

*/

/**
 * @OA\Schema(
 *     schema="Categoria",
 *     type="object",
 *     required={"nombre"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Alimentos"),
 *     @OA\Property(property="descripcion", type="string", example="Productos comestibles"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-25T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-25T12:00:00Z")
 * )
 */
class CategoriaController extends Controller
{
    /**
     * Obtener todas las categorías
     *
     * @OA\Get(
     *     path="/categorias",
     *     tags={"Categorias"},
     *     summary="Lista todas las categorías",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de categorías",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Categoria")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Categoria::all(), 200);
    }

    /**
     * Crear una nueva categoría
     *
     * @OA\Post(
     *     path="/categorias",
     *     tags={"Categorias"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre"},
     *             @OA\Property(property="nombre", type="string", example="Alimentos"),
     *             @OA\Property(property="descripcion", type="string", example="Productos comestibles")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categoría creada",
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos inválidos"
     *     )
     * )
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
     * Mostrar una categoría por ID
     *
     * @OA\Get(
     *     path="/categorias/{id}",
     *     tags={"Categorias"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoría no encontrada"
     *     )
     * )
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
     * Actualizar una categoría existente
     *
     * @OA\Put(
     *     path="/categorias/{id}",
     *     tags={"Categorias"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Bebidas"),
     *             @OA\Property(property="descripcion", type="string", example="Líquidos embotellados")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoría no encontrada"
     *     )
     * )
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
     * Eliminar una categoría
     *
     * @OA\Delete(
     *     path="/categorias/{id}",
     *     tags={"Categorias"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría eliminada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categoría eliminada correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoría no encontrada"
     *     )
     * )
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
