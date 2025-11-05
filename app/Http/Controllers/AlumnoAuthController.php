<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;

class AlumnoAuthController extends Controller
{
    public function showLoginForm()
    {
        // Si ya hay una sesión de alumno activa, redirigir al perfil
        if (Session::has('alumno_id')) {
            return redirect()->route('alumno.perfil');
        }
        return view('alumno-auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'cedula' => 'required'
        ]);

        $alumno = Alumno::where('cedula', $request->cedula)->first();

        if (!$alumno) {
            return back()->withErrors([
                'cedula' => 'No se encontró ningún alumno/trabajador con este número de documento.'
            ])->withInput();
        }

        // Guardar ID del alumno en la sesión
        Session::put('alumno_id', $alumno->id);

        return redirect()->route('alumno.perfil');
    }

    public function perfil()
    {
        $alumno = Alumno::findOrFail(Session::get('alumno_id'));
        return view('alumno-auth.perfil', compact('alumno'));
    }

    public function asistencias()
    {
        $alumno = Alumno::findOrFail(Session::get('alumno_id'));
        $asistencias = Asistencia::where('alumno_id', $alumno->id)
                                ->orderBy('fecha', 'desc')
                                ->paginate(10);
        
        return view('alumno-auth.asistencias', compact('alumno', 'asistencias'));
    }

    public function descargarQR()
    {
        $alumno = Alumno::findOrFail(Session::get('alumno_id'));
        
        // Generar QR code con el número de cédula
        $qrCode = QrCode::size(300)
                       ->errorCorrection('H')
                       ->margin(2)
                       ->generate($alumno->cedula);

        // Crear respuesta con el QR code como SVG
        return response($qrCode)
               ->header('Content-Type', 'image/svg+xml')
               ->header('Content-Disposition', 'attachment; filename="qr-code.svg"');
    }

    public function logout()
    {
        Session::forget('alumno_id');
        return redirect()->route('alumno.login')
            ->with('message', 'Has cerrado sesión correctamente.');
    }
}