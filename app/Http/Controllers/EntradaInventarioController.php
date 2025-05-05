<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EntradaInventario;


/**
 * @OA\Schema(
 *     schema="EntradaInventario",
 *     type="object",
 *     required={"lote_id", "usuario_id", "cantidad", "motivo"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="lote_id", type="integer", example=3),
 *     @OA\Property(property="usuario_id", type="integer", example=5),
 *     @OA\Property(property="cantidad", type="integer", example=50),
 *     @OA\Property(property="motivo", type="string", example="Reposición de stock"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-25T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-25T12:30:00Z")
 * )
 */
class EntradaInventarioController extends Controller
{
    /**
     * Listar todas las entradas de inventario
     *
     * @OA\Get(
     *     path="/entradas-inventario",
     *     tags={"EntradaInventario"},
     *     summary="Listar todas las entradas",
     *     @OA\Response(
     *         response=200,
     *         description="Listado de entradas",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/EntradaInventario"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(EntradaInventario::all(), 200);
    }

    /**
     * Registrar una nueva entrada de inventario
     *
     * @OA\Post(
     *     path="/entradas-inventario",
     *     tags={"EntradaInventario"},
     *     summary="Crear una nueva entrada de inventario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"lote_id", "usuario_id", "cantidad", "motivo"},
     *             @OA\Property(property="lote_id", type="integer", example=3),
     *             @OA\Property(property="usuario_id", type="integer", example=5),
     *             @OA\Property(property="cantidad", type="integer", example=50),
     *             @OA\Property(property="motivo", type="string", example="Reposición de stock")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Entrada registrada",
     *         @OA\JsonContent(ref="#/components/schemas/EntradaInventario")
     *     ),
     *     @OA\Response(response=422, description="Datos inválidos")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'usuario_id' => 'required|exists:usuarios,id',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'required|string|max:255',
        ]);

        $entrada = EntradaInventario::create($request->all());

        return response()->json($entrada, 201);
    }

    /**
     * Ver una entrada por ID
     *
     * @OA\Get(
     *     path="/entradas-inventario/{id}",
     *     tags={"EntradaInventario"},
     *     summary="Obtener entrada específica",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Entrada encontrada", @OA\JsonContent(ref="#/components/schemas/EntradaInventario")),
     *     @OA\Response(response=404, description="Entrada no encontrada")
     * )
     */
    public function show($id)
    {
        $entrada = EntradaInventario::find($id);

        if (!$entrada) {
            return response()->json(['error' => 'Entrada no encontrada'], 404);
        }

        return response()->json($entrada);
    }

    /**
     * Actualizar una entrada de inventario
     *
     * @OA\Put(
     *     path="/entradas-inventario/{id}",
     *     tags={"EntradaInventario"},
     *     summary="Actualizar entrada",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="cantidad", type="integer", example=80),
     *             @OA\Property(property="motivo", type="string", example="Ajuste de inventario")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Entrada actualizada", @OA\JsonContent(ref="#/components/schemas/EntradaInventario")),
     *     @OA\Response(response=404, description="Entrada no encontrada")
     * )
     */
    public function update(Request $request, $id)
    {
        $entrada = EntradaInventario::find($id);

        if (!$entrada) {
            return response()->json(['error' => 'Entrada no encontrada'], 404);
        }

        $request->validate([
            'cantidad' => 'sometimes|integer|min:1',
            'motivo' => 'sometimes|string|max:255',
        ]);

        $entrada->update($request->all());

        return response()->json($entrada);
    }

    /**
     * Eliminar una entrada
     *
     * @OA\Delete(
     *     path="/entradas-inventario/{id}",
     *     tags={"EntradaInventario"},
     *     summary="Eliminar entrada",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Entrada eliminada",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Entrada eliminada correctamente"))
     *     ),
     *     @OA\Response(response=404, description="Entrada no encontrada")
     * )
     */
    public function destroy($id)
    {
        $entrada = EntradaInventario::find($id);

        if (!$entrada) {
            return response()->json(['error' => 'Entrada no encontrada'], 404);
        }

        $entrada->delete();

        return response()->json(['message' => 'Entrada eliminada correctamente']);
    }
}
