<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Crear la tabla roles_permisos
        Schema::create('roles_permisos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_rol');
            $table->unsignedBigInteger('id_permiso');
            $table->unsignedBigInteger('asignado_por')->nullable(); // Puede ser NULL

            // Definir clave primaria compuesta antes de claves foráneas
            $table->primary(['id_rol', 'id_permiso']);

            // Claves foráneas
            $table->foreign('id_rol')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('id_permiso')->references('id')->on('permisos')->onDelete('cascade');
            $table->foreign('asignado_por')->references('id')->on('usuarios')->onDelete('set null');

            // Fechas de creación y actualización
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles_permisos');
    }
};
#bien