@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-tr from-violet-200 to-fuchsia-100 py-8">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8 animate__animated animate__fadeInUp">
        <h1 class="text-3xl font-bold text-center text-violet-700 mb-8">Logowanie</h1>
        @if ($errors->any())
            <div class="mb-4">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block mb-1 font-medium text-gray-700">E-mail</label>
                <input id="email" name="email" type="email" required autofocus autocomplete="email"
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-400"/>
            </div>
            <div>
                <label for="password" class="block mb-1 font-medium text-gray-700">Hasło</label>
                <input id="password" name="password" type="password" required autocomplete="current-password"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-400"/>
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="mr-2">
                <label for="remember" class="text-sm text-gray-700">Zapamiętaj mnie</label>
            </div>
            <button type="submit"
                    class="w-full bg-violet-700 text-white font-bold py-2 rounded-lg hover:bg-violet-800 transition">Zaloguj się</button>
        </form>
        <div class="text-center text-sm text-gray-500 mt-5">
            Nie masz konta?
            <a href="{{ route('register') }}" class="text-violet-700 hover:underline">Zarejestruj się</a>
        </div>
    </div>
</div>
@endsection