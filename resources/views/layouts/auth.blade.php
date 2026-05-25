<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Veterinaria">
    <meta name="author" content="">

    <title>Veterinaria - @yield('title', 'Acceso')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('Plantilla7u7/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('Plantilla7u7/css/sb-admin-2.min.css') }}" rel="stylesheet">
    
    <!-- Custom Minimalist Purple Theme -->
    <link href="{{ asset('css/custom-theme.css') }}" rel="stylesheet">
    
    @yield('styles')
</head>
<body class="bg-gradient-primary">
    <div class="container">
        @yield('content')
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('Plantilla7u7/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('Plantilla7u7/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('Plantilla7u7/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('Plantilla7u7/js/sb-admin-2.min.js') }}"></script>
    @yield('scripts')
</body>
</html>
