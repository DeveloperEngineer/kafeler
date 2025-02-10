@extends('layouts.app')

@section('content')
    @if(auth()->check())
        <script>window.location.href = "{{ route('admin.dashboard') }}";</script>
    @endif
    <div class="flex items-center justify-center min-h-screen bg-gray-50">
        <div class="w-72 bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold text-center mb-4 text-gray-800">Giriş Yap</h2>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-gray-700 font-medium mb-1">E-Posta</label>
                    <input type="email" name="email" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Şifre</label>
                    <input type="password" name="password" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    <label class="text-gray-700 text-sm">Beni Hatırla</label>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                    Giriş Yap
                </button>
            </form>

            <p class="text-center text-gray-600 mt-4">
                Hesabın yok mu? <a href="{{ route('register.form') }}" class="text-blue-500 font-medium">Kayıt Ol</a>
            </p>
        </div>
    </div>
@endsection
