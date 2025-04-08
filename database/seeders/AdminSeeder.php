<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('correo', 'admin@correo.com')->exists()) {
            $admin = User::create([
                'nombre' => 'Admin',
                'apellido' => 'Principal',
                'correo' => 'admin@correo.com',
                'password' => bcrypt('admin123'),
                'telefono' => '3001234567',
                'estado' => 'activo',
            ]);

            // Crear rol admin si no existe
            $rol = Role::firstOrCreate(
                ['name' => 'admin', 'guard_name' => 'web'],
                ['descripcion' => 'Usuario administrador del sistema']
            );

            $admin->assignRole($rol);
        }
    }
}
