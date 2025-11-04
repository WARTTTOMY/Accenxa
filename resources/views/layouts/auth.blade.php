<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <title>Control Asistencia - @yield('titulo')</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('admin/img/favicon.ico') }}" />
    
        <link rel="stylesheet" href="{{ asset('admin/plugins/dataTables/datatables.min.css') }}">
        <!-- CSS -->
        <link rel="stylesheet" href="{{asset('admin/css/auth.css')}}">
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        
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
                min-height: 100vh;
                background-color: var(--background-color);
            }

            .btn {
                font-weight: 500;
                padding: 0.6rem 1.2rem;
                border-radius: 8px;
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

            .btn-outline-primary {
                color: var(--secondary-color);
                border-color: var(--secondary-color);
            }

            .btn-outline-primary:hover {
                background-color: var(--secondary-color);
                border-color: var(--secondary-color);
                color: white;
                transform: translateY(-2px);
            }

            .form-control:focus {
                border-color: var(--secondary-color);
                box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
            }

            .text-primary {
                color: var(--secondary-color) !important;
            }

            .bg-primary {
                background-color: var(--primary-color) !important;
            }

            .card {
                border: none;
                border-radius: 15px;
                box-shadow: var(--card-shadow);
            }

            .invalid-feedback {
                font-size: 0.875em;
                margin-top: 0.5rem;
            }
        </style>
    
    </head>
<body>
    <main class="py-4">
        <div class="container">
            @yield('contenido')
        </div>
    </main>
    <!-- JQuery -->
    <script src="{{ asset('admin/plugins/JQuery/jquery.min.js')}}"></script>
</body>
</html>