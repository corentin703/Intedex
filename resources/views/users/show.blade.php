@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">À propos de {{ $user->name }}</h5>
                <div class="card-body ">
                    <div class="d-flex flex-column flex-md-row align-items-center">
                        <div class="m-3 d-flex justify-content-center">
                            <img
                                src="{!! $user->favorite_pokemon ? $user->favorite_pokemon->picture_link : asset('images/unknown-picture.png') !!}"
                                class="figure-img rounded"
                                style="width: 100px; height: 100px"
                                alt="Photo de l'utilisateur"
                            />
                        </div>
                        <div class="ms-md-2 mt-2 flex-fill">
                            <h5 class="text-center text-md-start">Intémon trouvé : <strong>{{ $user->pokemons->count() }}</strong></h5>
                            <h5 class="text-center text-md-start">Score : <strong>{{ $user->getScore() }}</strong></h5>

                            @if ($user->pokemons->count() > 0)
                                <hr/>

                                <div>
                                    <h5 class="text-center text-md-start">Intédex</h5>

                                    <div
                                        class="ms-2 ms-md-0 d-flex flex-wrap justify-content-center justify-content-md-start align-items-center"
                                        style="max-height: 15vh; overflow: hidden"
                                    >
                                        @php
                                            $nbre = 0;
                                        @endphp

                                        @foreach($user->pokemons as $pokemon)
                                            @if($nbre > 10)
                                                @break
                                            @endif

                                            @php
                                                $nbre++;
                                            @endphp

                                            <div class="mt-2 d-block">
                                                <img
                                                    src="{!! $pokemon->picture_link !!}"
                                                    class="rounded-circle"
                                                    style="width: 2rem; height: 2rem"
                                                    alt="Photo d'un intémon'"
                                                />
                                                <img
                                                    src="{!! $pokemon->types[0]->picture_link !!}"
                                                    class="rounded-circle position-relative float-end"
                                                    style="background-color: {{ $pokemon->types[0] }}; width: 1rem; height: 1rem; z-index: 1; left: -0.75em; bottom: -1em"
                                                    alt="Type du intémon"
                                                />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>

                    @if (Auth::user()->is_admin || Auth::id() == $user->id)

                        <hr/>

                        <div class="ms-2 mt-2 container">
                            <div class="row align-middle">
                                <h5 class="col-md-4 pb-1 pb-md-0">Courriel</h5>
                                <a class="col ps-4 ps-md-2" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                            </div>

                            @if(Auth::user()->is_admin)

                                <hr/>

                                <div class="row align-middle">
                                    <h5 class="col-md-4 pb-1 pb-md-0">Admin</h5>
                                    <div class="col ps-4 ps-md-2">@if($user->is_admin) <i class="bi bi-hand-thumbs-up"></i> @else <i class="bi bi-hand-thumbs-down"></i> @endif</div>
                                </div>

                            @endif

                            <hr/>

                            <div class="row align-middle">
                                <h5 class="col-md-4 pb-1 pb-md-0">Pokémon favori<br/>(photo)</h5>
                                <div class="col ps-4 ps-md-2">
                                    @if($user->favorite_pokemon)
                                        {{ $user->favorite_pokemon->name}}
                                        @if($user->favorite_pokemon->sex == 'F')
                                            (<i class="bi bi-gender-female"></i>)
                                        @else()
                                            (<i class="bi bi-gender-male"></i>)
                                        @endif
                                    @else
                                        Aucun
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    @if (Auth::user()->is_admin || Auth::id() == $user->id)
                        <div class="d-flex w-100 justify-content-between">
                            <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Éditer</a>
                            <a class="btn btn-link" onclick="window.history.back()">Retour</a>
                        </div>
                    @else
                        <div class="d-flex w-100 justify-content-end">
                            <a class="btn btn-link" onclick="window.history.back()">Retour</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

