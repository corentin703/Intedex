@extends('layouts.app')

@section('content')

@inject('fontColorService', 'App\Services\Views\FontColorServiceInterface')

<h3 class="display-3 text-center">Intédex</h3>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="pokedex-offcanvas" aria-labelledby="pokedex-offcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Filtrer les types</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
        </div>
        <div class="offcanvas-body">

            @if ($user_types->count() > 0)
                <p>
                    Cliquez sur un type pour naviguer dans le pokédex
                </p>

                <div class="list-group">

                    @foreach($user_types as $type)
                        <button
                            class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center flex-wrap"
                            onclick='scrollToDiv("type-{{ $type->id }}")'
                            style="background-color: {{ $type->color }}; color: {{ $fontColorService->getFontColorFromBackground($type->color) }}"
                            data-bs-dismiss="offcanvas"
                            role="button"
                            aria-controls="pokedex-offcanvas"
                        >
                            <img
                                src="{!! $type->picture_link !!}"
                                class="rounded-circle"
                                style="width: 2.5em; height: 2.5em"
                                alt="Photo du type"
                            />

                            <div class="mt-3 mt-md-0 ms-md-3 text-center text-md-start flex-text-truncate">
                                {{ $type->name }}
                            </div>
                        </button>
                    @endforeach
                </div>
            @else
                <p>
                    Découvrez des intémon pour filtrer !
                </p>
            @endif

        </div>
    </div>

