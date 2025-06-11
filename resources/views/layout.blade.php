<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.app_name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="text-end mb-3">
            <select onchange="window.location.href='/lang/' + this.value;">
                <option value="en" {{ App::getLocale() == 'en' ? 'selected' : '' }}>English</option>
                <option value="es" {{ App::getLocale() == 'es' ? 'selected' : '' }}>Español</option>
            </select>

        </div>

        <h1 class="mb-4 text-center">{{ __('messages.app_name') }}</h1>

        @yield('content')
    </div>
</body>

</html>
