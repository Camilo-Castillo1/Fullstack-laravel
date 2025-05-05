<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('apellido', 255);
            $table->string('correo', 255)->unique();
            $table->string('password', 255);
            $table->string('telefono', 20)->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamp('ultimo_acceso')->nullable();
            #$table->timestamp('fecha_creacion')->useCurrent();
            #$table->timestamp('fecha_actualizacion')->default(now())->useCurrentOnUpdate();
            #se recomienda no usar estos dos campos, ya que se pueden obtener de la tabla de auditoria
            #$table->unsignedBigInteger('creado_por')->nullable();
            #$table->unsignedBigInteger('actualizado_por')->nullable();
            #manejar auditoria avanzada con el paquete spatie/laravel-auditor
            $table->unsignedBigInteger('id_rol');
            $table->foreign('id_rol')->references('id')->on('roles')->onDelete('cascade');

            $table->timestamps(); // craeate created_at and updated_at automaticos
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
