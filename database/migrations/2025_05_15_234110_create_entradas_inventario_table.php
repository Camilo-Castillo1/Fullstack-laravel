<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('entradas_inventario', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lote_id');
            $table->bigInteger('usuario_id');
            $table->integer('cantidad');
            $table->text('motivo')->nullable();
            $table->timestamp('fecha_movimiento')->useCurrent();

            // Llaves foráneas corregidas
            $table->foreign('lote_id')->references('id')->on('lotes')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entradas_inventario');
    }
};
