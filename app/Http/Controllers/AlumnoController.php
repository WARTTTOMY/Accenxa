<?php

namespace App\Http\Controllers;

use App\Helpers\ConfigHelper;
use App\Models\Alumno;
use App\Models\Asistencia;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AlumnoController extends Controller
{
    
    public function index()
    {
        $alumnos = Alumno::all();
        return view('alumnos.index', compact('alumnos'));
    }

    public function store(Request $request)
    {
        // Validación con foto incluida
        $request->validate([
            'codigo' => 'required|unique:alumnos,codigo',
            'documento_identidad' => 'nullable|string|max:50',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'carrera' => 'nullable|string|max:255',
            'semestre' => 'nullable|string|max:50',
            'fecha_expiracion' => 'nullable|date',
        ]);

        $alumno = new Alumno();
        $alumno->codigo = $request->codigo;
        $alumno->documento_identidad = $request->documento_identidad;
        $alumno->nombres = $request->nombres;
        $alumno->apellidos = $request->apellidos;
        $alumno->carrera = $request->carrera;
        $alumno->semestre = $request->semestre;
        $alumno->estado = 'activo';
        $alumno->fecha_expiracion = $request->fecha_expiracion;
        
        // Manejar la carga de la foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nombreFoto = time() . '_' . $alumno->codigo . '.' . $foto->getClientOriginalExtension();
            $ruta = $foto->storeAs('fotos_estudiantes', $nombreFoto, 'public');
            $alumno->foto = $ruta;
        }
        
        $alumno->save();

        $alumnos = Alumno::all();

        return response()->json(['alumnos' => $alumnos, 'res' => 'ok']);
    }
    
    public function show(Alumno $alumno)
    {
        return $alumno;
    }

    public function save_record(Request $request)
    {
        $alumno = Alumno::where('codigo', $request->codigo)->first();
        $hoy = Carbon::now()->format('Y-m-d');

        if(!is_null($alumno)):
            $validar = Asistencia::where('alumno_id', $alumno->id)
                                 ->where('fecha', $hoy)
                                 ->get();

            if($validar->count() > 0):
                $res = ['msg' => 'Ya registro asistencia', 'level' => 'warning'];
            else:
                $asistencia = new Asistencia();
                $asistencia->alumno_id = $alumno->id;
                $asistencia->fecha = $hoy;
                $asistencia->save();

                $res = ['msg' => 'Asistencia registrada', 'level' => 'success'];
            endif;
        else:
            $res = ['msg' => 'No se encontro el alumno', 'level' => 'error'];
        endif;

        return response()->json($res);
    }

   
    public function edit(Alumno $alumno)
    {
        //
    }

  
    public function update(Request $request, Alumno $alumno)
    {
        // Validación
        $request->validate([
            'codigo' => 'required|unique:alumnos,codigo,' . $alumno->id,
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
        ]);

        $alumno->codigo = $request->codigo;
        $alumno->nombres = $request->nombres;
        $alumno->apellidos = $request->apellidos;
        $alumno->save();
        
        // Ya no es necesario guardar el QR manualmente
        // El accessor lo genera automáticamente con el nuevo código

        $alumnos = Alumno::all();
        return response()->json(['alumnos' => $alumnos, 'res' => 'ok']);
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();

        $alumnos = Alumno::all();
        return response()->json(['alumnos' => $alumnos, 'res' => 'ok']);
    }
}