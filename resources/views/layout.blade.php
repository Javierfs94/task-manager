<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestor de Tareas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="text-end mb-3">
            <a href="{{ route('lang.switch', 'es') }}">🇪🇸 Español</a> |
            <a href="{{ route('lang.switch', 'en') }}">🇬🇧 English</a>
        </div>

        <h1 class="mb-4 text-center">{{ __('messages.app_name') }}</h1>

        {{-- @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif --}}

        @yield('content')
    </div>
</body>

</html>
