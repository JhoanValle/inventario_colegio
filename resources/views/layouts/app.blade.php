<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario AIP</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    @auth
        @include('layouts.sidebar')
    @endauth

    @include('layouts.navbar')

    <div class="content">
        @yield('content')
    </div>

    <footer class="text-center mt-4 mb-2 text-muted footer">
        <hr>

        <small>
            Sistema de Inventario AIP © {{ date('Y') }}
            <br>

            Institución Educativa <strong>Nuestra Señora del Pilar</strong>
        </small>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>