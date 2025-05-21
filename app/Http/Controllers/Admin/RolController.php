<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permisos = Permission::all();
        $grupos = [
            'productos' => 'Productos',
            'lotes' => 'Lotes',
            'entradas' => 'Entradas',
            'salidas' => 'Salidas',
            'alertas' => 'Alertas',
            'ubicaciones' => 'Ubicaciones',
            'control de temperatura' => 'Temperatura',
            'usuarios' => 'Usuarios',
            'roles' => 'Roles'
        ];

        return view('roles.create', compact('permisos', 'grupos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array|nullable',
        ]);

        $rol = Role::create(['name' => $request->name]);

        if ($request->permissions) {
            $rol->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function edit(Role $role)
    {
        $permisos = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $grupos = [
            'productos' => 'Productos',
            'lotes' => 'Lotes',
            'entradas' => 'Entradas',
            'salidas' => 'Salidas',
            'alertas' => 'Alertas',
            'ubicaciones' => 'Ubicaciones',
            'control de temperatura' => 'Temperatura',
            'usuarios' => 'Usuarios',
            'roles' => 'Roles'
        ];

        return view('roles.edit', compact('role', 'permisos', 'rolePermissions', 'grupos'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array|nullable',
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.roles.index')->with('success', 'Rol actualizado.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado.');
    }
}
