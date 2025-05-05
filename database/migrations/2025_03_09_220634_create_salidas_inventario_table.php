<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('salidas_inventario', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lote_id');
            $table->unsignedBigInteger('usuario_id');
            $table->integer('cantidad');
            $table->text('motivo')->nullable();
            $table->timestamp('fecha_movimiento')->useCurrent();

            // Agregar timestamps de Laravel
            $table->timestamps(); // Agrega created_at y updated_at automáticamente

            // Llaves foráneas
            $table->foreign('lote_id')->references('id')->on('lotes')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salidas_inventario');
    }
};
//bien