<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Kafeler Title Layout')</title>

    @vite(['resurces/js/app.js', 'resources/css/app.css'])

</head>

<body class="bg-gray-100 text-gray-900">
<nav class="bg-blue-500 p-4 text-white">
    <div class="container mx-auto">
        <a href="{{ url('/') }}" class="text-lg font-semibold"> Kafelerr </a>
    </div>
</nav>

<div class="container mx-auto mt-6">
    @yield('content')
</div>

</body>
</html>
