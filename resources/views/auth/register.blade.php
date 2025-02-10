@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-50">
        <div class="w-[900px] bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold text-center mb-4 text-gray-800">Kayıt Ol</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Ad</label>
                    <input type="text" name="name" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required autofocus>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Soyad</label>
                    <input type="text" name="lastname" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Kullanıcı Adı</label>
                    <input type="text" name="username" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">E-Posta</label>
                    <input type="email" name="email" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Şifre</label>
                    <input type="password" name="password" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Şifre Tekrar</label>
                    <input type="password" name="password_confirmation" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                    Kayıt Ol
                </button>
            </form>

            <p class="text-center text-gray-600 mt-4">
                Zaten hesabın var mı? <a href="{{ route('login') }}" class="text-blue-500 font-medium">Giriş Yap</a>
            </p>
        </div>
    </div>

@endsection
