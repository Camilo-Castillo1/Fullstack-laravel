<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API de Gestión de Inventario",
 *      description="Documentación de la API con Swagger",
 *      @OA\Contact(
 *          email="soporte@tuempresa.com"
 *      )
 * )
 * @OA\Server(url="http://localhost")
 */
class ApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ejemplo",
     *     summary="Ejemplo de endpoint",
     *     tags={"Ejemplo"},
     *     @OA\Response(
     *         response=200,
     *         description="Respuesta exitosa"
     *     )
     * )
     */
    public function ejemplo()
    {
        return response()->json(['mensaje' => 'Hola, Swagger!']);
    }
}
