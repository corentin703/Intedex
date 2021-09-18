@extends('layouts.app')

@inject('fontColorService', 'App\Services\Views\FontColorServiceInterface')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Intédex complet</h5>

                <div class="card-body">
                    <div class="list-group">
                        @forelse($pokemons as $pokemon)

                            @include('pokemons.detail-modal')

                            <a
                                class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center flex-wrap"
                                href="#"
                                data-bs-toggle="modal"
                                data-bs-target="#modal-pokemon-{{ $pokemon->id }}"
                                style="
                                    background-color: {{ $pokemon->types[0]->color }}99;
                                    color: {{ $fontColorService->getFontColorFromBackground($pokemon->types[0]->color) }}
                                "
                            >
                                <img
                                    src="{!! $pokemon->picture_link !!}"
                                    class="rounded-circle w-10 h-10"
                                    style="width: 2.5em; height: 2.5em"
                                    alt="Photo du intémon"
                                />

                                <div class="mt-3 mt-md-0 ms-md-3 text-center text-md-start flex-text-truncate" style="font-size: 1.2rem; max-width: 80%">
                                    {{ $pokemon->name }}
                                        @if($pokemon->sex == 'F')
                                            (<i class="bi bi-gender-female"></i>)
                                        @else()
                                            (<i class="bi bi-gender-male"></i>)
                                        @endif
                                </div>

                                <div class="mt-3 mt-md-0 flex-fill d-flex align-content-center justify-content-end">
                                    <div
                                        class="m-1 badge"
                                        style="
                                            background-color: {{ $pokemon->types[0]->color }};
                                            color: {{ $fontColorService->getFontColorFromBackground($pokemon->types[0]->color) }};
                                            filter: sepia(0.5);
                                            "
                                    >
                                        {{ $pokemon->getRarenessDisplayString() }}
                                    </div>
                                    <div
                                        class="m-1 badge"
                                        style="
                                            background-color: {{ $pokemon->types[0]->color }};
                                            color: {{ $fontColorService->getFontColorFromBackground($pokemon->types[0]->color) }};
                                            filter: sepia(0.9);
                                            "
                                    >
                                        #{{ $pokemon->id }}
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="d-flex w-100 justify-content-center">
                                <h5 class="mb-1">Aucun pokémon n'a été enregistré</h5>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="card-footer d-flex flex-column flex-shrink-1 flex-md-row justify-content-between align-items-center flex-wrap">
                    <a class="mb-2 mb-md-auto btn btn-primary" href="{{ route('pokemons.create') }}">
                        Créer
                    </a>

                    @if ($pokemons->hasPages())
                        <div class="mb-2 mb-md-auto">
                            {{ $pokemons->links("pagination::bootstrap-4") }}
                        </div>
                    @endif

                    <a class="btn btn-secondary" href="{{ route('pokedex.qrcodes') }}">
                        Générer codes QR
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
