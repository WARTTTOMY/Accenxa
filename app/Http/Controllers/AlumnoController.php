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
            
            // Obtener datos preferentemente como JSON (sin manipular comillas)
            $datos = $request->isJson() ? $request->json()->all() : $request->all();
            
            // Si el payload viene como { qr_data: "...json..." }, desanidar y decodificar
            if (is_array($datos) && array_key_exists('qr_data', $datos)) {
                $inner = $datos['qr_data'];
                if (is_string($inner)) {
                    $decoded = json_decode($inner, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $datos = $decoded;
                    } else {
                        // Si no se pudo decodificar, mantener como string y seguir; buscarPorQR maneja string
                        $datos = $inner;
                    }
                } elseif (is_array($inner)) {
                    $datos = $inner;
                } else {
                    $datos = $inner; // dejar tal cual
                }
            }

            \Log::info('Datos procesados:', $datos);
        
            $alumno = Alumno::buscarPorQR($datos);
            $hoy = Carbon::now()->format('Y-m-d');

            if(!$alumno) {
                \Log::error('Alumno no encontrado con los datos:', $datos);
                return response()->json(['success' => false, 'msg' => 'No se encontró el alumno', 'level' => 'error']);
            }

            // Buscar el último registro de hoy
            $ultimoRegistroHoy = Asistencia::where('alumno_id', $alumno->id)
                                ->where('fecha', $hoy)
                                ->orderBy('created_at', 'desc')
                                ->first();

            $ahora = Carbon::now()->format('H:i:s');

            // Determinar el tipo del nuevo registro
            if (!$ultimoRegistroHoy) {
                // No hay registros hoy, crear entrada
                $tipo = 'entrada';
                $mensaje = 'Bienvenid@ ' . $alumno->full_name;
            } else {
                // Ya hay registros hoy, alternar tipo
                if ($ultimoRegistroHoy->tipo === 'entrada') {
                    $tipo = 'salida';
                    $mensaje = 'Salida registrada, hasta luego ' . $alumno->full_name;
                } else {
                    $tipo = 'entrada';
                    $mensaje = 'Bienvenid@ de nuevo ' . $alumno->full_name;
                }
            }

            // Crear el nuevo registro
            Asistencia::create([
                'alumno_id' => $alumno->id,
                'fecha' => $hoy,
                'tipo' => $tipo,
                'hora' => $ahora,
            ]);

            \Log::info('Asistencia registrada:', [
                'alumno_id' => $alumno->id,
                'cedula' => $alumno->cedula,
                'nombre' => $alumno->full_name,
                'fecha' => $hoy,
                'tipo' => $tipo,
                'hora' => $ahora
            ]);

            return response()->json([
                'success' => true,
                'msg' => $mensaje,
                'level' => 'success',
                'tipo' => $tipo,
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
            return response()->json(['success' => false, 'msg' => 'Error al procesar la asistencia', 'level' => 'error']);
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