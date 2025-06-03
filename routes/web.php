<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\PermisoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\UbicacionAlmacenController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\AlertaVencimientoController;
use App\Http\Controllers\EntradaInventarioController;
use App\Http\Controllers\SalidaInventarioController;
use App\Http\Controllers\ControlTemperaturaController;
use App\Http\Controllers\PoliticaInventarioController;
use App\Http\Controllers\LoteUbicacionController;
use App\Http\Controllers\ProductoExportController;
use App\Http\Controllers\BodegaDashboardController;
use App\Http\Controllers\ReporteController;



// Página pública
Route::get('/', function () {
    return view('welcome');
});

// Redirección central según rol autenticado
Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('administrador de bodega')) {
        return redirect()->route('bodega.landing');
    } elseif ($user->hasRole('bodeguero')) {
        return redirect()->route('bodeguero.dashboard');
    }

    return redirect('/');
})->name('dashboard');
Route::middleware('auth')->get('reportes/{id}/ver-pdf', [ReporteController::class, 'verPDF'])->name('reportes.ver-pdf');


// Perfil de usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/debug-auth', function () {
        return [
            'auth_id' => auth()->id(),
            'user_id' => auth()->user()?->id,
            'correo' => auth()->user()?->correo,
            'roles' => auth()->user()?->getRoleNames(),
        ];
    });
});

// Rutas para ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('usuarios', UserController::class);
    Route::resource('roles', RolController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('almacenes', AlmacenController::class)->parameters(['almacenes' => 'almacen']);
    Route::resource('ubicaciones', UbicacionAlmacenController::class)->parameters(['ubicaciones' => 'ubicacion']);
    Route::resource('productos', ProductoController::class);
    Route::resource('lotes', LoteController::class)->parameters(['lotes' => 'lote']);
    Route::resource('entradas', EntradaInventarioController::class)->except(['show']);
    Route::resource('salidas', SalidaInventarioController::class)->except(['show']);
    Route::resource('politicas', PoliticaInventarioController::class);
    Route::resource('alertas', AlertaVencimientoController::class)->only(['index', 'show']);
    Route::resource('temperaturas', ControlTemperaturaController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('lote-ubicacion', LoteUbicacionController::class)->parameters(['lote-ubicacion' => 'loteUbicacion']);
    Route::get('lote-ubicacion/{id_lote}/{id_ubicacion}/edit', [LoteUbicacionController::class, 'edit'])->name('lote-ubicacion.edit');
    Route::put('lote-ubicacion/{id_lote}/{id_ubicacion}', [LoteUbicacionController::class, 'update'])->name('lote-ubicacion.update');
    Route::delete('lote-ubicacion/{id_lote}/{id_ubicacion}', [LoteUbicacionController::class, 'destroy'])->name('lote-ubicacion.destroy');
    Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('reportes/{reporte}/ver-pdf', [ReporteController::class, 'verPDF'])->name('reportes.ver-pdf');
    // Para admin y administrador de bodega
Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
Route::get('reportes/pdf', [ReporteController::class, 'descargarPDF'])->name('reportes.pdf');
Route::get('reportes/{id}/ver-pdf', [ReporteController::class, 'verPDF'])->name('reportes.ver-pdf');

});

// Rutas para ADMINISTRADOR DE BODEGA
Route::middleware(['auth', 'role:administrador de bodega'])->prefix('bodega')->name('bodega.')->group(function () {
    Route::get('/landing', function () {
        return view('bodega.landing');
    })->name('landing');

    Route::resource('productos', ProductoController::class)->except(['destroy']);
    Route::resource('lotes', LoteController::class)->except(['destroy']);
    Route::resource('entradas', EntradaInventarioController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    Route::resource('salidas', SalidaInventarioController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    Route::resource('alertas', AlertaVencimientoController::class)->only(['index']);
    Route::resource('ubicaciones', UbicacionAlmacenController::class)->only(['index']);
    Route::resource('temperaturas', ControlTemperaturaController::class)->only(['index']);
    Route::get('alertas', [AlertaVencimientoController::class, 'index'])->name('alertas.index');
    Route::get('alertas/{id}/atender', [AlertaVencimientoController::class, 'atender'])->name('alertas.atender');
    Route::post('alertas/{id}/atender', [AlertaVencimientoController::class, 'resolver'])->name('alertas.resolver');
    Route::resource('ubicaciones', UbicacionAlmacenController::class)
    ->parameters(['ubicaciones' => 'ubicacion'])
    ->only(['index', 'create', 'store', 'edit', 'update']);
    Route::resource('temperaturas', ControlTemperaturaController::class)
    ->parameters(['temperaturas' => 'temperatura'])
    ->only(['index', 'create', 'store', 'edit', 'update']);
    Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('reportes/{id}/ver-pdf', [ReporteController::class, 'verPDF'])->name('reportes.ver-pdf');
    // Para admin y administrador de bodega
Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
Route::get('reportes/pdf', [ReporteController::class, 'descargarPDF'])->name('reportes.pdf');
Route::get('reportes/{id}/ver-pdf', [ReporteController::class, 'verPDF'])->name('reportes.ver-pdf');


});

// Rutas para BODEGUERO
Route::middleware(['auth', 'role:bodeguero'])->prefix('bodeguero')->name('bodeguero.')->group(function () {
    Route::get('/dashboard', [BodegaDashboardController::class, 'index'])->name('dashboard');

    // Rutas permitidas para el bodeguero
    Route::resource('productos', ProductoController::class)->only(['index']);
    Route::resource('lotes', LoteController::class)->only(['index']);
    Route::resource('entradas', EntradaInventarioController::class)->only(['index', 'create', 'store']);
    Route::resource('salidas', SalidaInventarioController::class)->only(['index', 'create', 'store']);
    Route::resource('alertas', AlertaVencimientoController::class)->only(['index']);
    Route::resource('ubicaciones', UbicacionAlmacenController::class)->only(['index']);
     Route::get('reportes/crear', [ReporteController::class, 'create'])->name('reportes.create');
    Route::post('reportes', [ReporteController::class, 'store'])->name('reportes.store');


});
Route::middleware(['auth', 'role:admin|administrador de bodega'])->group(function () {
    Route::get('reportes/pdf', [ReporteController::class, 'descargarPDF'])->name('reportes.pdf');
});

Route::get('/exportar-productos/excel', [ProductoExportController::class, 'exportExcel'])->name('productos.export.excel');
Route::get('/exportar-productos/pdf', [ProductoExportController::class, 'exportPDF'])->name('productos.export.pdf');

require __DIR__ . '/auth.php';
