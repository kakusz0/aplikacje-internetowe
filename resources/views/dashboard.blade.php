@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen bg-gray-50">

        <!-- Sidebar -->
        <nav
            class="w-36 bg-gradient-to-b from-violet-700 to-violet-900 text-white flex flex-col items-center py-10 shadow-lg">
            <!-- Home: Statystyki -->
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
            <!-- Wyszukiwanie ankiet -->
            <a href="{{ route('surveys.index') }}" title="Wyszukaj ankiety"
                class="flex flex-col items-center mb-8 hover:bg-violet-800 rounded-lg p-3 transition">
                <img src="{{ asset('survey_search.png') }}" alt="Shared Icon" class="w-10 h-10 object-contain" />
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
                            <img src="{{ asset('survey_created.png') }}" alt="Shared Icon" class="w-6 h-6 object-contain" />
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
                            <img src="{{ asset('survey_answer.png') }}" alt="Shared Icon" class="w-6 h-6 object-contain" />
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
                            <img src="{{ asset('survey_share.png') }}" alt="Shared Icon" class="w-6 h-6 object-contain" />
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
                        <div class="flex items-center gap-3 flex-1">
                            <a href="{{ route('surveys.votes', $survey) }}"
                                class="font-medium text-violet-800 group-hover:underline">
                                {{ $survey->title }}
                            </a>
                            <span class="ml-3 text-gray-500 text-sm">
                                {{ \Carbon\Carbon::parse($survey->created_at)->format('d.m.Y H:i') }}
                            </span>
                        </div>
                        <form action="{{ route('surveys.destroy', $survey) }}" method="POST"
                              onsubmit="return confirm('Czy na pewno usunąć ankietę?');" class="ml-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold shadow transition">
                                Usuń
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="italic text-gray-500">Nie utworzyłeś jeszcze żadnej ankiety.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
