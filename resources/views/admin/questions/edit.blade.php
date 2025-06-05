@extends('layouts.app')
@section('content')
    <div class="max-w-lg mx-auto mt-10 bg-white shadow rounded p-6">
        <h1 class="text-xl font-bold mb-4">Edytuj pytanie</h1>


        @if ($question->question_type !== 'text')
            <hr class="my-6">

            <div>
                <h2 class="font-semibold mb-3 text-lg">Opcje odpowiedzi</h2>

                <form action="{{ route('admin.options.store') }}" method="POST" class="mb-4 flex gap-2">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <input type="text" name="option_text" required maxlength="255" value="{{ old('option_text') }}"
                        class="border px-2 py-1 rounded w-full" placeholder="Treść nowej opcji">
                    @if ($errors->has('option_text'))
                        <p class="text-red-600 text-sm mt-1">{{ $errors->first('option_text') }}</p>
                    @endif
                    <button type="submit" class="bg-violet-800 text-white px-3 py-1 rounded text-xs font-semibold">Dodaj
                        opcję</button>
                </form>

                <form id="reorderForm" action="{{ route('admin.options.reorder', $question->id) }}" method="POST"
                    class="mt-4">

                    @csrf

                    <div class="mb-4">
                        <label>Treść pytania:
                            <input name="question_text" value="{{ old('question_text', $question->question_text) }}"
                                required class="border p-2 rounded w-full">
                        </label>
                    </div>
                    <div class="mb-4">
                        <label>Typ pytania:
                            <select name="question_type" class="border p-2 rounded w-full">
                                <option value="single" @if ($question->question_type == 'single') selected @endif>Jednokrotnego
                                    wyboru
                                </option>
                                <option value="multiple" @if ($question->question_type == 'multiple') selected @endif>Wielokrotnego
                                    wyboru
                                </option>
            
                            </select>
                        </label>
                    </div>



                    @csrf
                    <div id="draggableOptions" class="space-y-2 mb-4">
                        @forelse ($question->options->sortBy('option_order') as $option)
                            <div class="bg-gray-100 rounded p-3 flex items-center draggable-option"
                                data-option-id="{{ $option->id }}" style="cursor: grab;">
                                <input type="text" name="option_texts[{{ $option->id }}]" maxlength="255"
                                    value="{{ $option->option_text }}" class="border px-2 py-1 rounded w-full mr-3" />
                                <button type="button" onclick="deleteOption({{ $option->id }})"
                                    class="bg-red-600 hover:bg-red-800 text-white px-3 py-1 rounded text-xs font-semibold ml-2">
                                    Usuń
                                </button>
                            </div>
                        @empty
                            <div class="italic text-gray-500 mb-3">Brak opcji. Dodaj powyżej.</div>
                        @endforelse
                    </div>
                    <input type="hidden" name="orderedOptions" id="orderedOptions" />
                    <button type="submit" class="bg-violet-800 text-white px-4 py-2 rounded">Zapisz zmiany</button>
                    <a href="{{ route('admin.surveys.edit', $question->survey) }}" class="ml-2 underline">Anuluj</a>
                </form>
                <form id="deleteOptionForm" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        @endif
    </div>
    <script src="{{ asset('js/Sortable.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const draggableList = document.getElementById('draggableOptions');
            if (draggableList) {
                new Sortable(draggableList, {
                    animation: 150
                });
            }

            document.getElementById('reorderForm').addEventListener('submit', function(e) {
                const orderData = [];
                document.querySelectorAll('.draggable-option').forEach((item, index) => {
                    orderData.push({
                        id: item.dataset.optionId,
                        position: index + 1
                    });
                });
                document.getElementById('orderedOptions').value = JSON.stringify(orderData);
            });


        });

        function deleteOption(optionId) {
            if (confirm('Usunąć tę opcję?')) {
                const form = document.getElementById('deleteOptionForm');
                form.action = `/admin/options/${optionId}`;
                form.submit();
            }
        }
    </script>
@endsection
