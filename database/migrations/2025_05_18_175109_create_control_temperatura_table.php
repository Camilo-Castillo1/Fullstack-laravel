<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('control_temperatura', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('almacen_id');
            $table->decimal('temperatura', 5, 2);
            $table->timestamp('fecha_registro')->nullable()->default(now()); // ✅ Permite NULL y usa la fecha actual

            // Llave foránea
            $table->foreign('almacen_id')->references('id')->on('almacenes')->onDelete('cascade');

            // Agregar timestamps de Laravel
            $table->timestamps(); // ✅ Agrega created_at y updated_at automáticamente
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('control_temperatura');
    }
};
//bien
