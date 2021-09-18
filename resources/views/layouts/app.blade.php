@inject('userAutocompletionService', 'App\Services\Views\UserAutocompletionServiceInterface')

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @laravelPWA

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script>
        window.user_autocomplete = JSON.parse('@json($userAutocompletionService->get_usernames())');
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    @include('cookie-consent::index')

    <div id="app">
        <header>
            <nav class="navbar navbar-expand-md navbar-light shadow-sm">
                <div class="container container-fluid">
                    <a class="navbar-brand d-flex flex-row justify-content-center align-items-center" href="{{ url('/') }}">
                        <img
                            src="{{ asset('images/logo_allokemons.png') }}"
                            style="width: 3em; height: 3em"
                            alt="Logo intémons"
                        />
                        <div class="ms-2">
                            {{ config('app.name', 'Laravel') }}
                        </div>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul
                            class="navbar-nav ms-auto d-flex flex-column-reverse flex-md-row justify-content-center align-items-start align-items-md-center"
                        >
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                                    </li>
                                @endif
                            @else
                                <form autocomplete="off" method="GET" action="{{ route('users.search') }}" class="mt-3 mt-md-0 mb-3 mb-md-0 me-md-5 pt-md-3 pb-md-3 input-group d-flex flex-fill">
                                    <div class="autocomplete">
                                        <input
                                            id="search-user-input"
                                            class="form-control h-100"
                                            type="search"
                                            placeholder="Recherchez un joueur"
                                            aria-label="Chercher"
                                            name="search_string"
                                        >
                                    </div>
                                    <button class="btn btn-outline-secondary" type="submit">Chercher</button>
                                </form>

                                <li class="nav-right-menu nav-item dropdown mt-3 mt-md-0">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex flex-row align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <div>
                                            <img
                                                src="{!! Auth::user()->favorite_pokemon ? Auth::user()->favorite_pokemon->picture_link : asset('images/unknown-picture.png') !!}"
                                                class="rounded-circle align-self-center"
                                                style="width: 2.5em; height: 2.5em;"
                                                alt="Photo utilisateur"
                                            />
                                        </div>
                                        <div class="ms-2">
                                            {{ Auth::user()->name }}
                                        </div>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-" aria-labelledby="navbarDropdown">
                                        @if(Gate::allows('is_admin'))
                                            <a><h6 class="dropdown-header">Administrateur</h6></a>

                                            <a class="dropdown-item" href="{{ route('pokemons.index') }}">
                                                Intédex complet
                                            </a>
                                            <a class="dropdown-item" href="{{ route('users.index') }}">
                                                Liste des utilisateurs
                                            </a>
                                            <a class="dropdown-item" href="{{ route('types.index') }}">
                                                Liste des types
                                            </a>

                                            <a><hr class="dropdown-divider"></a>
                                        @endauth

                                        <a><h6 class="dropdown-header">Utilisateur</h6></a>
                                        <a class="dropdown-item" href="{{ route('user.show_profile') }}">
                                            Profil
                                        </a>

                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            Déconnexion
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main class="py-4 vh-80">
            @yield('content')
        </main>

        <footer class="text-muted bg-dark w-100">
            <div class="container d-flex flex-row justify-content-between align-items-center">

                <div class="m-3 text-center">
                    <p class="mb-3">Fait avec ❤️ par le BDE de l'ISIMA</p>

                    <a href="https://bde.isima.fr">
                        <img
                            src="{{ asset('images/logo_bde.png') }}"
                            style="width: 4em; height: 4em"
                            alt="Logo du BDE"
                        />
                    </a>
                </div>

                <div class="text-center">
                    <a href="#app"><i class="bi bi-arrow-up-circle"></i></a>
                    <div class="socials m-3">
                        <a href="https://www.facebook.com/bde.isima"><i class="bi bi-facebook"></i></a>
                        <a class="ms-md-3" href="https://www.instagram.com/bde_isima"><i class="bi bi-instagram"></i></a>
                        <a class="ms-md-3" href="https://github.com/corentin703/Intedex"><i class="bi bi-github"></i></a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
