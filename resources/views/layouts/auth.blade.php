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
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        
        <style>
            .btn-outline-primary:hover {
                color: white;
            }
            .login-divider {
                position: relative;
                text-align: center;
                margin: 2rem 0;
            }
            .login-divider::before {
                content: "";
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                border-top: 1px solid #dee2e6;
            }
            .login-divider span {
                background: white;
                padding: 0 1rem;
                position: relative;
                color: #6c757d;
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