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
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Página pública
Route::get('/', function () {
    return view('welcome');
});



// Rutas de perfil de usuario autenticado
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

// Rutas protegidas para ADMIN (prefijo /admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('usuarios', UserController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('almacenes', AlmacenController::class)->parameters(['almacenes' => 'almacen']);
     Route::resource('ubicaciones', UbicacionAlmacenController::class)->parameters([
        'ubicaciones' => 'ubicacion'
    ]);
    Route::resource('productos', ProductoController::class);
    Route::resource('lotes', LoteController::class)->parameters(['lotes' => 'lote']);
    Route::resource('entradas', EntradaInventarioController::class)->except(['show']);
    Route::resource('salidas', SalidaInventarioController::class)->except(['show']);
    Route::resource('politicas', PoliticaInventarioController::class);
    Route::resource('lote-ubicacion', LoteUbicacionController::class)->parameters(['lote-ubicacion' => 'loteUbicacion']);
    Route::get('lote-ubicacion/{id_lote}/{id_ubicacion}/edit', [LoteUbicacionController::class, 'edit'])->name('lote-ubicacion.edit');
    Route::put('lote-ubicacion/{id_lote}/{id_ubicacion}', [LoteUbicacionController::class, 'update'])->name('lote-ubicacion.update');
    Route::delete('lote-ubicacion/{id_lote}/{id_ubicacion}', [LoteUbicacionController::class, 'destroy'])->name('lote-ubicacion.destroy');
    Route::resource('roles', RolController::class);
    Route::resource('alertas', AlertaVencimientoController::class)->only(['index', 'show']);
    Route::resource('temperaturas', ControlTemperaturaController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
     Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Rutas para ADMINISTRADOR DE BODEGA (prefijo /bodega)
Route::middleware(['auth', 'role:administrador de bodega'])->prefix('bodega')->name('bodega.')->group(function () {
    Route::get('/dashboard', function () {
        return view('bodega.dashboard');
    })->name('dashboard');
    Route::resource('productos', ProductoController::class)->except(['destroy']);
    Route::resource('lotes', LoteController::class)->except(['destroy']);
    Route::resource('entradas', EntradaInventarioController::class)->only(['index', 'create', 'store']);
    Route::resource('salidas', SalidaInventarioController::class)->only(['index', 'create', 'store']);
    Route::resource('alertas', AlertaVencimientoController::class)->only(['index']);
    Route::resource('ubicaciones', UbicacionAlmacenController::class)->only(['index']);
    Route::resource('temperaturas', ControlTemperaturaController::class)->only(['index']);
});

// Rutas para BODEGUERO (prefijo /bodeguero)
Route::middleware(['auth', 'role:bodeguero'])->prefix('bodeguero')->name('bodeguero.')->group(function () {
    Route::resource('productos', ProductoController::class)->only(['index']);
    Route::resource('lotes', LoteController::class)->only(['index']);
    Route::resource('entradas', EntradaInventarioController::class)->only(['index', 'create', 'store']);
    Route::resource('salidas', SalidaInventarioController::class)->only(['index', 'create', 'store']);
    Route::resource('alertas', AlertaVencimientoController::class)->only(['index']);
});
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

require __DIR__ . '/auth.php';
