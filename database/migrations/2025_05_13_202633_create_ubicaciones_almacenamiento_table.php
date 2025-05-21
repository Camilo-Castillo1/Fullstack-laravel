<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ubicaciones_almacenamiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('almacen_id');
            $table->string('codigo_ubicacion', 50);
            //$table->unique(['almacen_id', 'codigo_ubicacion'], 'almacen_codigo_unique');
            // unicidad de almacen_id y codigo_ubicacion
            $table->enum('tipo_almacenamiento', ['refrigerado', 'congelado', 'seco']);
            $table->integer('capacidad_maxima');//igual que en la tabla de almacenes
            $table->text('restricciones')->nullable();

            // Llave foránea
            $table->foreign('almacen_id')->references('id')->on('almacenes')->onDelete('cascade');

            // Agregar timestamps de Laravel
            $table->timestamps(); // ✅ Agrega created_at y updated_at automáticamente
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ubicaciones_almacenamiento');
    }
};
