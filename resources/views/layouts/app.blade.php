<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - TripMate</title>

    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    @include('components.header')
    
    <main class="min-h-screen">
        @yield('content')
    </main>


    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
