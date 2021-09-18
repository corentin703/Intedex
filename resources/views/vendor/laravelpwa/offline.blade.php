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
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
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

                <h5 class="m-0">Aucune connexion</h5>
            </div>
        </nav>
    </header>

    <main class="py-4 vh-80">
        <div class="container">

            <h1 class="text-center">Vous n'êtes pas connecté à internet.</h1>

            <hr/>

            <p class="text-center">Connectez-vous à internet pour pouvoir utiliser le intédex.</p>

        </div>
    </main>

    <footer class="text-muted bg-dark w-100">
        <div class="container d-flex flex-row justify-content-center align-items-center">

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
        </div>
    </footer>
</div>
</body>
</html>


@section('content')



@endsection
