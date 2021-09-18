@if(!isset($fontColorService))
    @inject('fontColorService', 'App\Services\Views\FontColorServiceInterface')
@endif

    <div
    @isset($type)
        id="modal-pokemon-{{ $pokemon->id }}-t-{{ $type->id }}"
    @else
        id="modal-pokemon-{{ $pokemon->id }}"
        @php
            $type = $pokemon->types[0];
        @endphp
    @endif
    data-bs-target="#modal-pokemon-{{ $pokemon->id }}"
    class="modal fade"
    tabindex="-1"
    role="dialog"
>
    <div
        class="modal-dialog modal-lg"
        role="document"
    >


        <div
            style="
                background-color: {{ $type->color }};
                border-radius: calc(0.3rem - 1px);
            "
        >
            <div
                class="modal-content"
                style="
                    color: {{ $fontColorService->getFontColorFromBackground($type->color) }}
                "
            >
                <div
                    class="modal-header d-flex flex-row justify-content-between align-items-center"
                    style="
                        background-color: {{ $type->color }}bb;
                        color: {{ $fontColorService->getFontColorFromBackground($type->color) }}
                    "
                >
                    <h5 class="modal-title">{{ $pokemon->name }}
                        @if($pokemon->sex == 'F')
                            (<i class="bi bi-gender-female"></i>)
                        @else()
                            (<i class="bi bi-gender-male"></i>)
                        @endif
                        <span
                            class="badge"
                            style="
                                background-color: {{ $type->color }};
                                color: {{ $fontColorService->getFontColorFromBackground($type->color) }};
                                filter: sepia(0.5);
                            "
                        >
                            #{{ $pokemon->id }}
                        </span>
                    </h5>

                    <div>
                        @if(Auth::user()->favorite_pokemon_id != $pokemon->id)
                        <form class="col" method="POST" action="{{ route('user.set_favorite_pokemon', [Auth::user()->id, $pokemon->id]) }}">
                            @csrf
                            <button
                                type="submit"
                                class="btn"
                                style="
                                    background-color: {{ $type->color }};
                                    color: {{ $fontColorService->getFontColorFromBackground($type->color) }};
                                "
                            >
                                <i class="bi bi-heart"></i>
                            </button>
                        </form>
                        @else
                        <form class="col" method="POST" action="{{ route('user.set_favorite_pokemon', [Auth::user()->id]) }}">
                            @csrf
                            <button
                                type="submit"
                                class="btn"
                                style="
                                    background-color: {{ $type->color }};
                                    color: {{ $fontColorService->getFontColorFromBackground($type->color) }};
                                "
                            ><i class="bi bi-heart-fill"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                <div
                    class="modal-body container"
                    style="
                        background-color: {{ $type->color }}99;
                        color: {{ $fontColorService->getFontColorFromBackground($type->color) }};
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

                        <div class="ms-md-3 no-markdown-margin">
                            @if($pokemon->desc)
                                {{ \Illuminate\Mail\Markdown::parse($pokemon->desc) }}
                            @else
                                Aucune description
                            @endif
                        </div>
                    </div>

                    <div class="ms-2 mt-2 container">
                        <div class="row align-middle">
                            <div class="col-md-4 pb-1 pb-md-0">Types</div>
                            <div class="col ps-4 ps-md-2">
                                @foreach($pokemon->types()->orderBy('name')->get() as $key => $it_type)
                                    @if($key != $pokemon->types->count() - 1)
                                        {{ $it_type->name . ',' }}
                                    @else
                                        {{ $it_type->name }}
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
                    class="modal-footer"
                    style="
                        background-color: {{ $type->color }}bb;
                        color: {{ $fontColorService->getFontColorFromBackground($type->color) }}
                    "
                >
                    <div class="row justify-content-between">
                        <div class="btn-group" role="group">
                            @if(Auth::user()->is_admin)
                                <a
                                    href="{{ route('pokemons.edit', $pokemon->id) }}"
                                    class="btn"
                                    style="
                                        background-color: {{ $type->color }};
                                        color: {{ $fontColorService->getFontColorFromBackground($type->color) }};
                                    "
                                >
                                    Éditer
                                </a>
                            @endif
                            <button
                                type="button"
                                class="btn"
                                data-bs-dismiss="modal"
                                style="
                                    background-color: {{ $type->color }};
                                    color: {{ $fontColorService->getFontColorFromBackground($type->color) }};
                                    filter: sepia(0.5);
                                "
                            >
                                Fermer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
