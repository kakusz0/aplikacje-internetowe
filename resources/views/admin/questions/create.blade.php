@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white shadow rounded p-6">
    <h1 class="text-xl font-bold mb-4">Edytuj pytanie</h1>
    <form method="POST" action="{{ route('admin.questions.update', $question) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label>Treść pytania:
                <input name="question_text" value="{{ old('question_text', $question->question_text) }}" required class="border p-2 rounded w-full">
            </label>
        </div>
        <div class="mb-4">
            <label>Typ pytania:
                <select name="question_type" class="border p-2 rounded w-full">
                    <option value="single" @if($question->question_type=='single') selected @endif>Jednokrotnego wyboru</option>
                    <option value="multiple" @if($question->question_type=='multiple') selected @endif>Wielokrotnego wyboru</option>
                    <option value="text" @if($question->question_type=='text') selected @endif>Odpowiedź tekstowa</option>
                </select>
            </label>
        </div>
        <button type="submit" class="bg-violet-800 text-white px-4 py-2 rounded">Zapisz zmiany</button>
        <a href="{{ route('admin.surveys.edit', $question->survey_id) }}" class="ml-2 underline">Anuluj</a>
    </form>


    @if($question->question_type !== 'text')
    <hr class="my-6">
    <div>
        <h2 class="font-semibold mb-3 text-lg">Odpowiedzi</h2>
        @forelse($question->answers as $answer)
            <div class="bg-gray-100 rounded p-3 mb-2 flex justify-between items-center">
                <form method="POST" action="{{ route('admin.answers.update', $answer) }}" class="flex items-center gap-2 w-full">
                    @csrf @method('PUT')
                    <input name="answer_text" value="{{ old('answer_text', $answer->answer_text) }}" class="border px-2 py-1 rounded w-full">
                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold">Zapisz</button>
                </form>
                @if($question->answers->count() > 1)
                    <form action="{{ route('admin.answers.destroy', $answer) }}" method="POST" onsubmit="return confirm('Usunąć tę odpowiedź?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-800 text-white px-3 py-1 rounded text-xs font-semibold">Usuń</button>
                    </form>
                @endif
            </div>
        @empty
            <div class="italic text-gray-500 mb-3">Brak odpowiedzi. Dodaj poniżej.</div>
        @endforelse

 
        <form action="{{ route('admin.answers.store') }}" method="POST" class="mt-4 flex gap-2">
            @csrf
            <input type="hidden" name="question_id" value="{{ $question->id }}">
            <input name="answer_text" placeholder="Nowa odpowiedź" required class="border px-2 py-1 rounded w-full">
            <button type="submit" class="bg-violet-800 text-white px-3 py-1 rounded text-xs font-semibold">Dodaj</button>
        </form>
    </div>
    @endif
</div>
@endsection