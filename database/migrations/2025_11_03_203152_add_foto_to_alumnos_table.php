<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            // Agregar campo para almacenar la ruta de la foto
            $table->string('foto')->nullable()->after('apellidos');
            
            // Campos adicionales que serán útiles para el sistema de acceso
            $table->string('documento_identidad')->nullable()->after('codigo');
            $table->string('carrera')->nullable()->after('foto');
            $table->string('semestre')->nullable()->after('carrera');
            $table->enum('estado', ['activo', 'inactivo', 'suspendido'])->default('activo')->after('semestre');
            $table->date('fecha_expiracion')->nullable()->after('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropColumn([
                'foto',
                'documento_identidad',
                'carrera',
                'semestre',
                'estado',
                'fecha_expiracion'
            ]);
        });
    }
};