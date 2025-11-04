<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asistencia;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function index()
    {
        // Obtener asistencias con su alumno
        $asistencias = Asistencia::with('alumno')
            ->latest('fecha')
            ->get()
            ->map(function ($a) {
                if (!$a->alumno) return null;

                return [
                    'codigo'     => $a->alumno->codigo,
                    'full_name'  => $a->alumno->full_name,
                    'fecha'      => $a->fecha,
                ];
            })
            ->filter();

        // Listado de alumnos activos
        $alumnos = Alumno::where('estado', 'activo')->get();

        return view('asistencias.index', compact('asistencias', 'alumnos'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Asistencia $asistencia)
    {
        //
    }

    public function edit(Asistencia $asistencia)
    {
        //
    }

    public function update(Request $request, Asistencia $asistencia)
    {
        //
    }

    public function destroy(Asistencia $asistencia)
    {
        //
    }
}
