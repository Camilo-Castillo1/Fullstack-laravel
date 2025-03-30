<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\ControlTemperaturaController;
use App\Http\Controllers\EntradaInventarioController;
use App\Http\Controllers\LogUsuarioController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PoliticaInventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\RolPermisoController;
use App\Http\Controllers\SalidaInventarioController;
use App\Http\Controllers\UbicacionAlmacenController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AlertaVencimientoController;
use App\Http\Controllers\LoteUbicacionController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::apiResource('categorias', CategoriaController::class);
Route::apiResource('almacenes', AlmacenController::class);
Route::apiResource('control-temperaturas', ControlTemperaturaController::class);
Route::apiResource('alertas-vencimiento', AlertaVencimientoController::class);
route::apiResource('lotes', LoteController::class);
route::apiResource('lote-ubicacion', LoteUbicacionController::class);
Route::get('/ejemplo', [ApiController::class, 'ejemplo']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
