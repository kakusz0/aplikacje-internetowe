@extends('layouts.app')
@section('content')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const orderInputs = document.querySelectorAll('input[name="option_order"]');
            orderInputs.forEach(input => {
                const addOptionForm = document.getElementById('add-option-form');
                if (!addOptionForm) return;

                addOptionForm.addEventListener('submit', function(e) {
                    const values = Array.from(orderInputs).map(i => i.value);
                    if (values.filter(v => v === input.value).length > 1) {
                        alert('Ta kolejność jest już ustawiona! Ustaw inną.');
                        input.value = 0;
                        input.focus();
                    }
                });
            });
        });
    </script>
    <div class="max-w-lg mx-auto mt-10 bg-white shadow rounded p-6">
        <h1 class="text-xl font-bold mb-4">Edytuj pytanie</h1>
        <form method="POST" action="{{ route('admin.questions.update', $question) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label>Treść pytania:
                    <input name="question_text" value="{{ old('question_text', $question->question_text) }}" required
                        class="border p-2 rounded w-full">
                </label>
            </div>
            <div class="mb-4">
                <label>Typ pytania:
                    <select name="question_type" class="border p-2 rounded w-full">
                        <option value="single" @if ($question->question_type == 'single') selected @endif>Jednokrotnego wyboru
                        </option>
                        <option value="multiple" @if ($question->question_type == 'multiple') selected @endif>Wielokrotnego wyboru
                        </option>
                        <option value="text" @if ($question->question_type == 'text') selected @endif>Odpowiedź tekstowa</option>
                    </select>
                </label>
            </div>
            <button type="submit" class="bg-violet-800 text-white px-4 py-2 rounded">Zapisz zmiany</button>
            <a href="{{ route('admin.surveys.edit', $question->survey) }}" class="ml-2 underline">Anuluj</a>
        </form>


        @if ($question->question_type !== 'text')
            <hr class="my-6">
            <div>
                <h2 class="font-semibold mb-3 text-lg">Opcje odpowiedzi</h2>
                {{-- Dodaj opcję --}}
                <form action="{{ route('admin.options.store') }}" method="POST" class="mb-4 flex gap-2">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <input type="text" name="option_text" required maxlength="255" value="{{ old('option_text') }}"
                        class="border px-2 py-1 rounded w-full">
                    @if ($errors->has('option_text'))
                        <p class="text-red-600 text-sm mt-1">{{ $errors->first('option_text') }}</p>
                    @endif
                    <input type="number" name="option_order" min="1" placeholder="Kolejność"
                        value="{{ old('option_order') }}" class="border px-2 py-1 rounded w-32">
                    <button type="submit" class="bg-violet-800 text-white px-3 py-1 rounded text-xs font-semibold">Dodaj
                        opcję</button>
                </form>

                @forelse ($question->options as $option)
                    <div class="bg-gray-100 rounded p-3 mb-2 flex justify-between items-center">
                        <form action="{{ route('admin.options.update', $option) }}" method="POST" class="flex gap-2 w-full"
                            id="add-option-form">
                            @csrf @method('PUT')
                            <input type="text" name="option_text" required maxlength="255" value="{{ $option->option_text }}"
                                class="border px-2 py-1 rounded w-full">
                
                            <input type="number" name="option_order" min="1"
                                value="{{ old('option_order', $option->option_order) }}"
                                class="border px-2 py-1 rounded w-28">
                            <button type="submit"
                                class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold">Zapisz</button>
                        </form>
                        <form action="{{ route('admin.options.destroy', $option) }}" method="POST" class="ml-2"
                            onsubmit="return confirm('Usunąć tę opcję?');">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-800 text-white px-3 py-1 rounded text-xs font-semibold">Usuń</button>
                        </form>
                    </div>
                @empty
                    <div class="italic text-gray-500 mb-3">Brak opcji. Dodaj poniżej.</div>
                @endforelse
            </div>
        @endif
    </div>
@endsection
