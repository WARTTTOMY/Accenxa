<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AlumnoAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('alumno_id')) {
            return redirect()->route('alumno.login')
                ->with('error', 'Por favor inicia sesión para acceder a tu perfil.');
        }

        return $next($request);
    }
}