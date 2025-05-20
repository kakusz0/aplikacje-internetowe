@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white shadow rounded-lg p-8 text-center">
    <h2 class="text-2xl font-bold text-violet-700 mb-4">Ankieta utworzona!</h2>
    <p class="mb-2">Skopiuj link i wyślij znajomym:</p>
    <input id="link" type="text" readonly value="{{ $link }}" class="w-full border px-2 py-2 rounded text-center mb-4">
    <button onclick="navigator.clipboard.writeText(document.getElementById('link').value)" class="bg-violet-700 text-white px-4 py-2 rounded">Kopiuj link</button>
    <div class="mt-6">
        <a href="{{ route('dashboard') }}" class="text-violet-700 font-semibold underline">Wróć do panelu</a>
    </div>
</div>
@endsection