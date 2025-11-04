@extends('layouts.alumno-auth')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">Acceso Portal</h4>
                </div>
                
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-graduate fa-3x text-primary mb-3"></i>
                        <p class="text-muted">Ingresa con tu número de documento</p>
                    </div>

                    @if(session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('alumno.login.submit') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="cedula" class="form-label">Número de Documento</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-id-card"></i>
                                </span>
                                <input type="text" class="form-control @error('cedula') is-invalid @enderror" 
                                       id="cedula" name="cedula" value="{{ old('cedula') }}" 
                                       placeholder="Ingresa tu documento">
                            </div>
                            @error('cedula')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt"></i> Ingresar
                            </button>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-home"></i> Volver al Inicio
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection