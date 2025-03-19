<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\UbicacionAlmacenController;
use App\Http\Controllers\PoliticaInventarioController;
use App\Http\Controllers\LogUsuarioController;
use App\Http\Controllers\EntradaInventarioController;
use App\Http\Controllers\SalidaInventarioController;
use App\Http\Controllers\ControlTemperaturaController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RolPermisoController;
use App\Http\Controllers\UsuarioController;

Route::resource('categorias', CategoriaController::class);
Route::resource('productos', ProductoController::class);
Route::resource('lotes', LoteController::class);
Route::resource('almacenes', AlmacenController::class);
Route::resource('ubicaciones_almacen', UbicacionAlmacenController::class);
Route::resource('politicas_inventario', PoliticaInventarioController::class);
Route::resource('log_usuarios', LogUsuarioController::class);
Route::resource('entradas_inventario', EntradaInventarioController::class);
Route::resource('salidas_inventario', SalidaInventarioController::class);
Route::resource('control_temperatura', ControlTemperaturaController::class);
Route::resource('roles', RolController::class);
Route::resource('permisos', PermisoController::class);
Route::resource('roles_permisos', RolPermisoController::class);
Route::resource('usuarios', UsuarioController::class);


Route::get('/', function () {
    return view('welcome');
});
