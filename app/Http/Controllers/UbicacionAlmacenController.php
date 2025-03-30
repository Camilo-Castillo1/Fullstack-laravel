<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UbicacionAlmacen;

/**
* @OA\Info(
*     title="API de Ubicaciones en Almacenes",
*     version="1.0",
*     description="Gestión de ubicaciones físicas dentro de almacenes"
* )
*
* @OA\Server(url="http://127.0.0.1:8000")
*/

/**
 * @OA\Schema(
 *     schema="UbicacionAlmacen",
 *     type="object",
 *     required={"almacen_id", "codigo_ubicacion", "tipo_almacenamiento", "capacidad_maxima"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="almacen_id", type="integer", example=3),
 *     @OA\Property(property="codigo_ubicacion", type="string", example="A1-R1"),
 *     @OA\Property(property="tipo_almacenamiento", type="string", enum={"refrigerado", "congelado", "seco"}, example="seco"),
 *     @OA\Property(property="capacidad_maxima", type="integer", example=200),
 *     @OA\Property(property="restricciones", type="string", example="Evitar productos inflamables"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class UbicacionAlmacenController extends Controller
{
    /**
     * Listar todas las ubicaciones
     *
     * @OA\Get(
     *     path="/api/ubicaciones-almacen",
     *     tags={"UbicacionesAlmacen"},
     *     summary="Obtener todas las ubicaciones de los almacenes",
     *     @OA\Response(
     *         response=200,
     *         description="Listado completo",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/UbicacionAlmacen"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(UbicacionAlmacen::all(), 200);
    }

    /**
     * Registrar una nueva ubicación
     *
     * @OA\Post(
     *     path="/api/ubicaciones-almacen",
     *     tags={"UbicacionesAlmacen"},
     *     summary="Registrar una ubicación dentro de un almacén",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"almacen_id", "codigo_ubicacion", "tipo_almacenamiento", "capacidad_maxima"},
     *             @OA\Property(property="almacen_id", type="integer", example=1),
     *             @OA\Property(property="codigo_ubicacion", type="string", example="RACK-02-A"),
     *             @OA\Property(property="tipo_almacenamiento", type="string", enum={"refrigerado", "congelado", "seco"}, example="refrigerado"),
     *             @OA\Property(property="capacidad_maxima", type="integer", example=100),
     *             @OA\Property(property="restricciones", type="string", example="Evitar exposición directa al sol")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Ubicación registrada", @OA\JsonContent(ref="#/components/schemas/UbicacionAlmacen")),
     *     @OA\Response(response=422, description="Datos inválidos")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'codigo_ubicacion' => 'required|string|max:50|unique:ubicaciones_almacenamiento',
            'tipo_almacenamiento' => 'required|in:refrigerado,congelado,seco',
            'capacidad_maxima' => 'required|integer|min:1',
            'restricciones' => 'nullable|string'
        ]);

        $ubicacion = UbicacionAlmacen::create($request->all());

        return response()->json($ubicacion, 201);
    }

    /**
     * Consultar una ubicación por ID
     *
     * @OA\Get(
     *     path="/api/ubicaciones-almacen/{id}",
     *     tags={"UbicacionesAlmacen"},
     *     summary="Obtener una ubicación específica",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Ubicación encontrada", @OA\JsonContent(ref="#/components/schemas/UbicacionAlmacen")),
     *     @OA\Response(response=404, description="Ubicación no encontrada")
     * )
     */
    public function show($id)
    {
        $ubicacion = UbicacionAlmacen::find($id);

        if (!$ubicacion) {
            return response()->json(['error' => 'Ubicación no encontrada'], 404);
        }

        return response()->json($ubicacion);
    }

    /**
     * Actualizar una ubicación de almacén
     *
     * @OA\Put(
     *     path="/api/ubicaciones-almacen/{id}",
     *     tags={"UbicacionesAlmacen"},
     *     summary="Actualizar ubicación en almacén",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="codigo_ubicacion", type="string", example="RACK-03-B"),
     *             @OA\Property(property="tipo_almacenamiento", type="string", example="congelado"),
     *             @OA\Property(property="capacidad_maxima", type="integer", example=150),
     *             @OA\Property(property="restricciones", type="string", example="Solo productos lácteos")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Ubicación actualizada", @OA\JsonContent(ref="#/components/schemas/UbicacionAlmacen")),
     *     @OA\Response(response=404, description="Ubicación no encontrada")
     * )
     */
    public function update(Request $request, $id)
    {
        $ubicacion = UbicacionAlmacen::find($id);

        if (!$ubicacion) {
            return response()->json(['error' => 'Ubicación no encontrada'], 404);
        }

        $request->validate([
            'almacen_id' => 'sometimes|exists:almacenes,id',
            'codigo_ubicacion' => 'sometimes|string|max:50|unique:ubicaciones_almacenamiento,codigo_ubicacion,' . $id,
            'tipo_almacenamiento' => 'sometimes|in:refrigerado,congelado,seco',
            'capacidad_maxima' => 'sometimes|integer|min:1',
            'restricciones' => 'sometimes|string'
        ]);

        $ubicacion->update($request->all());

        return response()->json($ubicacion);
    }

    /**
     * Eliminar una ubicación de almacén
     *
     * @OA\Delete(
     *     path="/api/ubicaciones-almacen/{id}",
     *     tags={"UbicacionesAlmacen"},
     *     summary="Eliminar ubicación",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Ubicación eliminada",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Ubicación eliminada correctamente"))
     *     ),
     *     @OA\Response(response=404, description="Ubicación no encontrada")
     * )
     */
    public function destroy($id)
    {
        $ubicacion = UbicacionAlmacen::find($id);

        if (!$ubicacion) {
            return response()->json(['error' => 'Ubicación no encontrada'], 404);
        }

        $ubicacion->delete();

        return response()->json(['message' => 'Ubicación eliminada correctamente']);
    }
}
