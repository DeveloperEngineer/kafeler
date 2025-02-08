@extends('layouts.app')

@section('title', 'Kafeler Title Home')

@section('content')
    <div class="w-full">
        <div class="my-5">
            <h1 class="text-3xl font-bold"> Kafeler Projesi</h1>
            <p class="text-lg"> Kafelerimiz </p>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($cafes as $cafe)
                <div class="bg-white shadow-md p-4 rounded-lg">
                    <h2 class="text-xl font-semibold"> {{ $cafe->name }} </h2>
                    @if($cafe->name)
                        <p>  {{ $cafe->name }}  </p>
                    @endif
                    <p class="">
                        <a href="{{ route('cafe.show', $cafe->username) }}">Detaya Git</a>
                    </p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
