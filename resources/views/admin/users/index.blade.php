@extends('layouts.app')
@section('content')
    <div class="max-w-6xl mx-auto mt-10 px-2">
        <h1 class="text-2xl font-bold text-violet-800 mb-6">Użytkownicy</h1>

        @if (session('success'))
            <div class="bg-emerald-100 text-emerald-900 p-2 rounded mb-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-900 p-2 rounded mb-3">{{ session('error') }}</div>
        @endif

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($users as $user)
                <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-10 h-10 rounded-full bg-violet-100 flex items-center justify-center font-bold text-violet-700 text-xl">
                                {{ mb_substr($user->first_name, 0, 1) ?? '?' }}
                            </div>
                            <div>
                                <div class="font-semibold text-violet-950">{{ $user->first_name }} {{ $user->last_name }}</div>
                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="text-gray-600 mb-1"><span class="font-semibold">ID:</span> {{ $user->id }}</div>
                        <div class="text-sm">
                            <span class="font-medium text-gray-700">Admin?</span>
                            <span class="{{ $user->is_admin ? 'text-emerald-700' : 'text-gray-500' }} font-bold ml-2">{{ $user->is_admin ? 'TAK' : 'NIE' }}</span>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-5">
                        @if (!$user->is_admin)
                            <form action="{{ route('admin.users.destroy', $user) }}"
                                  method="POST"
                                  onsubmit="return confirm('Na pewno usunąć?');">
                                @csrf @method('DELETE')
                                <button class="bg-red-600 hover:bg-red-800 text-white px-3 py-1 rounded text-xs font-semibold">Usuń</button>
                            </form>
                        @endif
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold">Edytuj</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $users->links() }}</div>
    </div>
@endsection