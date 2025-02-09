@extends('layouts.app')

@section('title', 'Kafeler Ürün')

@section('content')
    <h1 class="text-3xl font-bold">{{ $product->name }}</h1>

    <div class="mt-4">
        <p class="text-lg font-semibold text-gray-700">Fiyat: ₺{{ $product->price }} </p>

        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-64 object-cover mt-2 rounded">
        @endif

        <p class="mt-4 text-gray-700">{{ $product->description }}</p>
    </div>
@endsection
