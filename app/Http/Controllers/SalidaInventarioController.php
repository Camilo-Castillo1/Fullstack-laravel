<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalidaInventario;

/**
* @OA\Info(
*     title="API de Salidas de Inventario",
*     version="1.0",
*     description="Gestión de movimientos de salida de inventario"
* )
*
* @OA\Server(url="http://127.0.0.1:8000")
*/

/**
 * @OA\Schema(
 *     schema="SalidaInventario",
 *     type="object",
 *     required={"lote_id", "usuario_id", "cantidad"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="lote_id", type="integer", example=3),
 *     @OA\Property(property="usuario_id", type="integer", example=5),
 *     @OA\Property(property="cantidad", type="integer", example=10),
 *     @OA\Property(property="motivo", type="string", example="Consumo interno"),
 *     @OA\Property(property="fecha_movimiento", type="string", format="date-time", example="2024-04-01T10:30:00Z"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class SalidaInventarioController extends Controller
{
    /**
     * Listar todas las salidas de inventario
     *
     * @OA\Get(
     *     path="/api/salidas-inventario",
     *     tags={"SalidasInventario"},
     *     summary="Listar salidas de inventario",
     *     @OA\Response(
     *         response=200,
     *         description="Listado de salidas",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/SalidaInventario"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(SalidaInventario::all(), 200);
    }

    /**
     * Registrar una nueva salida de inventario
     *
     * @OA\Post(
     *     path="/api/salidas-inventario",
     *     tags={"SalidasInventario"},
     *     summary="Registrar salida de inventario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"lote_id", "usuario_id", "cantidad"},
     *             @OA\Property(property="lote_id", type="integer", example=1),
     *             @OA\Property(property="usuario_id", type="integer", example=4),
     *             @OA\Property(property="cantidad", type="integer", example=15),
     *             @OA\Property(property="motivo", type="string", example="Daño en productos")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Salida registrada", @OA\JsonContent(ref="#/components/schemas/SalidaInventario")),
     *     @OA\Response(response=422, description="Datos inválidos")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'usuario_id' => 'required|exists:usuarios,id',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'nullable|string'
        ]);

        $salida = SalidaInventario::create([
            'lote_id' => $request->lote_id,
            'usuario_id' => $request->usuario_id,
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo,
            'fecha_movimiento' => now()
        ]);

        return response()->json($salida, 201);
    }

    /**
     * Obtener una salida por ID
     *
     * @OA\Get(
     *     path="/api/salidas-inventario/{id}",
     *     tags={"SalidasInventario"},
     *     summary="Consultar salida por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Salida encontrada", @OA\JsonContent(ref="#/components/schemas/SalidaInventario")),
     *     @OA\Response(response=404, description="Salida no encontrada")
     * )
     */
    public function show($id)
    {
        $salida = SalidaInventario::find($id);

        if (!$salida) {
            return response()->json(['error' => 'Salida de inventario no encontrada'], 404);
        }

        return response()->json($salida);
    }

    /**
     * Actualizar una salida existente
     *
     * @OA\Put(
     *     path="/api/salidas-inventario/{id}",
     *     tags={"SalidasInventario"},
     *     summary="Actualizar salida de inventario",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="cantidad", type="integer", example=20),
     *             @OA\Property(property="motivo", type="string", example="Ajuste de inventario")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Salida actualizada", @OA\JsonContent(ref="#/components/schemas/SalidaInventario")),
     *     @OA\Response(response=404, description="Salida no encontrada")
     * )
     */
    public function update(Request $request, $id)
    {
        $salida = SalidaInventario::find($id);

        if (!$salida) {
            return response()->json(['error' => 'Salida de inventario no encontrada'], 404);
        }

        $request->validate([
            'lote_id' => 'sometimes|exists:lotes,id',
            'usuario_id' => 'sometimes|exists:usuarios,id',
            'cantidad' => 'sometimes|integer|min:1',
            'motivo' => 'sometimes|string'
        ]);

        $salida->update($request->all());

        return response()->json($salida);
    }

    /**
     * Eliminar una salida de inventario
     *
     * @OA\Delete(
     *     path="/api/salidas-inventario/{id}",
     *     tags={"SalidasInventario"},
     *     summary="Eliminar salida de inventario",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Salida eliminada",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Salida de inventario eliminada correctamente"))
     *     ),
     *     @OA\Response(response=404, description="Salida no encontrada")
     * )
     */
    public function destroy($id)
    {
        $salida = SalidaInventario::find($id);

        if (!$salida) {
            return response()->json(['error' => 'Salida de inventario no encontrada'], 404);
        }

        $salida->delete();

        return response()->json(['message' => 'Salida de inventario eliminada correctamente']);
    }
}
