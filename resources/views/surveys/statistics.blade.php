@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto mt-12 bg-white shadow rounded p-8 text-center">
        <h2 class="text-xl font-bold text-violet-700 mb-5">{{ $survey->title }}</h2>
        <div class="mb-8 text-lg text-emerald-700 font-semibold">
            Dziękujemy za udział! {{$survey->is_named}}
        </div>
        <strong class="block mb-4">Statystyki odpowiedzi:</strong>
        <ul>
            @foreach ($stats as $s)
                <li class="mb-2">
                    {{ $s['text'] }}: <span class="font-bold">{{ $s['count'] }}</span>
                    ({{ $s['percent'] }}%)
                    <div class="h-3 bg-gray-200 rounded mt-1">
                        <div style="width: {{ $s['percent'] }}%" class="h-full bg-violet-500 rounded"></div>
                    </div>
                </li>
            @endforeach
        </ul>


        <a href="{{ url('/') }}" class="mt-10 inline-block text-violet-700 underline">Powrót</a>
    </div>
@endsection
