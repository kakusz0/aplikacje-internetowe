@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white shadow rounded p-6">
    <h1 class="text-xl font-bold mb-4">Edytuj ankietę</h1>
    <form method="POST" action="{{ route('admin.surveys.update', $survey) }}">
        @csrf @method('PUT')
        <div class="mb-4">
            <label>Tytuł: <input name="title" value="{{ old('title', $survey->title) }}" required class="border p-2 rounded w-full"></label>
        </div>
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="hidden" name="is_public" value="0">
                <input type="checkbox" name="is_public" value="1" @if(old('is_public', $survey->is_public)) checked @endif>
                <span class="ml-2">Publiczna</span>
            </label>
        </div>
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="hidden" name="is_named" value="0">
                <input type="checkbox" name="is_named" value="1" @if(old('is_named', $survey->is_named)) checked @endif>
                <span class="ml-2">Tylko dla zalogowanych</span>
            </label>
        </div>
        <button type="submit" class="bg-violet-800 text-white px-4 py-2 rounded">Zapisz zmiany</button>
        <a href="{{ route('admin.surveys') }}" class="ml-2 underline">Anuluj</a>
    </form>

    <hr class="my-6">


    <div>
        <h2 class="font-semibold mb-3 text-lg">Pytania w ankiecie</h2>
        @forelse($survey->questions as $question)
            <div class="bg-gray-100 rounded p-3 mb-3 flex justify-between items-center">
                <div>
                    <div class="font-medium mb-1">{{ $question->question_text }}</div>
                    <div class="text-xs text-gray-500">Typ: {{ $question->question_type }}</div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.questions.edit', $question) }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold">Edytuj</a>
                    <form action="{{ route('admin.questions.destroy', $question) }}" method="POST"
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


    </div>
</div>
@endsection