@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen bg-gray-50">

        <!-- Sidebar -->
        <nav
            class="w-36 bg-gradient-to-b from-violet-700 to-violet-900 text-white flex flex-col items-center py-10 shadow-lg">
            <a href="{{ url('/') }}" title="Strona główna"
                class="flex flex-col items-center mb-8 hover:bg-violet-800 rounded-lg p-3 transition">
                <img src="{{ asset('home.png') }}" alt="Shared Icon" class="w-10 h-10 object-contain" />
                <span class="text-xs font-medium">Strona główna</span>
            </a>


            <a href="{{ route('surveys.create') }}"
                class="flex flex-col items-center mb-8 hover:bg-violet-800 rounded-lg p-3 transition">
                <img src="{{ asset('survey_created.png') }}" alt="Shared Icon" class="w-10 h-10 object-contain" />
                <span class="text-xs font-medium">Stwórz ankietę</span>
            </a>

            <a href="{{ route('dashboard') }}"
                class="flex flex-col items-center mb-8 hover:bg-violet-800 rounded-lg p-3 transition">
                <img src="{{ asset('panel.png') }}" alt="Shared Icon" class="w-10 h-10 object-contain" />
                <span class="text-xs font-medium">Twój panel</span>
            </a>
            <div class="flex-grow"></div>
        </nav>

        <!-- Main Content -->
        <div class="flex-1 p-4 sm:p-8">
            <h1 class="text-3xl font-bold text-violet-800 mb-7">Wszystkie ankiety</h1>

            <!-- Search Bar -->
            <form method="GET" action="{{ route('surveys.index') }}"
                class="mb-5 flex flex-col sm:flex-row gap-2 max-w-lg">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Szukaj ankiety po tytule..."
                    class="form-control rounded flex-1 px-3 py-2 border-violet-200 focus:ring focus:ring-violet-300" />
                <button type="submit"
                    class="bg-violet-700 text-white rounded px-4 py-2 font-semibold hover:bg-violet-800 transition">Szukaj</button>
            </form>

            <!-- Results -->
            <div class="bg-white rounded-xl shadow p-5">
                @if ($surveys->count())
                    <ul class="divide-y">
                        @foreach ($surveys as $survey)
                            <li
                                class="py-4 flex flex-col md:flex-row md:items-center md:justify-between group hover:bg-violet-50 px-2 rounded transition">
                                <div>
                                    <a href="{{ route('surveys.show', $survey) }}"
                                        class="font-semibold text-violet-800 text-lg group-hover:underline">
                                        {{ $survey->title }}
                                    </a>
                                    <div class="text-gray-500 text-sm mt-1">
                                        Autor:
                                        <span class="font-medium text-gray-900">{{ $survey->user->first_name ?? 'Brak' }}
                                            {{ $survey->user->last_name ?? '' }}</span>
                                        <span class="ml-2 text-gray-400">({{ $survey->user->email ?? '' }})</span>
                                    </div>
                                </div>
                                <div class="mt-2 md:mt-0 text-gray-400 text-sm">
                                    {{ \Carbon\Carbon::parse($survey->created_at)->format('d.m.Y H:i') }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-6">
                        {{ $surveys->withQueryString()->links() }}
                    </div>
                @else
                    <p class="italic text-gray-500">Nie znaleziono ankiet{{ $q ? ' o nazwie: "' . e($q) . '"' : '' }}.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
