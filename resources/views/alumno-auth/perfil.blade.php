@extends('layouts.alumno-auth')

@section('content')
<div class="container py-4">
    <div class="profile-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Mi Perfil</h2>
            <div>
                <a href="{{ route('alumno.asistencias') }}" class="btn btn-info me-2">
                    <i class="fas fa-clock"></i> Mis Asistencias
                </a>
                <form action="{{ route('alumno.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>

        <div class="profile-header">
            <img src="{{ $alumno->foto_url }}" alt="Foto de perfil" class="profile-image">
            <div>
                <h3>{{ $alumno->full_name }}</h3>
                <p class="text-muted mb-0">{{ ucfirst($alumno->rol) }}</p>
                <p class="mb-0">Documento: {{ $alumno->cedula }}</p>
            </div>
        </div>

        <div class="qr-container">
            <h4 class="mb-3">Mi Código QR</h4>
            <div class="mb-3">
                <img src="data:image/svg+xml;base64,{{ $alumno->qr }}" 
                     alt="Código QR de {{ $alumno->full_name }}">
            </div>
            <div class="mt-3">
                <a href="{{ route('alumno.descargar-qr') }}" class="btn btn-primary">
                    <i class="fas fa-download"></i> Descargar Código QR
                </a>
            </div>
            <p class="text-muted mt-2">Este es tu código QR personal para registrar asistencia</p>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Información Personal</h5>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Nombre Completo</dt>
                    <dd class="col-sm-9">{{ $alumno->full_name }}</dd>

                    <dt class="col-sm-3">Documento</dt>
                    <dd class="col-sm-9">{{ $alumno->cedula }}</dd>

                    <dt class="col-sm-3">Correo</dt>
                    <dd class="col-sm-9">{{ $alumno->correo ?: 'No registrado' }}</dd>

                    <dt class="col-sm-3">Tipo</dt>
                    <dd class="col-sm-9">{{ ucfirst($alumno->rol) }}</dd>
                </dl>
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