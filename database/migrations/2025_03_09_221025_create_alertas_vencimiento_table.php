<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alertas_vencimiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lote_id');
            $table->date('fecha_vencimiento');
            $table->timestamp('fecha_alerta_generada')->useCurrent();
            $table->enum('estado', ['pendiente', 'atendida']);

            // Llave foránea
            $table->foreign('lote_id')->references('id')->on('lotes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alertas_vencimiento');
    }
};
//bien