<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lote_ubicacion', function (Blueprint $table) {
            // Claves primarias compuestas
            $table->unsignedBigInteger('id_lote');
            $table->unsignedBigInteger('id_ubicacion');
            $table->integer('cantidad')->nullable();

            // Definir clave primaria compuesta
            $table->primary(['id_lote', 'id_ubicacion']);

            // Llaves foráneas
            $table->foreign('id_lote')
                ->references('id')->on('lotes')
                ->onDelete('cascade');

            $table->foreign('id_ubicacion')
                ->references('id')->on('ubicaciones_almacenamiento')
                ->onDelete('cascade');

            // Agregar timestamps (sin `ON UPDATE CURRENT_TIMESTAMP`)
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable(); // Se actualizará manualmente
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lote_ubicacion');
    }
};
