<?php

namespace App\Http\Controllers;

use App\Models\ControlTemperatura;
use App\Models\Almacen;
use Illuminate\Http\Request;

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

        return view('temperaturas.index', compact('registros'));
    }

    /**
     * Formulario para crear un nuevo registro.
     */
    public function create()
    {
        $almacenes = Almacen::all();
        return view('temperaturas.create', compact('almacenes'));
    }

    /**
     * Guardar un nuevo registro.
     */
    public function store(Request $request)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'temperatura' => 'required|numeric|min:-50|max:100',
        ]);

        ControlTemperatura::create([
            'almacen_id' => $request->almacen_id,
            'temperatura' => $request->temperatura,
            'fecha_registro' => now(),
        ]);

        return redirect()->route('admin.temperaturas.index')
            ->with('success', 'Registro de temperatura guardado correctamente.');
    }

    /**
     * Formulario para editar un registro existente.
     */
    public function edit($id)
    {
        $registro = ControlTemperatura::findOrFail($id);
        $almacenes = Almacen::all();

        return view('temperaturas.edit', compact('registro', 'almacenes'));
    }

    /**
     * Actualizar un registro existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'temperatura' => 'required|numeric|min:-50|max:100',
        ]);

        $registro = ControlTemperatura::findOrFail($id);

        $registro->update([
            'almacen_id' => $request->almacen_id,
            'temperatura' => $request->temperatura,
            'fecha_registro' => now(),
        ]);

        return redirect()->route('admin.temperaturas.index')
            ->with('success', 'Registro actualizado correctamente.');
    }

    /**
     * Eliminar un registro.
     */
    public function destroy($id)
    {
        $registro = ControlTemperatura::findOrFail($id);
        $registro->delete();

        return redirect()->route('admin.temperaturas.index')
            ->with('success', 'Registro eliminado correctamente.');
    }
}