<div class="container min-vh-60">

    @forelse($types as $type)

        <div class="mt-4 row justify-content-center">
            <div class="col-md-8">
                @if ($user_types->contains($type))
                    <div id="type-{{ $type->id }}" class="card">
                    <h5
                        class="card-header"
                        style="background-color: {{ $type->color }}bb; color: {{ $fontColorService->getFontColorFromBackground($type->color) }}"
                    >
                        {{ $type->name }}
                    </h5>
                    <div
                        class="card-body"
                        style="background-color: {{ $type->color }}99; color: {{ $fontColorService->getFontColorFromBackground($type->color) }}"
                    >

                        <section class="d-flex flex-column flex-md-row align-items-center">
                            <div class="text-center m-2 me-md-5">
                                <div style="width: 10em; height: 10em;">
                                    <img
                                        src="{!! $type->picture_link !!}"
                                        style="width: 9em; height: 9em; margin: 0.5em 0.5em"
                                        alt="Photo du type"
                                    />
                                </div>
                            </div>

                            <div class="text-center text-md-start s-md-3 no-markdown-margin" style="color: {{ $fontColorService->getFontColorFromBackground($type->color) }}">
                                @if($type->desc)
                                    {{ \Illuminate\Mail\Markdown::parse($type->desc) }}
                                @else
                                    Aucune description pour ce type
                                @endif
                            </div>
                        </section>

                        <hr class="mb-4"/>

                        <section
                            class="list-group"
                        >
                            @php
                                $pokemon_count = 0;
                            @endphp

                            @forelse($type->pokemons()->orderBy('name')->get() as $pokemon)

                                @if($user->pokemons->contains($pokemon))
                                    @php
                                        $pokemon_count++;
                                    @endphp

                                    @include('pokemons.detail-modal')

                                    <a
                                        class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center flex-wrap"
                                        href="#"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-pokemon-{{ $pokemon->id }}-t-{{ $type->id }}"
                                        style="
                                            background-color: {{ $type->color }}99;
                                            color: {{ $fontColorService->getFontColorFromBackground($type->color) }}
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
                                                    background-color: {{ $type->color }};
                                                    color: {{ $fontColorService->getFontColorFromBackground($type->color) }};
                                                    filter: sepia(0.5);
                                                "
                                            >{{ $pokemon->getRarenessDisplayString() }}
                                            </div>
                                            <div
                                                class="m-1 badge"
                                                style="
                                                    background-color: {{ $type->color }};
                                                    color: {{ $fontColorService->getFontColorFromBackground($type->color) }};
                                                    filter: sepia(0.9);
                                                "
                                            >
                                                #{{ $pokemon->id }}
                                            </div>
                                        </div>
                                    </a>
                                @else
                                    <div
                                        class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center flex-wrap"
                                        style="
                                            background-color: {{ $type->color }}88;
                                            color: {{ $fontColorService->getFontColorFromBackground($type->color) }}
                                        "
                                    >
                                        <div class="rounded-image-container blurred-image-container">
                                            <img
                                                src="{!! $pokemon->picture_link !!}"
                                                class=" w-10 h-10"
                                                style="width: 2.5em; height: 2.5em;"
                                                alt="Photo du intémon"
                                            />
                                        </div>


                                        <div
                                            class="mt-3 mt-md-0 ms-md-3 text-center text-md-start flex-text-truncate"
                                            style="font-size: 1.2rem; max-width: 80%"
                                        >
                                            {{ $pokemon->name[0] }}...
                                        </div>
                                        <div
                                            class="mt-3 mt-md-0 flex-fill d-flex align-content-center justify-content-end"
                                        >
                                            <div
                                                class="m-1 badge"
                                                style="
                                                    background-color: {{ $type->color }};
                                                    color: {{ $fontColorService->getFontColorFromBackground($type->color) }};
                                                    filter: sepia(0.9);
                                                "
                                            >
                                                À découvrir
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="d-flex w-100 justify-content-center">
                                    <h5 class="mb-1">Aucun pokémon de ce type n'a été trouvé</h5>
                                </div>
                            @endforelse
                        </section>
                    </div>

                    @if($pokemon_count > 0)
                        <div
                            class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-center"
                            style="background-color: {{ $type->color }}bb; color: {{ $fontColorService->getFontColorFromBackground($type->color) }}"
                        >

                            <h5 class="m-1 text-center text-md-start">
                                @if($pokemon_count == 1)
                                    Un intémon de ce type a été trouvé.
                                @else
                                    {{ $pokemon_count }} intémons de ce type ont été trouvé.
                                @endif
                            </h5>

                            @if($type->pokemons->count() == $pokemon_count)
                                <div
                                    class="m-1 badge"
                                    style="
                                        background-color: {{ $type->color }};
                                        color: {{ $fontColorService->getFontColorFromBackground($type->color) }};
                                        filter: sepia(0.9);
                                    "
                                >
                                    Complet
                                </div>
                            @endif

                        </div>
                    @endif
                </div>
                @else
                    <div id="type-{{ $type->id }}" class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="m-0">{{ $type->name[0] }}...</h5>
                            <div
                                class="m-1 badge bg-primary">À découvrir</div>
                        </div>
                        <div
                            class="card-body"
                        >
                            <section class="d-flex flex-column flex-md-row align-items-center">
                                <div class="text-center m-2 me-md-5">
                                    <div class="blurred-type-container" style="width: 10em; height: 10em; filter: blur(7px)">
                                        <img
                                            src="{!! $type->picture_link !!}"
                                            style="width: 6em; height: 6em; margin: 2em 2em"
                                            alt="Photo du type"
                                        />
                                    </div>
                                </div>
                                <div class="m-0 text-center text-md-start no-markdown-margin">
                                    @if($type->teaser)
                                        {{ \Illuminate\Mail\Markdown::parse($type->teaser) }}
                                    @else
                                        Aucun teaser pour ce type
                                    @endif
                                </div>
                            </section>

                            <hr/>

                            <section>
                                <p class="text-center">
                                    Il y a {{ $type->pokemons->count() }} intémons de ce type à découvrir !
                                </p>
                            </section>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="d-flex w-100 justify-content-center">
            <h5 class="mb-1">Aucun intémon n'a été trouvé</h5>
        </div>
    @endforelse

</div>

<button
    class="btn btn-primary btn-circle m-3 sticky-bottom float-end"
    type="button"
    data-bs-toggle="offcanvas"
    data-bs-target="#pokedex-offcanvas"
    aria-controls="pokedex-offcanvas"
>
    <i class="bi bi-list"></i>
</button>

@endsection
