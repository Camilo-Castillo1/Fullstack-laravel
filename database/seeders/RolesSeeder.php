<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $adminBodega = Role::firstOrCreate(['name' => 'administrador de bodega']);
        $bodeguero = Role::firstOrCreate(['name' => 'bodeguero']);

        // Admin tiene todos los permisos
        $admin->syncPermissions(Permission::all());

        // Permisos para administrador de bodega
        $adminBodega->syncPermissions([
            'ver productos', 'crear productos', 'editar productos',
            'ver lotes', 'crear lotes', 'editar lotes',
            'ver entradas', 'crear entradas',
            'ver salidas', 'crear salidas',
            'ver alertas',
            'ver ubicaciones',
            'ver control de temperatura',
        ]);

        // Permisos para bodeguero
        $bodeguero->syncPermissions([
            'ver productos',
            'ver lotes',
            'ver entradas', 'crear entradas',
            'ver salidas', 'crear salidas',
            'ver alertas',
        ]);
    }
}
