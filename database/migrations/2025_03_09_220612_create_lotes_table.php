<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_lote', 50);
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad');
            $table->date('fecha_ingreso');
            $table->date('fecha_vencimiento')->nullable();
            $table->enum('estado', ['disponible', 'agotado', 'vencido']);
            $table->timestamps();

            // Llave foránea
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lotes');
    }
};
//bien