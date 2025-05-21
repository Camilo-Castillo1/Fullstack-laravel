<?php
namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
            'descripcion' => 'nullable|string',
        ]);

        Categoria::create($request->only('nombre', 'descripcion'));

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada correctamente.');
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string',
        ]);

        $categoria->update($request->only('nombre', 'descripcion'));

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
{
    // Verifica si la categoría tiene productos asociados
    if ($categoria->productos()->exists()) {
        return redirect()->route('categorias.index')
            ->with('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
    }

    // Elimina la categoría si no tiene relaciones
    $categoria->delete();

    return redirect()->route('admin.categorias.index')->with('success', 'Categoría eliminada correctamente.');
}

}
