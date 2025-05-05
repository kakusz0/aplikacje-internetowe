<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Pollify - darmowy kreator ankiet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

    <!-- NAVBAR (RESPONSYWNY Z BURGER MENU) -->
    <nav x-data="{ open: false }" class="bg-white shadow-sm relative z-20">
        <div class="
    
    @if(Route::currentRouteName() === 'dashboard')
    max-w-8xl pl-0 px-4 sm:px-6 lg:px-2
    @else
    max-w-7xl mx-auto px-4 sm:px-6 lg:px-8
    @endif
">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                @if (Route::currentRouteName() !== 'dashboard')
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-violet-700 text-2xl font-bold font-mono">Pollify</span>
                    </div>
                @else
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-violet-700 text-2xl font-bold font-mono">Pollify</span>
                    </div>
                @endif
                <!-- Desktop Auth Buttons -->
                <!-- w layouts/app.blade.php, część headera-->
                <div class="flex items-center gap-4">
                    @auth
                        @if (Route::currentRouteName() !== 'dashboard')
                            <a href="{{ route('dashboard') }}"
                                class="text-violet-700 font-bold px-4 py-2 rounded hover:bg-violet-100 transition">
                                Panel ankiet
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-violet-700 text-white rounded font-semibold hover:bg-violet-800 transition">
                                Wyloguj
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-violet-700 border border-violet-600 rounded font-semibold hover:bg-gray-50 transition">Zaloguj</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-violet-700 text-white rounded font-semibold hover:bg-violet-800 transition">Zarejestruj</a>
                    @endauth
                </div>
                @if (Route::currentRouteName() !== 'dashboard')
                    <!-- Burger -->
                    <div class="flex md:hidden">
                        <button @click="open = !open" type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-violet-700 hover:bg-violet-50 transition">
                            <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg x-show="open" class="h-6 w-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
        </div>
        <!-- Mobile Auth Buttons -->
        <div x-show="open" x-transition class="md:hidden absolute left-0 w-full bg-white shadow border-t">
            <div class="px-4 pt-4 pb-4 flex flex-col gap-3">
                @guest
                    <a href="{{ route('login') }}"
                        class="block text-violet-700 border border-violet-600 rounded px-4 py-2 text-center font-semibold bg-white hover:bg-gray-50 transition">Zaloguj</a>
                    <a href="{{ route('register') }}"
                        class="block bg-violet-700 text-white rounded px-4 py-2 text-center font-semibold hover:bg-violet-800 transition">Zarejestruj</a>
                @else
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit"
                            class="w-full bg-violet-700 text-white rounded px-4 py-2 text-center font-semibold hover:bg-violet-800 transition">
                            Wyloguj
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- STRONA -->
    <main>
        @yield('content')
    </main>

    <!-- Alpine.js do burger-menu -->
    <script src="//unpkg.com/alpinejs" defer></script>
</body>

</html>
