@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto mt-8">
    <h2 class="font-semibold mb-3 text-lg">Pytania w ankiecie: <span class="text-violet-700">{{ $survey->title }}</span></h2>

    @if(session('success'))
        <div class="bg-emerald-100 text-emerald-800 p-2 rounded mb-2">{{ session('success') }}</div>
    @endif

    @forelse($survey->questions as $question)
        <div class="bg-gray-100 rounded p-3 mb-3 flex justify-between items-center">
            <div>
                <div class="font-medium mb-1">{{ $question->question_text }}</div>
                <div class="text-xs text-gray-500">Typ: {{ $question->question_type }}</div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.surveys.questions.edit', [$survey, $question]) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold">Edytuj</a>
                <form action="{{ route('admin.surveys.questions.destroy', [$survey, $question]) }}" method="POST"
                    onsubmit="return confirm('Usunąć to pytanie?');">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-800 text-white px-3 py-1 rounded text-xs font-semibold">Usuń</button>
                </form>
            </div>
        </div>
    @empty
        <div class="italic text-gray-500 mb-3">Brak pytań - dodaj pierwsze pytanie!</div>
    @endforelse

    <a href="{{ route('admin.surveys.questions.create', $survey) }}"
       class="inline-block mt-2 bg-violet-700 hover:bg-violet-900 text-white px-4 py-2 rounded font-semibold text-sm transition">
        Dodaj pytanie
    </a>
</div>
@endsection