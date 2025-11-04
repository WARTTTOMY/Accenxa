<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $alumno->full_name ?? 'Portal de Alumnos' }} - Sistema de Asistencia</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --background-color: #ecf0f1;
            --text-color: #2c3e50;
            --light-text: #95a5a6;
            --success-color: #27ae60;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --hover-transition: all 0.3s ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--text-color);
        }

        .navbar {
            background-color: var(--primary-color) !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.4rem;
        }

        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: var(--hover-transition);
        }

        .nav-link:hover {
            color: var(--secondary-color) !important;
            transform: translateY(-2px);
        }

        .main-content {
            flex: 1;
            padding: 2rem 0;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: var(--hover-transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            border-bottom: none;
            background-color: white;
            padding: 1.5rem;
            border-radius: 12px 12px 0 0 !important;
        }

        .btn {
            border-radius: 8px;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            transition: var(--hover-transition);
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

        .btn-danger {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .footer {
            padding: 1.5rem 0;
            background-color: var(--primary-color);
            color: white;
            margin-top: auto;
        }

        .alert {
            border: none;
            border-radius: 8px;
            padding: 1rem 1.5rem;
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            border: none;
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            border: 1px solid #dee2e6;
            transition: var(--hover-transition);
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .profile-container {
            background: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
        }

        .qr-container {
            background: var(--background-color);
            border-radius: 12px;
            padding: 2rem;
        }

        .profile-image {
            border: 4px solid white;
            box-shadow: var(--card-shadow);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('alumno.perfil') }}">
                <i class="fas fa-graduation-cap"></i> Portal de Alumnos
            </a>
            @auth
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('alumno.perfil') ? 'active' : '' }}" 
                               href="{{ route('alumno.perfil') }}">
                                <i class="fas fa-user"></i> Mi Perfil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('alumno.asistencias') ? 'active' : '' }}" 
                               href="{{ route('alumno.asistencias') }}">
                                <i class="fas fa-clock"></i> Mis Asistencias
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('alumno.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn nav-link border-0">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </nav>

    <div class="main-content">
        @if(session('message'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="footer text-center">
        <div class="container">
            <span>Sistema de Asistencia &copy; {{ date('Y') }}</span>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>