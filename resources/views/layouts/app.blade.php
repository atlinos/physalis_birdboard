<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <link href="/images/logo-icon.ico" rel="icon">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-grey-light">
    <div id="app">
        <nav class="bg-white">
            <div class="container mx-auto">
                <div class="flex justify-between items-center py-2">
                    <h1>
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img src="/images/logo.png" alt="Physalis">
                        </a>
                    </h1>

                    <div>

                        <!-- Right Side Of Navbar -->
                        <ul class="flex items-center ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <a class="mr-4 text-black no-underline text-sm hover:underline" href="{{ route('login') }}">Se connecter</a>

                                @if (Route::has('register'))
                                    <a class="no-underline text-black text-sm hover:underline" href="{{ route('register') }}">Créer un compte</a>
                                @endif
                            @else
                                <dropdown align="right" width="200px">
                                    <template v-slot:trigger>
                                        <button
                                            class="flex items-center no-underline text-sm focus:outline-none"
                                            v-pre
                                        >
                                            {{ auth()->user()->name }}
                                        </button>
                                    </template>

                                    <form id="logout-form" method="POST" action="/logout">
                                        @csrf

                                        <button type="submit" class="dropdown-menu-link w-full text-left">Déconnexion</button>
                                    </form>
                                </dropdown>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <main class="container mx-auto py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
