@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white shadow rounded p-6">
    <h1 class="text-xl font-bold mb-4">Edytuj użytkownika</h1>
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf @method('PUT')
        <div class="mb-4">
            <label>Imię: <input name="first_name" value="{{ old('first_name', $user->first_name) }}" required class="border p-2 rounded w-full"></label>
        </div>
        <div class="mb-4">
            <label>Nazwisko: <input name="last_name" value="{{ old('last_name', $user->last_name) }}" required class="border p-2 rounded w-full"></label>
        </div>
        <div class="mb-4">
            <label>Email: <input name="email" value="{{ old('email', $user->email) }}" required class="border p-2 rounded w-full"></label>
        </div>
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="hidden" name="is_admin" value="0">
                <input type="checkbox" name="is_admin" value="1" @if(old('is_admin', $user->is_admin)) checked @endif>
                <span class="ml-2">Administrator</span>
            </label>
        </div>
        <button type="submit" class="bg-violet-800 text-white px-4 py-2 rounded">Zapisz zmiany</button>
        <a href="{{ route('admin.users') }}" class="ml-2 underline">Anuluj</a>
    </form>
</div>
@endsection