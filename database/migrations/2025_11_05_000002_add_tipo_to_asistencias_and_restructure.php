<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            // Agregar columna tipo (entrada/salida)
            $table->enum('tipo', ['entrada', 'salida'])->default('entrada')->after('fecha');
            
            // Cambiar hora_entrada a hora (genérica)
            $table->renameColumn('hora_entrada', 'hora');
            
            // Eliminar hora_salida ya que cada registro será independiente
            $table->dropColumn('hora_salida');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->dropColumn('tipo');
            $table->renameColumn('hora', 'hora_entrada');
            $table->time('hora_salida')->nullable();
        });
    }
};
