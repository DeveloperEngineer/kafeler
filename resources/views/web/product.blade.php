@extends('layouts.app')

@section('title', 'Kafeler Ürün')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-3xl font-bold text-center text-gray-900">{{ $product->name }}</h1>

        <div class="mt-6 flex flex-col md:flex-row items-center gap-6">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     class="w-full md:w-1/2 h-80 object-cover rounded-lg shadow-md">
            @endif

            <div class="text-center md:text-left flex-1">
                <p class="text-2xl font-semibold text-green-600">₺{{ number_format($product->price, 2, ',', '.') }}</p>
                <p class="mt-4 text-gray-700 leading-relaxed">{{ $product->description }}</p>
            </div>
        </div>
    </div>

@endsection
