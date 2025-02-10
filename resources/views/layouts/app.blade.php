<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Kafeler Title Layout')</title>

    @vite(['resources/js/app.js', 'resources/css/app.css'])

</head>

<body class="bg-gray-100 text-gray-900">
<nav class="bg-gray-800 p-4 text-white flex justify-between">
    <div>
        <a href="{{ route('home') }}" class="text-lg font-bold">Kafeler</a>
    </div>

    <div>
        @auth
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-500 px-4 py-2 rounded hover:bg-red-600 transition">
                    Çıkış Yap
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 transition">Giriş</a>
            <a href="{{ route('register.form') }}" class="bg-green-500 px-4 py-2 rounded hover:bg-green-600 transition ml-2">Kayıt Ol</a>
        @endauth
    </div>
</nav>


<div class="container mx-auto mt-6">
    @yield('content')
</div>


@if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Başarılı!',
                text: 'İşlem tamamlandı.',
                icon: 'success',
                confirmButtonText: 'Tamam'
            });
        });
    </script>
@endif

@if ($errors->any())

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Hata!',
                text: '{{ $errors->first() }}',
                icon: 'error',
                confirmButtonText: 'Tamam'
            });
        });
    </script>
@endif
</body>
</html>
