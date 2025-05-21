<?php

namespace App\Http\Controllers;

use App\Models\PoliticaInventario;
use App\Models\UbicacionAlmacen;
use App\Models\Categoria;
use App\Models\Almacen;
use Illuminate\Http\Request;

class PoliticaInventarioController extends Controller
{
    public function index()
    {
        $politicas = PoliticaInventario::with(['ubicacion', 'categoria', 'almacen'])
            ->orderByDesc('fecha_implementacion')
            ->get();

        return view('politicas.index', compact('politicas'));
    }

    public function create()
    {
        return view('politicas.create', [
            'ubicaciones' => UbicacionAlmacen::all(),
            'categorias' => Categoria::all(),
            'almacenes' => Almacen::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'tipo' => 'required|in:PEPS,UEPS,FIFO',
            'aplicable_a' => 'required|in:producto,lote,almacen',
            'valor' => 'required|numeric|min:0',
            'fecha_implementacion' => 'required|date',
            'tipo_producto' => 'nullable|in:refrigerado,seco,congelado',
            'ubicacion_id' => 'required|exists:ubicaciones_almacenamiento,id',
            'categoria_id' => 'nullable|exists:categorias,id',
            'almacen_id' => 'nullable|exists:almacenes,id',
        ]);

        PoliticaInventario::create($request->all());

        return redirect()->route('admin.politicas.index')->with('success', 'Política registrada correctamente.');
    }

    public function edit($id)
    {
        $politica = PoliticaInventario::findOrFail($id);

        return view('politicas.edit', [
            'politica' => $politica,
            'ubicaciones' => UbicacionAlmacen::all(),
            'categorias' => Categoria::all(),
            'almacenes' => Almacen::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'tipo' => 'required|in:PEPS,UEPS,FIFO',
            'aplicable_a' => 'required|in:producto,lote,almacen',
            'valor' => 'required|numeric|min:0',
            'fecha_implementacion' => 'required|date',
            'tipo_producto' => 'nullable|in:refrigerado,seco,congelado',
            'ubicacion_id' => 'required|exists:ubicaciones_almacenamiento,id',
            'categoria_id' => 'nullable|exists:categorias,id',
            'almacen_id' => 'nullable|exists:almacenes,id',
        ]);

        $politica = PoliticaInventario::findOrFail($id);
        $politica->update($request->all());

        return redirect()->route('admin.politicas.index')->with('success', 'Política actualizada correctamente.');
    }

    public function destroy($id)
    {
        $politica = PoliticaInventario::findOrFail($id);
        $politica->delete();

        return redirect()->route('admin.politicas.index')->with('success', 'Política eliminada.');
    }
}
