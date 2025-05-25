@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-10 border rounded p-5 bg-white shadow">
    <h1 class="text-xl font-bold mb-4">Dodaj pytanie do ankiety: {{ $survey->title }}</h1>
    <form method="POST" action="{{ route('admin.surveys.questions.store', $survey) }}">
        @csrf
        <div class="mb-4">
            <label>Treść pytania:
                <input name="question_text" required class="border p-2 rounded w-full" value="{{ old('question_text') }}">
            </label>
        </div>
        <div class="mb-4">
            <label>Typ pytania:
                <select name="question_type" class="border p-2 rounded w-full">
                    <option value="text">Odpowiedź tekstowa</option>
                    <option value="single_choice">Jednokrotny wybór</option>
                    <option value="multiple_choice">Wielokrotny wybór</option>
                </select>
            </label>
        </div>
        <button type="submit" class="bg-violet-800 text-white px-4 py-2 rounded">Dodaj pytanie</button>
        <a href="{{ route('admin.surveys.questions.index', $survey) }}" class="ml-2 underline">Anuluj</a>
    </form>
</div>
@endsection