@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <h5 class="card-header">
                    @if(Route::currentRouteName() === 'users.search')
                        Résultat de la recherche
                    @else
                        Liste des utilisateurs
                    @endif
                </h5>

                <div class="card-body">
                    <div class="list-group">
                        @forelse($users as $user)

                            <a class="list-group-item list-group-item-action" href="{{ route('users.show', $user->id) }}">
                                <div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-start align-items-center">
                                    <div class="ms-md-2 text-center">
                                        <img
                                            src="{!! $user->favorite_pokemon ? $user->favorite_pokemon->picture_link : asset('images/unknown-picture.png') !!}"
                                            class="rounded-circle align-self-center"
                                            style="width: 3em; height: 3em;"
                                            alt="Photo de l'utilisateur"
                                        />
                                    </div>
                                    <div class="mt-2 mt-md-0 ms-md-3 d-flex flex-column justify-content-center justify-content-md-between w-100">
                                        <div class="d-flex flex-column text-center text-md-start justify-content-center justify-content-md-between">
                                            @if(Auth::user()->is_admin)
                                                {{ $user->name }}
                                                <i>
                                                    {{ $user->email }}
                                                </i>
                                            @else
                                                <p class="m-0 align-self-center-center">
                                                    {{ $user->name }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    @if(Auth::user()->is_admin)
                                        <div class="col-12 col-md-3 text-center text-md-start">
                                            <i>
                                                Intémon trouvé : {{ $user->pokemons->count() }}
                                            </i>
                                            <br/>
                                            <i>
                                                Score : {{ $user->getScore() }}
                                            </i>
                                        </div>
                                    @endif

                                </div>
                            </a>
                        @empty
                            <div class="d-flex w-100 justify-content-center">
                                <h5 class="mb-1">
                                    @if(Route::currentRouteName() === 'users.search')
                                        Aucun joueur correspondant
                                    @else
                                        Aucun utilisateur enregistré
                                    @endif
                                </h5>
                            </div>
                        @endforelse
                    </div>
                </div>

                @if ($users->hasPages() || Auth::user()->is_admin)
                    <div class="card-footer d-flex flex-column flex-md-row justify-content-center justify-content-md-between">
                        @if ($users->hasPages())
                            <div class="d-flex flex-row justify-content-center">
                                {{ $users->links("pagination::bootstrap-4") }}
                            </div>
                        @endif

                        @if(Auth::user()->is_admin)
                            <a
                                class="my-3 my-md-auto btn btn-secondary"
                                href="{{ route('users.export') }}"
                            >
                                Télécharger les résultats
                            </a>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
