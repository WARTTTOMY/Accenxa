<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SimplificarEstructuraAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            // Eliminar campos que no necesitamos
            $table->dropColumn([
                'documento_identidad',
                'carrera',
                'semestre',
                'estado',
                'fecha_expiracion'
            ]);
            
            // Renombrar codigo a cedula
            $table->renameColumn('codigo', 'cedula');
            
            // Agregar nuevos campos
            $table->string('correo')->nullable()->after('apellidos');
            $table->enum('rol', ['estudiante', 'trabajador'])->default('estudiante')->after('correo');
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
            // Restaurar campos eliminados
            $table->string('documento_identidad')->nullable();
            $table->string('carrera')->nullable();
            $table->string('semestre')->nullable();
            $table->enum('estado', ['activo', 'inactivo', 'suspendido'])->default('activo');
            $table->date('fecha_expiracion')->nullable();
            
            // Renombrar cedula de vuelta a codigo
            $table->renameColumn('cedula', 'codigo');
            
            // Eliminar nuevos campos
            $table->dropColumn(['correo', 'rol']);
        });
    }
};