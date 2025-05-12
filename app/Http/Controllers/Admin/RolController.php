<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RolController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:roles,nombre',
            'descripcion' => 'nullable|string|max:255',
        ]);

        Role::create([
            'name' => strtolower(str_replace(' ', '_', $request->nombre)), // para Spatie
            'guard_name' => 'web',
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Rol creado correctamente.');
    }
}
