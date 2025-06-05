@extends('layouts.app')
@section('content')
    <div class="max-w-6xl mx-auto mt-10 px-2">
        <h1 class="text-2xl font-bold text-violet-800 mb-4">Ankiety</h1>


   
        @if(auth()->check()&&auth()->user()->is_admin)
            <div class="mb-6 flex justify-end">
                <a href="{{ route('admin.users') }}"
                   class="inline-flex items-center bg-violet-700 hover:bg-violet-900 text-white px-4 py-2 rounded font-semibold shadow transition">
                   <img src="{{ asset('administrator.png') }}" alt="Panel administratora" class="w-8 h-8 object-contain" />
                      Panel użytkowników
                </a>
            </div>
        @endif

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($surveys as $survey)
                <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-9 h-9 rounded-full bg-violet-100 flex items-center justify-center text-violet-700 font-extrabold text-lg">
                                {{ mb_substr($survey->title, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-semibold text-violet-900 text-lg break-all">
                                    {{ $survey->title }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    <span class="font-semibold">Autor:</span> {{ $survey->user->email ?? 'Brak' }}
                                </div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500"><span class="font-semibold">ID:</span> {{ $survey->id }}</div>
                        <div class="text-sm text-gray-500 mb-2">
                            <span class="font-semibold">Data utw.:</span> {{ $survey->created_at->format('d.m.Y') }}
                        </div>
                    </div>

                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('admin.surveys.edit', $survey) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold flex-1 text-center">Edytuj</a>
                        <form action="{{ route('admin.surveys.destroy', $survey) }}" method="POST"
                            onsubmit="return confirm('Usunąć ankietę?');" class="flex-1">
                            @csrf @method('DELETE')
                            <button
                                class="bg-red-600 hover:bg-red-800 text-white px-3 py-1 rounded text-xs font-semibold w-full">Usuń</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $surveys->links() }}</div>
    </div>
@endsection