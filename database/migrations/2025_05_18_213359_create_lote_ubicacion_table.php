<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lote_ubicacion', function (Blueprint $table) {
            $table->unsignedBigInteger('id_lote');
            $table->unsignedBigInteger('id_ubicacion');
            $table->integer('cantidad')->nullable();

            // Clave primaria compuesta
            $table->primary(['id_lote', 'id_ubicacion']);

            // Llaves foráneas
            $table->foreign('id_lote')->references('id')->on('lotes')->onDelete('cascade');
            $table->foreign('id_ubicacion')->references('id')->on('ubicaciones_almacenamiento')->onDelete('cascade');

            $table->timestamps(); // ✅ activamos created_at y updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lote_ubicacion');
    }
};
