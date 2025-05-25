@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto mt-10 bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold text-violet-700 mb-4">Stwórz nową ankietę</h2>
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-300 text-red-800 rounded px-4 py-2">
                <ul class="mb-0 pl-5 list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('surveys.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block font-semibold mb-1">Tytuł ankiety (pytanie główne)</label>
                <input type="text" name="title" class="w-full border px-3 py-2 rounded" aria-label="Tytuł ankiety" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Typ odpowiedzi</label>
                <select name="question_type" class="w-full border px-3 py-2 rounded">
                    <option value="single">Jednokrotnego wyboru</option>
                    <option value="multiple">Wielokrotnego wyboru</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-bold mb-2">Opcje odpowiedzi</label>
                <div id="options-list">
                    <input type="text" name="options[]" class="w-full border px-3 py-2 rounded mb-2"
                        placeholder="Odpowiedź 1" aria-label="Odpowiedź 1" required>
                    <input type="text" name="options[]" class="w-full border px-3 py-2 rounded mb-2"
                        placeholder="Odpowiedź 2" aria-label="Odpowiedź 2" required>
                </div>
                <button type="button" onclick="addOption()" class="bg-violet-700 text-white px-4 py-1 rounded">Dodaj
                    odpowiedź</button>
            </div>
            <div class="mb-6">
                <label class="flex gap-2 items-center">
                    <input type="checkbox" name="is_named" value="1" class="rounded border">
                    Ankieta tylko dla zalogowanych (imienna)?
                </label>
            </div>
            <button type="submit" class="bg-emerald-600 text-white font-bold px-6 py-2 rounded">Utwórz ankietę</button>
        </form>
    </div>

    <script>
        function addOption() {
            const el = document.createElement('input');
            el.type = "text";
            el.name = "options[]";
            el.className = "w-full border px-3 py-2 rounded mb-2";
            el.placeholder = "Kolejna odpowiedź";
            el.setAttribute('aria-label', 'Pole na kolejną opcję odpowiedzi');
            document.getElementById('options-list').appendChild(el);
        }
    </script>
@endsection
