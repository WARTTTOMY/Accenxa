@extends('layouts.alumno-auth')

@section('content')
<div class="container py-4">
    <div class="profile-container p-4">
        <!-- Encabezado del Perfil -->
        <div class="row align-items-center mb-5">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="position-relative">
                        <img src="{{ $alumno->foto_url }}" alt="Foto de perfil" class="profile-image" style="width: 120px; height: 120px;">
                        <div class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2" 
                             style="width: 30px; height: 30px; transform: translate(20%, 20%);">
                            <i class="fas fa-check text-white"></i>
                        </div>
                    </div>
                    <div class="ms-4">
                        <h2 class="mb-1 fw-bold">{{ $alumno->full_name }}</h2>
                        <p class="text-muted mb-2">
                            <i class="fas fa-id-card me-2"></i>{{ $alumno->cedula }}
                        </p>
                        <span class="badge bg-primary">
                            <i class="fas {{ $alumno->rol == 'estudiante' ? 'fa-user-graduate' : 'fa-user-tie' }} me-2"></i>
                            {{ ucfirst($alumno->rol) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('alumno.asistencias') }}" class="btn btn-primary mb-2 mb-md-0">
                    <i class="fas fa-clock me-2"></i>Mis Asistencias
                </a>
                <form action="{{ route('alumno.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>

        <!-- Sección QR y Datos -->
        <div class="row">
            <!-- Columna QR -->
            <div class="col-md-5">
                <div class="qr-container text-center">
                    <div class="d-inline-block mb-3">
                        <img src="data:image/svg+xml;base64,{{ $alumno->qr }}" 
                             alt="Código QR de {{ $alumno->full_name }}"
                             style="max-width: 250px;">
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('alumno.descargar-qr') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-download me-2"></i>Descargar QR
                        </a>
                    </div>
                    <h4 class="fw-bold mb-3 mt-4">
                        <i class="fas fa-qrcode me-2 text-primary"></i>Mi Código QR
                    </h4>
                    <p class="text-muted">Usa este código para registrar tu asistencia de forma rápida y segura</p>
                </div>
            </div>

            <!-- Columna Información -->
            <div class="col-md-7">
                <div class="card h-100">
                    <div class="card-header">
                        <h4 class="mb-0 fw-bold text-primary">
                            <i class="fas fa-user-circle me-2"></i>Información Personal
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: var(--background-color);">
                                    <small class="text-muted d-block mb-1">Nombre Completo</small>
                                    <span class="fw-500 fs-5">{{ $alumno->full_name }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: var(--background-color);">
                                    <small class="text-muted d-block mb-1">Documento</small>
                                    <span class="fw-500 fs-5">{{ $alumno->cedula }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: var(--background-color);">
                                    <small class="text-muted d-block mb-1">Correo Electrónico</small>
                                    <span class="fw-500 fs-5">{{ $alumno->correo ?: 'No registrado' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: var(--background-color);">
                                    <small class="text-muted d-block mb-1">Tipo de Usuario</small>
                                    <span class="fw-500 fs-5">{{ ucfirst($alumno->rol) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .qr-container {
        text-align: center;
        margin: 20px 0;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
    }
    .qr-container img {
        max-width: 300px;
        height: auto;
    }
    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
    }
    .profile-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 20px;
    }
</style>
@endpush