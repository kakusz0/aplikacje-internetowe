@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white shadow rounded p-6">
    <h1 class="text-xl font-bold mb-4">Edycja odpowiedzi do pytania</h1>
    <div class="mb-3 font-semibold">{{ $question->question_text }}</div>
    @if(session('success'))
        <div class="bg-green-100 text-green-900 p-1 rounded mb-2">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-900 p-1 rounded mb-2">{{ session('error') }}</div>
    @endif

    @foreach($question->answers as $answer)
        <div class="flex items-center gap-2 mb-2">
            <form action="{{ route('admin.answers.update', $answer) }}" method="POST" class="flex-1 flex gap-2">
                @csrf @method('PUT')
                <input name="answer_text" value="{{ old('answer_text', $answer->answer_text) }}" class="border px-2 py-1 rounded w-full">
                <button type="submit" class="bg-violet-700 text-white px-3 py-1 rounded text-xs font-semibold">Zapisz</button>
            </form>
            @if($question->answers->count() > 1)
                <form action="{{ route('admin.answers.destroy', $answer) }}" method="POST" onsubmit="return confirm('Usunąć?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-800 text-white px-3 py-1 rounded text-xs font-semibold">Usuń</button>
                </form>
            @endif
        </div>
    @endforeach

    <form action="{{ route('admin.answers.store') }}" method="POST" class="mt-4 flex gap-2">
        @csrf
        <input type="hidden" name="question_id" value="{{ $question->id }}">
        <input name="answer_text" placeholder="Nowa odpowiedź" required class="border px-2 py-1 rounded w-full">
        <button type="submit" class="bg-violet-800 text-white px-3 py-1 rounded text-xs font-semibold">Dodaj</button>
    </form>

    <div class="mt-6">
        <a href="{{ route('admin.surveys.edit', $question->survey_id) }}" class="underline text-sm">Powrót do ankiety</a>
    </div>
</div>
@endsection