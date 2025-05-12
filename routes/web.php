<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\UsuarioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Página pública
Route::get('/', function () {
    return view('welcome');
});

// Dashboard privado
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ruta personalizada para mostrar la vista de usuarios
Route::get('/usuarios/panel', [UserController::class, 'index'])
    ->name('usuarios.panel')
    ->middleware(['auth', 'role:admin']);

// Rutas de perfil de usuario autenticado
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas CRUD de usuarios solo para admin (sin prefijo "admin/")
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('usuarios', UserController::class);
    // Si necesitas que las rutas estén en /admin/usuarios, activa esta sección:
Route::prefix('admin')->name('admin.')->group(function () {
     Route::resource('usuarios', UsuarioController::class);
     });
});

require __DIR__.'/auth.php';
