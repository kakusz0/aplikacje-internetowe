<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Pollify - darmowy kreator ankiet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">


    <nav x-data="{ open: false }" class="bg-white shadow-sm relative z-20">
        @php
            $isDashboardOrSurveys = request()->routeIs('dashboard') || request()->routeIs('surveys.*');
        @endphp
        <div
            class="{{ $isDashboardOrSurveys ? 'max-w-8xl pl-0 px-4 sm:px-6 lg:px-2' : 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8' }}">
            <div class="flex justify-between h-16">



                <div class="flex-shrink-0 flex items-center ml-4">
                    <a href="/" class="text-violet-700 text-2xl font-bold font-mono ml-1">Pollify</a>
                </div>



                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="text-violet-700 font-bold px-4 py-2 rounded hover:bg-violet-100 transition">
                            Panel ankiet
                        </a>
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

                <div class="flex md:hidden">
                    <button @click="open = !open" type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-violet-700 hover:bg-violet-50 transition">
                        <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="open" x-transition class="md:hidden absolute left-0 w-full bg-white shadow border-t">
            <div class="px-4 pt-4 pb-4 flex flex-col gap-3">
                @guest
                    <a href="{{ route('login') }}"
                        class="block text-violet-700 border border-violet-600 rounded px-4 py-2 text-center font-semibold bg-white hover:bg-gray-50 transition">Zaloguj</a>
                    <a href="{{ route('register') }}"
                        class="block bg-violet-700 text-white rounded px-4 py-2 text-center font-semibold hover:bg-violet-800 transition">Zarejestruj</a>
                @else
                    @if (Route::currentRouteName() !== 'dashboard')
                        <a href="{{ route('dashboard') }}"
                            class="w-full bg-violet-700 text-white rounded px-4 py-2 text-center font-semibold hover:bg-violet-800 transition">
                            Panel ankiet
                        </a>
                    @endif

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


    <main>
        @yield('content')
    </main>

    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3500)" x-show="show" x-transition.duration.400ms
            class="fixed bottom-6 right-6 max-w-md flex items-start gap-2 px-6 py-4 border-l-4 border-green-600 shadow-2xl rounded-lg bg-gradient-to-br from-green-500 via-green-600 to-green-700 text-white z-[9999]"
            style="display: none;" role="alert">
          
            <img src="{{ asset('success.png') }}" alt="Sukces">
            <div class="pl-2 font-medium text-white drop-shadow">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4500)" x-show="show" x-transition.duration.400ms
            class="fixed bottom-6 right-6 max-w-md flex items-start gap-2 px-6 py-4 border-l-4 border-red-600 shadow-2xl rounded-lg bg-gradient-to-br from-red-500 via-red-600 to-red-700 text-white z-[9999]"
            style="display: none;" role="alert">
       
            <img src="{{ asset('error.png') }}" alt="Błąd">
            <div class="pl-2 font-medium text-white drop-shadow">
                {{ session('error') }}
            </div>
        </div>
    @endif
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- SweetAlert2 via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>
