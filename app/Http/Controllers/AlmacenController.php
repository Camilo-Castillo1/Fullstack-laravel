<?php
namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    public function index()
    {
        $almacenes = Almacen::all();
        return view('almacenes.index', compact('almacenes'));
    }

    public function create()
    {
        return view('almacenes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:almacenes,nombre',
            'ubicacion' => 'required|string',
            'capacidad_maxima' => 'required|integer|min:1',
        ]);

        Almacen::create($request->only('nombre', 'ubicacion', 'capacidad_maxima'));

        return redirect()->route('almacenes.index')->with('success', 'Almacén creado correctamente.');
    }

    public function edit(Almacen $almacen)
    {
        return view('almacenes.edit', compact('almacen'));
    }

    public function update(Request $request, Almacen $almacen)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:almacenes,nombre,' . $almacen->id,
            'ubicacion' => 'required|string',
            'capacidad_maxima' => 'required|integer|min:1',
        ]);

        $almacen->update($request->only('nombre', 'ubicacion', 'capacidad_maxima'));

        return redirect()->route('almacenes.index')->with('success', 'Almacén actualizado correctamente.');
    }

    public function destroy(Almacen $almacen)
    {
        $almacen->delete();

        return redirect()->route('almacenes.index')->with('success', 'Almacén eliminado.');
    }
}
