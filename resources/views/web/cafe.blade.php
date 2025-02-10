@extends('layouts.app')

@section('title', 'Kafeler Title Home')

@section('content')
    {{ $cafe->name }}

    <div>
        <h1 class="text-2xl font-bold mb-4 text-center">Kategoriler</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-5">
            @foreach($cafe->categories as $category)
                <div class="rounded-lg bg-white shadow-md p-4 hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('category.show', [$cafe->username, $category->slug]) }}"
                       class="flex flex-col items-center text-center group">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}"
                                 alt="{{ $category->name }}"
                                 class="w-48 h-48 object-cover rounded-lg transition-transform duration-300 group-hover:scale-105">
                        @endif
                        <span class="mt-3 text-lg font-semibold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">
                        {{ $category->name }}
                    </span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

@endsection
