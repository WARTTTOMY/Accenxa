<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

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
        
        // Generar PDF con el QR y datos del alumno
        $pdf = Pdf::loadView('alumno-auth.qr-pdf', compact('alumno'))
                  ->setPaper('a4', 'portrait')
                  ->setOption('isHtml5ParserEnabled', true)
                  ->setOption('isRemoteEnabled', true);
        
        return $pdf->download('mi-codigo-qr-' . $alumno->cedula . '.pdf');
    }

    public function logout()
    {
        Session::forget('alumno_id');
        return redirect()->route('alumno.login')
            ->with('message', 'Has cerrado sesión correctamente.');
    }
}