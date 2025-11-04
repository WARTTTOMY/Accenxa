<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asistencia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AlumnoController extends Controller
{
    // Listado de alumnos
    public function index()
    {
        $alumnos = Alumno::all();
        return view('alumnos.index', compact('alumnos'));
    }

    // Crear nuevo alumno
    public function store(Request $request)
    {
        $request->validate([
            'cedula' => 'required|unique:alumnos,cedula',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'nullable|email|max:255',
            'rol' => 'required|in:estudiante,trabajador',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $alumno = new Alumno();
        $alumno->cedula = $request->cedula;
        $alumno->nombres = $request->nombres;
        $alumno->apellidos = $request->apellidos;
        $alumno->correo = $request->correo;
        $alumno->rol = $request->rol;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nombreFoto = time() . '_' . $alumno->cedula . '.' . $foto->getClientOriginalExtension();
            $ruta = $foto->storeAs('fotos_estudiantes', $nombreFoto, 'public');
            $alumno->foto = $ruta;
        }

        $alumno->save();

        return response()->json(['alumnos' => Alumno::all(), 'res' => 'ok']);
    }

    // Mostrar un alumno
    public function show(Alumno $alumno)
    {
        try {
            // Generar datos para el QR
            $qrData = [
                'cedula' => $alumno->cedula,
                'nombre' => $alumno->getFullNameAttribute(),
                'rol' => $alumno->rol,
                'id' => $alumno->id
            ];
            
            $data = $alumno->toArray();
            $data['foto_url'] = $alumno->getFotoUrlAttribute();
            $data['qr'] = base64_encode(
                QrCode::format('svg')
                    ->size(300)
                    ->errorCorrection('H')
                    ->margin(1)
                    ->generate(json_encode($qrData))
            );
            $data['full_name'] = $alumno->getFullNameAttribute();
            
            \Log::info('Mostrando alumno:', ['id' => $alumno->id, 'qr_data' => $qrData]);
            
            return response()->json($data);
        } catch (\Exception $e) {
            \Log::error('Error al mostrar alumno:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error al cargar los datos del alumno'], 500);
        }
    }

    // Registrar asistencia
    public function save_record(Request $request)
    {
        try {
            \Log::info('Datos brutos recibidos:', [
                'request_all' => $request->all(),
                'request_content' => $request->getContent(),
                'content_type' => $request->header('Content-Type')
            ]);
            
            // Intentar obtener los datos del cuerpo de la solicitud
            $contenido = $request->getContent();
            
            // Si hay datos en formato JSON en el cuerpo
            if (!empty($contenido)) {
                try {
                    if (is_string($contenido)) {
                        // Si el contenido parece ser una cadena JSON escapada, decodificarla primero
                        if (strpos($contenido, '\\"') !== false) {
                            $contenido = stripslashes($contenido);
                        }
                        $datos = json_decode($contenido, true);
                        if (json_last_error() !== JSON_ERROR_NONE) {
                            throw new \Exception('Error decodificando JSON: ' . json_last_error_msg());
                        }
                    } else {
                        $datos = $contenido;
                    }
                } catch (\Exception $e) {
                    \Log::error('Error procesando contenido:', [
                        'error' => $e->getMessage(),
                        'contenido' => $contenido
                    ]);
                    throw $e;
                }
            } else {
                // Si no hay datos en el cuerpo, intentar obtener del request
                $datos = $request->all();
            }
            
            \Log::info('Datos procesados:', $datos);
        
            $alumno = Alumno::buscarPorQR($datos);
            $hoy = Carbon::now()->format('Y-m-d');

            if(!$alumno) {
                \Log::error('Alumno no encontrado con los datos:', $datos);
                return response()->json(['msg' => 'No se encontró el alumno', 'level' => 'error']);
            }

            $validar = Asistencia::where('alumno_id', $alumno->id)
                                ->where('fecha', $hoy)
                                ->first();

            if($validar) {
                return response()->json(['msg' => 'Ya registró asistencia', 'level' => 'warning']);
            }

            Asistencia::create([
                'alumno_id' => $alumno->id,
                'fecha' => $hoy,
            ]);
            
            \Log::info('Asistencia registrada para alumno:', [
                'alumno_id' => $alumno->id,
                'cedula' => $alumno->cedula,
                'nombre' => $alumno->full_name,
                'fecha' => $hoy
            ]);
            
            return response()->json([
                'msg' => 'Asistencia registrada para ' . $alumno->full_name,
                'level' => 'success',
                'alumno' => [
                    'nombre' => $alumno->full_name,
                    'rol' => $alumno->rol,
                    'cedula' => $alumno->cedula
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error al procesar asistencia:', [
                'error' => $e->getMessage(),
                'datos' => $request->all()
            ]);
            return response()->json(['msg' => 'Error al procesar la asistencia', 'level' => 'error']);
        }
    }

    // Actualizar alumno
    public function update(Request $request, Alumno $alumno)
    {
        $request->validate([
            'cedula' => 'required|unique:alumnos,cedula,' . $alumno->id,
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'nullable|email|max:255',
            'rol' => 'required|in:estudiante,trabajador',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $alumno->cedula = $request->cedula;
        $alumno->nombres = $request->nombres;
        $alumno->apellidos = $request->apellidos;
        $alumno->correo = $request->correo;
        $alumno->rol = $request->rol;

        if ($request->hasFile('foto')) {
            if ($alumno->foto && \Storage::disk('public')->exists($alumno->foto)) {
                \Storage::disk('public')->delete($alumno->foto);
            }

            $foto = $request->file('foto');
            $nombreFoto = time() . '_' . $alumno->cedula . '.' . $foto->getClientOriginalExtension();
            $ruta = $foto->storeAs('fotos_estudiantes', $nombreFoto, 'public');
            $alumno->foto = $ruta;
        }

        $alumno->save();

        return response()->json(['alumnos' => Alumno::all(), 'res' => 'ok', 'msg' => 'Estudiante actualizado correctamente']);
    }

    // Eliminar alumno
    public function destroy(Alumno $alumno)
    {
        if ($alumno->foto && \Storage::disk('public')->exists($alumno->foto)) {
            \Storage::disk('public')->delete($alumno->foto);
        }

        $alumno->delete();

        return response()->json(['alumnos' => Alumno::all(), 'res' => 'ok']);
    }
}