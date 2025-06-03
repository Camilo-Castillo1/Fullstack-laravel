<?php

namespace App\Http\Controllers;

use App\Models\ControlTemperatura;
use App\Models\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControlTemperaturaController extends Controller
{
    /**
     * Mostrar listado de registros de temperatura.
     */
    public function index()
    {
        $registros = ControlTemperatura::with('almacen')
            ->orderByDesc('fecha_registro')
            ->get();

        if (Auth::user()->hasRole('admin')) {
            return view('temperaturas.index', compact('registros'));
        }

        if (Auth::user()->hasRole('administrador de bodega')) {
            return view('bodega.temperaturas.index', compact('registros'));
        }

        if (Auth::user()->hasRole('bodeguero')) {
            return view('bodeguero.temperaturas.index', compact('registros'));
        }

        abort(403);
    }

    /**
     * Formulario para crear un nuevo registro.
     */
    public function create()
    {
        $almacenes = Almacen::all();

        if (Auth::user()->hasRole('admin')) {
            return view('temperaturas.create', compact('almacenes'));
        }

        if (Auth::user()->hasRole('administrador de bodega')) {
            return view('bodega.temperaturas.create', compact('almacenes'));
        }

        if (Auth::user()->hasRole('bodeguero')) {
            return view('bodeguero.temperaturas.create', compact('almacenes'));
        }

        abort(403);
    }

    /**
     * Guardar un nuevo registro.
     */
    public function store(Request $request)
    {
        $request->validate([
            'almacen_id'   => 'required|exists:almacenes,id',
            'temperatura'  => 'required|numeric|min:-50|max:100',
        ]);

        ControlTemperatura::create([
            'almacen_id' => $request->almacen_id,
            'temperatura' => $request->temperatura,
            'fecha_registro' => now(),
        ]);

        return redirect()->route($this->routeByRole())->with('success', 'Registro de temperatura guardado correctamente.');
    }

    /**
     * Formulario para editar un registro existente.
     */
    public function edit($id)
    {
        $registro = ControlTemperatura::findOrFail($id);
        $almacenes = Almacen::all();

        if (Auth::user()->hasRole('admin')) {
            return view('temperaturas.edit', compact('registro', 'almacenes'));
        }

        if (Auth::user()->hasRole('administrador de bodega')) {
            return view('bodega.temperaturas.edit', compact('registro', 'almacenes'));
        }

        if (Auth::user()->hasRole('bodeguero')) {
            return view('bodeguero.temperaturas.edit', compact('registro', 'almacenes'));
        }

        abort(403);
    }

    /**
     * Actualizar un registro existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'almacen_id'   => 'required|exists:almacenes,id',
            'temperatura'  => 'required|numeric|min:-50|max:100',
        ]);

        $registro = ControlTemperatura::findOrFail($id);

        $registro->update([
            'almacen_id' => $request->almacen_id,
            'temperatura' => $request->temperatura,
            'fecha_registro' => now(),
        ]);

        return redirect()->route($this->routeByRole())->with('success', 'Registro actualizado correctamente.');
    }

    /**
     * Eliminar un registro.
     */
    public function destroy($id)
    {
        $registro = ControlTemperatura::findOrFail($id);
        $registro->delete();

        return redirect()->route($this->routeByRole())->with('success', 'Registro eliminado correctamente.');
    }

    /**
     * Determinar ruta de redirección por rol.
     */
    private function routeByRole()
    {
        if (Auth::user()->hasRole('admin')) {
            return 'admin.temperaturas.index';
        }

        if (Auth::user()->hasRole('administrador de bodega')) {
            return 'bodega.temperaturas.index';
        }

        if (Auth::user()->hasRole('bodeguero')) {
            return 'bodeguero.temperaturas.index';
        }

        abort(403);
    }
}
