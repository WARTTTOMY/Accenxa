@extends('layouts.alumno-auth')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="text-center mb-5">
                <i class="fas fa-qrcode fa-3x text-primary mb-3" 
                   style="background: white; padding: 20px; border-radius: 50%; box-shadow: var(--card-shadow);"></i>
                <h2 class="fw-bold text-white mb-0">Portal de Asistencia</h2>
                <p class="text-white-50">Accede con tu documento de identidad</p>
            </div>

            <div class="card" style="backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                <div class="card-body p-4">
                    @if(session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('alumno.login.submit') }}" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-floating mb-4">
                            <input type="text" 
                                   class="form-control form-control-lg @error('cedula') is-invalid @enderror" 
                                   id="cedula" 
                                   name="cedula" 
                                   value="{{ old('cedula') }}" 
                                   placeholder="Ingresa tu documento"
                                   required>
                            <label for="cedula">
                                <i class="fas fa-id-card me-2"></i>Número de Documento
                            </label>
                            @error('cedula')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Acceder
                            </button>
                            <a href="{{ url('/') }}" class="btn btn-link text-muted">
                                <i class="fas fa-arrow-left me-2"></i>Volver al Inicio
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Ayuda rápida -->
            <div class="card mt-4" style="backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.9);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle text-primary me-3 fa-2x"></i>
                        <div>
                            <h6 class="mb-1 fw-bold">¿Necesitas ayuda?</h6>
                            <p class="mb-0 small text-muted">
                                Contacta con el departamento de sistemas si tienes problemas para acceder.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fondo con patrón de puntos -->
<style>
    body {
        background-color: var(--primary-color) !important;
        background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
        background-size: 20px 20px;
    }
    .navbar, .footer {
        display: none;
    }
</style>
@endsection