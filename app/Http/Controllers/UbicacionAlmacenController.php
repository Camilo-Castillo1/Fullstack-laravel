<?php

namespace App\Http\Controllers;

use App\Models\UbicacionAlmacen;
use App\Models\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UbicacionAlmacenController extends Controller
{
    /**
     * Mostrar listado de ubicaciones de almacenamiento.
     */
    public function index()
    {
        $ubicaciones = UbicacionAlmacen::with('almacen')->orderBy('codigo_ubicacion')->get();

        if (Auth::user()->hasRole('admin')) {
            return view('ubicaciones.index', compact('ubicaciones'));
        }

        if (Auth::user()->hasRole('administrador de bodega')) {
            return view('bodega.ubicaciones.index', compact('ubicaciones'));
        }

        if (Auth::user()->hasRole('bodeguero')) {
            return view('bodeguero.ubicaciones.index', compact('ubicaciones'));
        }

        abort(403);
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $almacenes = Almacen::orderBy('nombre')->get();

        if (Auth::user()->hasRole('admin')) {
            return view('ubicaciones.create', compact('almacenes'));
        }

        if (Auth::user()->hasRole('administrador de bodega')) {
            return view('bodega.ubicaciones.create', compact('almacenes'));
        }

        if (Auth::user()->hasRole('bodeguero')) {
            return view('bodeguero.ubicaciones.create', compact('almacenes'));
        }

        abort(403);
    }

    /**
     * Guardar una nueva ubicación.
     */
    public function store(Request $request)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'codigo_ubicacion' => 'required|string|max:50|unique:ubicaciones_almacenamiento,codigo_ubicacion',
            'tipo_almacenamiento' => 'required|in:refrigerado,congelado,seco',
            'capacidad_maxima' => 'required|integer|min:1',
            'restricciones' => 'nullable|string|max:255',
        ]);

        UbicacionAlmacen::create($request->all());

        return redirect()->route($this->routeByRole())->with('success', 'Ubicación creada correctamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(UbicacionAlmacen $ubicacion)
    {
        $almacenes = Almacen::orderBy('nombre')->get();

        if (Auth::user()->hasRole('admin')) {
            return view('ubicaciones.edit', compact('ubicacion', 'almacenes'));
        }

        if (Auth::user()->hasRole('administrador de bodega')) {
            return view('bodega.ubicaciones.edit', compact('ubicacion', 'almacenes'));
        }

        if (Auth::user()->hasRole('bodeguero')) {
            return view('bodeguero.ubicaciones.edit', compact('ubicacion', 'almacenes'));
        }

        abort(403);
    }

    /**
     * Actualizar una ubicación existente.
     */
    public function update(Request $request, UbicacionAlmacen $ubicacion)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'codigo_ubicacion' => 'required|string|max:50|unique:ubicaciones_almacenamiento,codigo_ubicacion,' . $ubicacion->id,
            'tipo_almacenamiento' => 'required|in:refrigerado,congelado,seco',
            'capacidad_maxima' => 'required|integer|min:1',
            'restricciones' => 'nullable|string|max:255',
        ]);

        $ubicacion->update($request->all());

        return redirect()->route($this->routeByRole())->with('success', 'Ubicación actualizada correctamente.');
    }

    /**
     * Determina la ruta de redirección según el rol.
     */
    private function routeByRole()
    {
        if (Auth::user()->hasRole('admin')) {
            return 'admin.ubicaciones.index';
        }

        if (Auth::user()->hasRole('administrador de bodega')) {
            return 'bodega.ubicaciones.index';
        }

        if (Auth::user()->hasRole('bodeguero')) {
            return 'bodeguero.ubicaciones.index';
        }

        abort(403);
    }
}
