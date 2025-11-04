<?php

namespace App\Http\Controllers;

use App\Helpers\ConfigHelper;
use App\Models\Alumno;
use App\Models\Asistencia;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AlumnoController extends Controller
{
    
    public function index()
    {
        $alumnos = Alumno::all();
        return view('alumnos.index', compact('alumnos'));
    }

    public function store(Request $request)
    {
        try {
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
            $alumno->codigo = trim($request->codigo);
            $alumno->documento_identidad = $request->documento_identidad ? trim($request->documento_identidad) : null;
            $alumno->nombres = trim($request->nombres);
            $alumno->apellidos = trim($request->apellidos);
            $alumno->carrera = $request->carrera ? trim($request->carrera) : null;
            $alumno->semestre = $request->semestre ? trim($request->semestre) : null;
            $alumno->estado = 'activo';
            $alumno->fecha_expiracion = $request->fecha_expiracion;
            
            // Manejar la carga de la foto
            if ($request->hasFile('foto')) {
                try {
                    $foto = $request->file('foto');
                    $nombreFoto = time() . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $alumno->codigo) . '.' . $foto->getClientOriginalExtension();
                    $ruta = $foto->storeAs('fotos_estudiantes', $nombreFoto, 'public');
                    $alumno->foto = $ruta;
                } catch (\Exception $e) {
                    Log::error('Error al guardar foto: ' . $e->getMessage());
                    // Continuar sin foto si hay error
                }
            }
            
            $alumno->save();

            $alumnos = Alumno::all();

            return response()->json(['alumnos' => $alumnos, 'res' => 'ok']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'alumnos' => Alumno::all(),
                'res' => 'error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al crear alumno: ' . $e->getMessage());
            return response()->json([
                'alumnos' => Alumno::all(),
                'res' => 'error',
                'msg' => 'Error al crear el estudiante'
            ], 500);
        }
    }
    
    public function show(Alumno $alumno)
    {
        return $alumno;
    }

    public function save_record(Request $request)
    {
        try {
            // Validar que se recibió el código
            $request->validate([
                'codigo' => 'required|string'
            ]);

            $codigo = $request->codigo;
            $hoy = Carbon::now()->format('Y-m-d');

            // Buscar el alumno por código
            $alumno = Alumno::where('codigo', $codigo)->first();

            if (is_null($alumno)) {
                return response()->json([
                    'msg' => 'Código no válido - Estudiante no encontrado',
                    'level' => 'error'
                ], 404);
            }

            // Verificar si el carnet está activo
            if (!$alumno->isActivo()) {
                return response()->json([
                    'msg' => 'Carnet no válido o expirado',
                    'level' => 'error'
                ], 403);
            }

            // Verificar si ya registró asistencia hoy
            $asistenciaExistente = Asistencia::where('alumno_id', $alumno->id)
                                             ->where('fecha', $hoy)
                                             ->first();

            if ($asistenciaExistente) {
                return response()->json([
                    'msg' => 'Ya registró asistencia hoy',
                    'level' => 'warning'
                ]);
            }

            // Registrar la asistencia
            $asistencia = new Asistencia();
            $asistencia->alumno_id = $alumno->id;
            $asistencia->fecha = $hoy;
            $asistencia->save();

            return response()->json([
                'msg' => 'Asistencia registrada correctamente - ' . $alumno->nombres . ' ' . $alumno->apellidos,
                'level' => 'success'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'msg' => 'Error de validación: ' . $e->getMessage(),
                'level' => 'error'
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error al registrar asistencia: ' . $e->getMessage());
            return response()->json([
                'msg' => 'Error al procesar la solicitud',
                'level' => 'error'
            ], 500);
        }
    }

   
    public function edit(Alumno $alumno)
    {
        //
    }

  
    public function update(Request $request, Alumno $alumno)
    {
        try {
            // Validación
            $request->validate([
                'codigo' => 'required|unique:alumnos,codigo,' . $alumno->id,
                'documento_identidad' => 'nullable|string|max:50',
                'nombres' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'carrera' => 'nullable|string|max:255',
                'semestre' => 'nullable|string|max:50',
                'fecha_expiracion' => 'nullable|date',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $alumno->codigo = trim($request->codigo);
            $alumno->documento_identidad = $request->documento_identidad ? trim($request->documento_identidad) : null;
            $alumno->nombres = trim($request->nombres);
            $alumno->apellidos = trim($request->apellidos);
            $alumno->carrera = $request->carrera ? trim($request->carrera) : null;
            $alumno->semestre = $request->semestre ? trim($request->semestre) : null;
            $alumno->fecha_expiracion = $request->fecha_expiracion;
            
            // Manejar la carga de la foto si se proporciona
            if ($request->hasFile('foto')) {
                try {
                    // Eliminar foto anterior si existe
                    if ($alumno->foto && Storage::disk('public')->exists($alumno->foto)) {
                        Storage::disk('public')->delete($alumno->foto);
                    }
                    
                    $foto = $request->file('foto');
                    $nombreFoto = time() . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $alumno->codigo) . '.' . $foto->getClientOriginalExtension();
                    $ruta = $foto->storeAs('fotos_estudiantes', $nombreFoto, 'public');
                    $alumno->foto = $ruta;
                } catch (\Exception $e) {
                    Log::error('Error al actualizar foto: ' . $e->getMessage());
                    // Continuar sin actualizar foto si hay error
                }
            }
            
            $alumno->save();
            
            // Ya no es necesario guardar el QR manualmente
            // El accessor lo genera automáticamente con el nuevo código

            $alumnos = Alumno::all();
            return response()->json(['alumnos' => $alumnos, 'res' => 'ok']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'alumnos' => Alumno::all(),
                'res' => 'error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al actualizar alumno: ' . $e->getMessage());
            return response()->json([
                'alumnos' => Alumno::all(),
                'res' => 'error',
                'msg' => 'Error al actualizar el estudiante'
            ], 500);
        }
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();

        $alumnos = Alumno::all();
        return response()->json(['alumnos' => $alumnos, 'res' => 'ok']);
    }
}