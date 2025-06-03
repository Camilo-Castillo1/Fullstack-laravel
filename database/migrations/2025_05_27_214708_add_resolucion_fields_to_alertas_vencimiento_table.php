<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('alertas_vencimiento', function (Blueprint $table) {
        $table->text('observacion')->nullable()->after('estado');
        $table->unsignedBigInteger('resuelta_por')->nullable()->after('observacion');
        $table->timestamp('fecha_resolucion')->nullable()->after('resuelta_por');

        $table->foreign('resuelta_por')->references('id')->on('users')->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('alertas_vencimiento', function (Blueprint $table) {
        $table->dropForeign(['resuelta_por']);
        $table->dropColumn(['observacion', 'resuelta_por', 'fecha_resolucion']);
    });
}

};
