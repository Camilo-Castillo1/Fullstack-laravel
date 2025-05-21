<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar primero los permisos y luego los roles
        $this->call([
            PermisosSeeder::class,
            RolesSeeder::class,
        ]);
    }
}
