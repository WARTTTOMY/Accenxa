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
            <div class="row g-0 justify-content-center align-items-center">
                <!-- Columna del scanner QR -->
                <div class="col-lg-6 pe-lg-4">
                    <div class="card shadow-lg" style="border-radius: 15px; overflow: hidden;">
                        <div class="card-body p-4">
                            <div class="text-center mb-3">
                                <h4 class="fw-bold text-primary mb-0">Registro de Asistencia</h4>
                                <small class="text-muted">Escanea tu código QR</small>
                            </div>
                            
                            <!-- Contenedor del scanner -->
                            <div class="scanner-area" style="width: 100%; max-width: 300px; margin: 0 auto;">
                                <div id="reader" class="border rounded" style="width: 100%; aspect-ratio: 1;"></div>
                            </div>

                            <!-- Mensajes de estado -->
                            <div id="scanStatus" class="alert d-none mt-3 mb-0"></div>
                        </div>
                    </div>
                </div>

                <!-- Columna de login para administradores -->
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

    <!-- Scripts para el scanner QR -->
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const html5QrCode = new Html5Qrcode("reader");
            const scanStatus = document.getElementById('scanStatus');
            
            const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                // Detener el scanner después de una lectura exitosa
                html5QrCode.stop();
                
                // Mostrar mensaje de éxito
                scanStatus.classList.remove('d-none', 'alert-danger');
                scanStatus.classList.add('alert-success');
                scanStatus.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando asistencia...';
                
                // Preparar payload: si decodedText es JSON, enviarlo ya parseado; si no, enviar como string
                let payload = {};
                try {
                    payload.qr_data = JSON.parse(decodedText);
                } catch (e) {
                    payload.qr_data = decodedText;
                }

                // Enviar la solicitud al servidor (ruta pública para registrar asistencia)
                fetch('/alumno/registrar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(payload)
                })
                .then(async response => {
                    // Guardar el texto y tipo para manejar respuestas inesperadas (HTML)
                    const text = await response.text();
                    const contentType = response.headers.get('content-type') || '';

                    if (!contentType.includes('application/json')) {
                        // El servidor devolvió HTML o redirección (ej. redirigir a login) -> fallo por motivos de auth u otro
                        throw new Error('Respuesta inesperada del servidor: ' + (text.substring(0, 200)));
                    }

                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (err) {
                        throw new Error('JSON inválido recibido desde el servidor');
                    }

                    return data;
                })
                .then(data => {
                    const msg = data.message || data.msg || '';
                    // Limpiar clases previas de alerta
                    scanStatus.classList.remove('alert-success', 'alert-danger', 'alert-warning');

                    if (data.level === 'success') {
                        scanStatus.classList.add('alert-success');
                        scanStatus.innerHTML = `<i class="fas fa-check-circle me-2"></i>${msg || 'Asistencia registrada'}`;
                        setTimeout(() => {
                            scanStatus.classList.add('d-none');
                            startScanner();
                        }, 3000);
                    } else if (data.level === 'warning') {
                        scanStatus.classList.add('alert-warning');
                        scanStatus.classList.remove('d-none');
                        scanStatus.innerHTML = `<i class=\"fas fa-exclamation-triangle me-2\"></i>${msg || 'Ya registró asistencia'}`;
                        setTimeout(() => {
                            scanStatus.classList.add('d-none');
                            startScanner();
                        }, 2500);
                    } else if (data.success) {
                        // Fallback legacy: tratar como éxito si viene success=true sin level
                        scanStatus.classList.add('alert-success');
                        scanStatus.innerHTML = `<i class="fas fa-check-circle me-2"></i>${msg || 'Asistencia registrada'}`;
                        setTimeout(() => {
                            scanStatus.classList.add('d-none');
                            startScanner();
                        }, 3000);
                    } else {
                        throw new Error(msg || 'No se pudo registrar la asistencia');
                    }
                })
                .catch(error => {
                    scanStatus.classList.remove('alert-success');
                    scanStatus.classList.add('alert-danger');
                    scanStatus.innerHTML = `<i class="fas fa-exclamation-circle me-2"></i>${error.message || 'Error al procesar la asistencia'}`;
                    // Reiniciar el scanner después de 3 segundos
                    setTimeout(() => {
                        scanStatus.classList.add('d-none');
                        startScanner();
                    }, 3000);
                });
            };

            const startScanner = () => {
                html5QrCode.start(
                    { facingMode: "environment" },
                    { fps: 10, qrbox: { width: 250, height: 250 } },
                    qrCodeSuccessCallback,
                    (errorMessage) => {
                        // Manejar errores silenciosamente
                    }
                ).catch((err) => {
                    scanStatus.classList.remove('d-none');
                    scanStatus.classList.add('alert-danger');
                    scanStatus.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>Error al iniciar la cámara';
                });
            };

            // Iniciar el scanner
            startScanner();
        });
    </script>

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

        /* Scanner layout tweaks: keep buttons away and ensure reader on top */
        .scanner-area {
            margin-bottom: 1.5rem; /* espacio debajo del scanner */
        }

        #reader {
            z-index: 10; /* asegurar que la cámara/quadrante esté encima */
            background: #000; /* fondo oscuro ayuda a la cámara en algunos navegadores */
        }

        /* Si tienes un botón de descarga cerca del scanner, aplícale esta clase */
        .btn-download {
            margin-top: 1.5rem !important;
        }
    </style>
@endsection
