<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('politicas_inventario', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->enum('tipo', ['PEPS', 'UEPS', 'FIFO']);
            $table->enum('aplicable_a', ['producto', 'lote', 'almacen']);

            // ✅ Corregido: nombre del campo debe ser tipo_producto, no tipo_almacenamiento
            $table->enum('tipo_producto', ['refrigerado', 'seco', 'congelado'])->nullable();

            $table->decimal('valor', 8, 2);
            $table->date('fecha_implementacion')->default(DB::raw('CURRENT_DATE'));
            $table->unsignedBigInteger('ubicacion_id');
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->unsignedBigInteger('almacen_id')->nullable();

            // Llaves foráneas
            $table->foreign('ubicacion_id')->references('id')->on('ubicaciones_almacenamiento');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
            $table->foreign('almacen_id')->references('id')->on('almacenes')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('politicas_inventario');
    }
};
