@extends('layouts.app')

@section('content')

@inject('fontColorService', 'App\Services\Views\FontColorServiceInterface')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Type {{ $type->name }}</h5>
                <div class="card-body container">
                    <section class="d-flex flex-column flex-md-row align-items-center">
                        <div class="text-center m-2">
                            <img
                                src="{!! $type->picture_link !!}"
                                class="figure-img rounded"
                                style="width: 10em; height: 10em"
                                alt="Photo du intémon"
                            />
                        </div>

                        <div class="text-center text-md-start ms-md-3 no-markdown-margin">
                            @if($type->desc)
                                {{ \Illuminate\Mail\Markdown::parse($type->desc) }}
                            @else
                                Aucune description
                            @endif
                        </div>
                    </section>

                    <hr/>

                    <section class="d-flex flex-column flex-md-row align-items-center justify-content-around">
                        <div class="text-center m-2">
                            <h5 class="m-0">Teaser</h5>
                        </div>

                        <div class="text-center text-md-start ms-md-3 no-markdown-margin">
                            @if($type->teaser)
                                {{ \Illuminate\Mail\Markdown::parse($type->teaser) }}
                            @else
                                Aucun teaser
                            @endif
                        </div>
                    </section>

                    <hr/>

                    <section class="mt-3">
                        <h5>{{ $type->pokemons()->count() }} intémons de ce type :</h5>
                        <div class="list-group">
                            @foreach($type->pokemons()->orderBy('name')->get() as $pokemon)
                                @include('pokemons.detail-modal')
                                <a
                                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center flex-wrap"
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-pokemon-{{ $pokemon->id }}-t-{{ $type->id }}"
                                >
                                    <img
                                        src="{!! $pokemon->picture_link !!}"
                                        class="rounded-circle"
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
                                </a>
                            @endforeach
                        </div>
                    </section>
                </div>
                <div class="card-footer">
                    <div class="d-flex w-100 justify-content-between">
                        <a class="btn btn-primary" href="{{ route('types.edit', $type->id) }}">
                            Éditer
                        </a>

                        <a class="btn btn-link" onclick="window.history.back()">Retour</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
