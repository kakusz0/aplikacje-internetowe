@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-12 bg-white shadow rounded p-6">
    <h1 class="text-xl font-bold mb-4">Edytuj pytanie w ankiecie: <span class="font-normal">{{ $survey->title }}</span></h1>
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
            
                    <option value="single_choice" {{ $question->question_type === 'single_choice' ? 'selected' : '' }}>Jednokrotny wybór</option>
                    <option value="multiple_choice" {{ $question->question_type === 'multiple_choice' ? 'selected' : '' }}>Wielokrotny wybór</option>
                </select>
            </label>
        </div>
        <button type="submit" class="bg-violet-800 text-white px-4 py-2 rounded">Zapisz zmiany</button>
        <a href="{{ route('admin.surveys.edit', $survey) }}" class="ml-2 underline">Anuluj</a>
    </form>
</div>
@endsection