@extends('layouts.app')

@section('content')

@inject('fontColorService', 'App\Services\Views\FontColorServiceInterface')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <h5
                    class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center"
                    style="
                        background-color: {{ $pokemon->types[0]->color }}bb;
                        color: {{ $fontColorService->getFontColorFromBackground($pokemon->types[0]->color) }}
                    "
                >
                    Vous avez trouvé un {{ $pokemon->name }} !
                    <div class="m-1">
                        <span
                            class="badge"
                            style="
                                background-color: {{ $pokemon->types[0]->color }};
                                color: {{ $fontColorService->getFontColorFromBackground($pokemon->types[0]->color) }};
                                filter: sepia(0.5);
                            "
                        >
                            {{ $pokemon->getRarenessDisplayString() }}
                        </span>
                        <span
                            class="badge"
                            style="
                                background-color: {{ $pokemon->types[0]->color }};
                                color: {{ $fontColorService->getFontColorFromBackground($pokemon->types[0]->color) }};
                                filter: sepia(0.9);
                            "
                        >#{{ $pokemon->id }}</span>
                    </div>
                </h5>
                <div
                    class="card-body container"
                    style="
                        background-color: {{ $pokemon->types[0]->color }}99;
                        color: {{ $fontColorService->getFontColorFromBackground($pokemon->types[0]->color) }}
                    "
                >
                    <div class="d-flex flex-column flex-md-row align-items-center">
                        <div class="text-center m-2">
                            <img
                                src="{!! $pokemon->picture_link !!}"
                                class="figure-img rounded"
                                style="width: 10em; height: 10em"
                                alt="Photo du intémon"
                            />
                        </div>

                        <p class="ms-md-3">
                            @if($pokemon->desc)
                                {{ \Illuminate\Mail\Markdown::parse($pokemon->desc) }}
                            @else
                                Aucune description
                            @endif
                        </p>
                    </div>

                    <div class="ms-2 mt-2 container">
                        <div class="row align-middle">
                            <div class="col-md-4 pb-1 pb-md-0">Types</div>
                            <div class="col ps-4 ps-md-2">
                                @foreach($pokemon->types()->orderBy('name')->get() as $key => $type)
                                    @if($key != $pokemon->types->count() - 1)
                                        {{ $type->name . ',' }}
                                    @else
                                        {{ $type->name }}
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <hr/>

                        <div class="row align-middle">
                            <h5 class="col-md-4 pb-1 pb-md-0">Sexe</h5>
                            <div class="col ps-4 ps-md-2">
                                {{ $pokemon->getSexDisplayString() }}
                                @if($pokemon->sex == 'F')
                                    (<i class="bi bi-gender-female"></i>)
                                @else()
                                    (<i class="bi bi-gender-male"></i>)
                                @endif
                            </div>
                        </div>

                        <hr/>

                        <div class="row align-middle">
                            <h5 class="col-md-4 pb-1 pb-md-0">Rareté</h5>
                            <div class="col ps-4 ps-md-2">
                                {{ $pokemon->getRarenessDisplayString() }}
                            </div>
                        </div>

                        <hr/>

                        <div class="row align-middle">
                            <h5 class="col-md-4  pb-1 pb-md-0 align-self-md-center">Forces</h5>
                            <div class="col ps-4 ps-md-2">
                                @if($pokemon->strengths)
                                    {{ \Illuminate\Mail\Markdown::parse($pokemon->strengths) }}
                                @else
                                    Non renseignées
                                @endif
                            </div>
                        </div>

                        <hr/>

                        <div class="row align-middle">
                            <h5 class="col-md-4 pb-1 pb-md-0 align-self-md-center">Faiblesses</h5>
                            <div class="col ps-4 ps-md-2">
                                @if($pokemon->weaknesses)
                                    {{ \Illuminate\Mail\Markdown::parse($pokemon->weaknesses) }}
                                @else
                                    Non renseignées
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="card-footer"
                    style="background-color: {{ $pokemon->types[0]->color }}bb; color: {{ $fontColorService->getFontColorFromBackground($pokemon->types[0]->color) }}"
                >
                    <div class="d-flex w-100 justify-content-between">
                        @if(!$already_caught)
                            <form class="" method="POST" action="{{ route('pokedex.catch', $sha1_hash) }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="btn"
                                    style="
                                        background-color: {{ $pokemon->types[0]->color }};
                                        color: {{ $fontColorService->getFontColorFromBackground($pokemon->types[0]->color) }};
                                        filter: sepia(0.9);
                                    "
                                >Capturer !</button>
                            </form>
                        @endif
                        <a
                            class="btn"
                            href="{{ route('pokedex.index') }}"
                            style="
                                background-color: {{ $pokemon->types[0]->color }};
                                color: {{ $fontColorService->getFontColorFromBackground($pokemon->types[0]->color) }};
                                filter: sepia(0.9) hue-rotate(90deg);
                            "
                        >
                            Retour au intédex
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
