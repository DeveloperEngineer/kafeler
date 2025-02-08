@extends('layouts.app')

@section('title', 'Kafeler Title Home')

@section('content')
    {{ $cafe->name }}

    <div>
        <h1>Kategoirler</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-5">
            @foreach($cafe->categories as $categry)
                <div class="rounded-lg bg-white shadow-md p-4">
                    <a href="{{ route('category.show', [$cafe->username, $categry->slug]) }}" class="flex flex-col items-center">
                        @if($categry->image)
                            <img src="{{ asset('storage/' . $categry->image) }}" alt="{{ $categry->name }}"
                                 class="w-full h-32 object-cover rounded-lg">
                        @endif
                        <span>{{ $categry->name }}</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
