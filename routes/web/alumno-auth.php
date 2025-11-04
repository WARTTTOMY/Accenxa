<?php

use App\Http\Controllers\AlumnoAuthController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/alumno/login', [AlumnoAuthController::class, 'showLoginForm'])
    ->name('alumno.login')
    ->middleware('guest');

Route::post('/alumno/login', [AlumnoAuthController::class, 'login'])
    ->name('alumno.login.submit');

// Rutas protegidas
Route::middleware(['alumno.auth'])->group(function () {
    Route::get('/alumno/perfil', [AlumnoAuthController::class, 'perfil'])
        ->name('alumno.perfil');
    
    Route::get('/alumno/asistencias', [AlumnoAuthController::class, 'asistencias'])
        ->name('alumno.asistencias');
    
    Route::get('/alumno/descargar-qr', [AlumnoAuthController::class, 'descargarQR'])
        ->name('alumno.descargar-qr');
    
    Route::post('/alumno/logout', [AlumnoAuthController::class, 'logout'])
        ->name('alumno.logout');
});