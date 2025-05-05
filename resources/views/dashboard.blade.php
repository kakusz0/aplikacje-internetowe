@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">

    <!-- Sidebar -->
    <nav class="w-36 bg-gradient-to-b from-violet-700 to-violet-900 text-white flex flex-col items-center py-10 shadow-lg">
        <!-- Home: Statystyki -->
        <a href="#" title="Strona główna" class="flex flex-col items-center mb-8 hover:bg-violet-800 rounded-lg p-3 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 11.25L12 4l9 7.25M4.5 10.75V19a1 1 0 001 1h3.5a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3.5a1 1 0 001-1V10.75"/>
            </svg>
            <span class="text-xs font-medium">Strona główna</span>
        </a>
        <!-- Kreator nowej ankiety -->
        <a href="#" title="Nowa ankieta" class="flex flex-col items-center mb-8 hover:bg-green-600 rounded-lg p-3 transition">
            <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="7" stroke="currentColor" stroke-width="2"/>
                <path stroke-linecap="round" stroke-width="2" d="M12 9v6M9 12h6"/>
            </svg>
            <span class="text-xs font-medium">Nowa ankieta</span>
        </a>
        <!-- Wyszukiwanie ankiet -->
        <a href="#" title="Wyszukaj ankiety" class="flex flex-col items-center mb-8 hover:bg-blue-600 rounded-lg p-3 transition">
            <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                <path stroke-linecap="round" stroke-width="2" d="M21 21l-4.35-4.35"/>
            </svg>
            <span class="text-xs font-medium">Wyszukaj</span>
        </a>
        <!-- Uzupełniacz, by zawartość była przyklejona do góry, a całość wypełniała wysokość -->
        <div class="flex-grow"></div>
    </nav>

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <h1 class="text-3xl font-bold text-violet-800 mb-5">Twój panel</h1>

        <!-- Statystyki -->
        <div class="grid gap-6 grid-cols-1 md:grid-cols-3 mb-10">
            <div class="bg-white rounded-xl p-6 shadow hover:shadow-xl transition group">
                <div class="flex items-center gap-3">
                    <div class="bg-violet-100 rounded-full p-2">
                        <svg class="w-6 h-6 text-violet-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-width="2" d="M8 17l4 4 4-4M12 12V3" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-extrabold text-violet-700">{{ $user->surveys_count ?? 0 }}</div>
                        <div class="text-gray-500">Utworzonych ankiet</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow hover:shadow-xl transition group">
                <div class="flex items-center gap-3">
                    <div class="bg-emerald-100 rounded-full p-2">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-width="2" d="M9 13h6v6H9z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-extrabold text-emerald-700">{{ $user->answers_count ?? 0 }}</div>
                        <div class="text-gray-500">Odpowiedzi w ankietach</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow hover:shadow-xl transition group">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 rounded-full p-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-width="2" d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 21v-2a4 4 0 0 0-3-3.87"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-extrabold text-blue-700">{{ $user->shared_surveys_count ?? 0 }}</div>
                        <div class="text-gray-500">Udostępnione ankiety</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista Twoich ankiet -->
        <h2 class="text-xl font-semibold text-gray-900 mb-3">Twoje ankiety</h2>
        <div class="bg-white rounded-xl shadow p-5 max-h-72 overflow-y-auto">
            @forelse(($user->surveys ?? []) as $survey)
            <div class="border-b last:border-b-0 py-3 flex items-center justify-between group">
                <span class="font-medium text-violet-800 group-hover:underline">{{ $survey->title }}</span>
                <span class="text-gray-500 text-sm">
                    {{ \Carbon\Carbon::parse($survey->created_at)->format('d.m.Y') }}
                </span>
            </div>
            @empty
            <div class="italic text-gray-500">Nie utworzyłeś jeszcze żadnej ankiety.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection