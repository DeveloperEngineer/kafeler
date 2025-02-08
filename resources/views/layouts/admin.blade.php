<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin Paneli')</title>

    @vite(['resources/js/app.js', 'resources/css/app.css'])

</head>
<body class="bg-gray-100 text-gray-900">
<div class="flex">
    <aside class="w-64 bg-gray-800 text-white h-screen">
        <h2 class="text-xl font-bold">Admin Paneli</h2>
        <ul class="mt-4">
            <li class="mb-2"><a href="#" class="block p-2 bg-gray-700 rounded">Dashboard</a></li>
            <li class="mb-2"><a href="#" class="block p-2 bg-gray-700 rounded">Kategoriler</a></li>
            <li class="mb-2"><a href="#" class="block p-2 bg-gray-700 rounded">Ürünler</a></li>
        </ul>

    </aside>

    <main class="flex-1 p-6">
        @yield('content')
    </main>

</div>
</body>
</html>
