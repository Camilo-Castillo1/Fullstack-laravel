<?php

namespace App\Http\Controllers;

use App\Models\UbicacionAlmacen;
use App\Models\Almacen;
use Illuminate\Http\Request;

class UbicacionAlmacenController extends Controller
{
    /**
     * Mostrar listado de ubicaciones de almacenamiento.
     */
    public function index()
    {
        $ubicaciones = UbicacionAlmacen::with('almacen')->get();
        return view('ubicaciones.index', compact('ubicaciones'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $almacenes = Almacen::all();
        return view('ubicaciones.create', compact('almacenes'));
    }

    /**
     * Guardar una nueva ubicación.
     */
    public function store(Request $request)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'codigo_ubicacion' => 'required|string|max:50',
            'tipo_almacenamiento' => 'required|in:refrigerado,congelado,seco',
            'capacidad_maxima' => 'required|integer|min:1',
            'restricciones' => 'nullable|string',
        ]);

        UbicacionAlmacen::create($request->all());

        return redirect()->route('admin.ubicaciones.index')->with('success', 'Ubicación creada correctamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(UbicacionAlmacen $ubicacion)
    {
        $almacenes = Almacen::all();
        return view('ubicaciones.edit', compact('ubicacion', 'almacenes'));
    }

    /**
     * Actualizar una ubicación existente.
     */
    public function update(Request $request, UbicacionAlmacen $ubicacion)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'codigo_ubicacion' => 'required|string|max:50',
            'tipo_almacenamiento' => 'required|in:refrigerado,congelado,seco',
            'capacidad_maxima' => 'required|integer|min:1',
            'restricciones' => 'nullable|string',
        ]);

        $ubicacion->update($request->all());

        return redirect()->route('admin.ubicaciones.index')->with('success', 'Ubicación actualizada correctamente.');
    }

    /**
     * Eliminar una ubicación.
     */
    public function destroy(UbicacionAlmacen $ubicacion)
    {
        $ubicacion->delete();
        return redirect()->route('admin.ubicaciones.index')->with('success', 'Ubicación eliminada.');
    }
}
