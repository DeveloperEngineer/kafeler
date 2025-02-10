<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Paneli')</title>

    @vite(['resources/js/app.js', 'resources/css/app.css'])

</head>
<body class="bg-gray-100">
<div class="container mx-auto mt-6">
    @yield('content')
</div>
</body>
</html>
