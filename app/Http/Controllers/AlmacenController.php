<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;



/**
 * @OA\Schema(
 *     schema="Almacen",
 *     type="object",
 *     required={"nombre", "ubicacion", "capacidad_maxima"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Almacén Central"),
 *     @OA\Property(property="ubicacion", type="string", example="Calle 123 #45-67, Bogotá"),
 *     @OA\Property(property="capacidad_maxima", type="integer", example=1000),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-25T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-25T12:00:00Z")
 * )
 */
class AlmacenController extends Controller
{
    /**
     * Obtener todos los almacenes
     *
     * @OA\Get(
     *     path="/almacenes",
     *     tags={"Almacenes"},
     *     summary="Lista todos los almacenes",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de almacenes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Almacen")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Almacen::all(), 200);
    }

    /**
     * Crear un nuevo almacén
     *
     * @OA\Post(
     *     path="/almacenes",
     *     tags={"Almacenes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "ubicacion", "capacidad_maxima"},
     *             @OA\Property(property="nombre", type="string", example="Almacén Central"),
     *             @OA\Property(property="ubicacion", type="string", example="Calle 123 #45-67, Bogotá"),
     *             @OA\Property(property="capacidad_maxima", type="integer", example=1000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Almacén creado",
     *         @OA\JsonContent(ref="#/components/schemas/Almacen")
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
            'nombre' => 'required|string|max:255|unique:almacenes',
            'ubicacion' => 'required|string',
            'capacidad_maxima' => 'required|integer|min:1'
        ]);

        $almacen = Almacen::create($request->all());

        return response()->json($almacen, 201);
    }

    /**
     * Mostrar un almacén por ID
     *
     * @OA\Get(
     *     path="/almacenes/{id}",
     *     tags={"Almacenes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Almacén encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Almacen")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Almacén no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $almacen = Almacen::find($id);

        if (!$almacen) {
            return response()->json(['error' => 'Almacén no encontrado'], 404);
        }

        return response()->json($almacen);
    }

    /**
     * Actualizar un almacén
     *
     * @OA\Put(
     *     path="/almacenes/{id}",
     *     tags={"Almacenes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Almacén Norte"),
     *             @OA\Property(property="ubicacion", type="string", example="Carrera 10 #20-30"),
     *             @OA\Property(property="capacidad_maxima", type="integer", example=1500)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Almacén actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Almacen")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Almacén no encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $almacen = Almacen::find($id);

        if (!$almacen) {
            return response()->json(['error' => 'Almacén no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:255|unique:almacenes,nombre,' . $id,
            'ubicacion' => 'sometimes|string',
            'capacidad_maxima' => 'sometimes|integer|min:1'
        ]);

        $almacen->update($request->all());

        return response()->json($almacen);
    }

    /**
     * Eliminar un almacén
     *
     * @OA\Delete(
     *     path="/almacenes/{id}",
     *     tags={"Almacenes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Almacén eliminado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Almacén eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Almacén no encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $almacen = Almacen::find($id);

        if (!$almacen) {
            return response()->json(['error' => 'Almacén no encontrado'], 404);
        }

        $almacen->delete();

        return response()->json(['message' => 'Almacén eliminado correctamente']);
    }
}
