@extends('layouts.auth')

@section('titulo')
    Ingresar
@endsection

@section('menu_select')
    {{ $select = 'login' }}
@endsection

@section('contenido')
    <section class="min-vh-100 d-flex align-items-center">
        <div class="container py-5">
            <div class="row g-0 justify-content-center">
                <div class="col-lg-5">
                    <!-- Tarjeta de login para administradores -->
                    <div class="card shadow-lg" style="border-radius: 15px; overflow: hidden;">
                        <div class="card-body p-5">
                            <div class="text-center mb-5">
                                <div class="mb-4">
                                    <img src="{{ asset('admin/img/login.jpeg') }}" 
                                         class="img-fluid rounded-circle" 
                                         style="width: 100px; height: 100px; object-fit: cover;" 
                                         alt="login">
                                </div>
                                <h2 class="fw-bold text-primary">Panel de Control</h2>
                                <p class="text-muted">Acceso para administradores del sistema</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <!-- Email input -->
                                <div class="form-floating mb-4">
                                    <input type="email" 
                                           name="email" 
                                           id="correo" 
                                           class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           placeholder="Correo electrónico" />
                                    <label for="correo">
                                        <i class="fas fa-envelope me-2"></i>Correo Electrónico
                                    </label>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Password input -->
                                <div class="form-floating mb-4">
                                    <input type="password" 
                                           name="password" 
                                           id="password" 
                                           class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           placeholder="Contraseña" />
                                    <label for="password">
                                        <i class="fas fa-lock me-2"></i>Contraseña
                                    </label>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" />
                                        <label class="form-check-label" for="remember">
                                            Recordarme
                                        </label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="text-primary text-decoration-none">
                                        <i class="fas fa-key me-2"></i>¿Olvidaste tu contraseña?
                                    </a>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 mb-4">
                                    <i class="fas fa-sign-in-alt me-2"></i>Ingresar como Administrador
                                </button>
                            </form>

                            <!-- Separador -->
                            <div class="position-relative my-4">
                                <hr>
                                <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted">
                                    o
                                </span>
                            </div>

                            <!-- Botón portal estudiantes/trabajadores -->
                            <div class="text-center">
                                <a href="{{ route('alumno.login') }}" class="btn btn-outline-primary btn-lg w-100">
                                    <i class="fas fa-user-graduate me-2"></i>Portal de Estudiantes/Trabajadores
                                </a>
                                <p class="text-muted mt-3 small">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Accede con tu número de documento
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        body {
            background-color: var(--background-color);
            background-image: 
                linear-gradient(to bottom right, rgba(44, 62, 80, 0.1) 0%, rgba(52, 152, 219, 0.1) 100%),
                radial-gradient(rgba(52, 152, 219, 0.1) 1px, transparent 1px);
            background-size: cover, 20px 20px;
        }

        .form-floating > label {
            padding-left: 1.5rem;
        }

        .form-floating > .form-control {
            padding-left: 1.5rem;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
        }
    </style>
@endsection
