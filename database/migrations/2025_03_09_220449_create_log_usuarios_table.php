<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('log_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->enum('tipo_evento', ['INSERT', 'UPDATE', 'DELETE']);
            $table->string('campo_modificado', 50)->nullable();
            $table->text('valor_anterior')->nullable();
            $table->text('valor_nuevo')->nullable();
            $table->unsignedBigInteger('usuario_modifico')->nullable(); // Usuario que realizó la acción
            $table->timestamp('fecha_evento')->nullable()->default(now()); // Permite NULL y usa fecha actual

            // Claves foráneas
            $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('usuario_modifico')->references('id')->on('usuarios')->onDelete('set null');

            // Agregar timestamps de Laravel
            $table->timestamps(); // Agrega created_at y updated_at automáticamente
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_usuarios');
    }
};
