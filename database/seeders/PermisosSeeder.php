<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermisosSeeder extends Seeder
{
    public function run(): void
    {
        $permisos = [
            // Productos
            'ver productos', 'crear productos', 'editar productos', 'eliminar productos',

            // Lotes
            'ver lotes', 'crear lotes', 'editar lotes', 'eliminar lotes',

            // Entradas
            'ver entradas', 'crear entradas', 'editar entradas', 'eliminar entradas',

            // Salidas
            'ver salidas', 'crear salidas', 'editar salidas', 'eliminar salidas',

            // Alertas
            'ver alertas', 'editar alertas', 'eliminar alertas',

            // Ubicaciones y temperatura
            'ver ubicaciones',
            'ver control de temperatura',

            // Configuración y usuarios (solo admin)
            'administrar usuarios',
            'crear roles',
            'editar roles',
            'eliminar roles',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }
    }
}
