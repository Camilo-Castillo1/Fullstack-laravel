<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('almacenes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255)->unique();// unique para evitar duplicados
            $table->text('ubicacion');
            $table->integer('capacidad_maxima'); //se recomienda dejarlo en el modelo o swagger
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('almacenes');
    }
};
