@extends('layouts.app')

@section('title', 'Kafeler Title Home')

@section('content')
    {{--    {{ $cafe->categories[0]->products }}--}}

    <div>
        <h1 class="text-2xl font-bold mb-4">{{ $category->name }} Ürünleri</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-5">
            @foreach($category->products as $product)
                <div class="rounded-lg bg-white shadow-md p-4">
                    <div class="flex flex-col items-center">
                        <a href="{{ route('product.show', [$cafe->username, $category->slug, $product->slug]) }}">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-48 h-48 object-cover rounded-lg">
                            @endif
                            <span class="mt-2 text-lg font-semibold">{{ $product->name }}</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
