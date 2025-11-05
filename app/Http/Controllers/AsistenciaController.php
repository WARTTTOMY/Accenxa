<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asistencia;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    
    public function index()
    {
        $asistencias = Asistencia::with('alumno')
            ->orderBy('fecha', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($a) {
                $alumno = $a->alumno; // puede ser null si el alumno fue eliminado
                return  [
                    'cedula' => $alumno?->cedula ?? '(sin cédula)',
                    'codigo' => $alumno?->codigo ?? '(sin código)',
                    'full_name' => $alumno?->full_name ?? '(Alumno eliminado)',
                    'fecha' => date('Y-m-d', strtotime($a->fecha)),
                    'tipo' => ucfirst($a->tipo),
                    'hora' => $a->hora ? date('H:i', strtotime($a->hora)) : null,
                ];
            });

        $alumnos = Alumno::all();
        return view('asistencias.index',compact('asistencias','alumnos'));
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
