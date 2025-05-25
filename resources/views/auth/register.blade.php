@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-tr from-violet-200 to-fuchsia-100 py-8">
        <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8 animate__animated animate__fadeInUp">
            <h1 class="text-3xl font-bold text-center text-violet-700 mb-8">Rejestracja</h1>
            @if ($errors->any())
                <div class="mb-4">
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="first_name" class="block mb-1 font-medium text-gray-700">Imię</label>
                    <input id="first_name" name="first_name" type="text" required autofocus autocomplete="first_name"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-400"
                        value="{{ old('first_name') }}" aria-label="Imię" />
                </div>
                <div>
                    <label for="last_name" class="block mb-1 font-medium text-gray-700">Nazwisko</label>
                    <input id="last_name" name="last_name" type="text" required autofocus autocomplete="last_name"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-400"
                        value="{{ old('last_name') }}" aria-label="Nazwisko"/>
                </div>
                <div>
                    <label for="email" class="block mb-1 font-medium text-gray-700">E-mail</label>
                    <input id="email" name="email" type="email" required autocomplete="email"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-400"
                        value="{{ old('email') }}" aria-label="E-mail" />
                </div>
                <div>
                    <label for="password" class="block mb-1 font-medium text-gray-700">Hasło</label>
                    <input id="password" name="password" type="password" minlength="8" required
                        autocomplete="new-password"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-400"
                        value="{{ old('password') }}" aria-label="Hasło" />
                </div>
                <div>
                    <label for="password_confirmation" class="block mb-1 font-medium text-gray-700">Powtórz hasło</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" required
                        autocomplete="new-password"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-400"
                        value="{{ old('password_confirmation') }}" aria-label="Powtórz hasło" />
                </div>

                <button type="submit"
                    class="w-full bg-violet-700 text-white font-bold py-2 rounded-lg hover:bg-violet-800 transition">Zarejestruj
                    się</button>
            </form>
            <div class="text-center text-sm text-gray-500 mt-5">
                Masz już konto?
                <a href="{{ route('login') }}" class="text-violet-700 hover:underline">Zaloguj się</a>
            </div>
        </div>
    </div>
@endsection
