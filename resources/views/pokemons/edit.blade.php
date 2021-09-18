@extends('layouts.app')

@section('content')

<script type="text/javascript">
    window.default_picture = "{{ asset('images/unknown-picture.png') }}";
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Édition de {{ $pokemon->name }}
                    @if($pokemon->sex == 'F')
                        (<i class="bi bi-gender-female"></i>)
                    @else()
                        (<i class="bi bi-gender-male"></i>)
                    @endif
                </h5>


                <form method="POST" action="{{ route('pokemons.update', $pokemon->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                            <div class="row">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Nom</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $pokemon->name }}" required autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-3 row">
                                <label for="rareness" class="col-md-4 col-form-label text-md-end">Rareté</label>

                                <div class="col-md-6">
                                    <select class="form-control" name="rareness" required>
                                        <option value="COMMON" @if ($pokemon->rareness == 'COMMON') selected @endif>Commun</option>
                                        <option value="RARE" @if ($pokemon->rareness == 'RARE') selected @endif>Rare</option>
                                        <option value="LEGENDARY" @if ($pokemon->rareness == 'LEGENDARY') selected @endif>Légendaire</option>
                                    </select>

                                    @error('rareness')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        <div class="mt-3 row">
                            <label for="picture" class="col-md-4 col-form-label text-md-end">Photo</label>

                            <div class="col-md-6">
                                <div class="d-flex w-100">
                                    <img
                                        id="picture"
                                        src="{!! $pokemon->picture_link !!}"
{{--                                        class="rounded-circle w-10 h-10"--}}
                                        class="figure-img rounded"
                                        style="width: 100px; height: 100px"
                                        alt="Photo du intémon"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="picture_link" class="col-md-4 col-form-label text-md-end">Lien</label>

                            <div class="col-md-6">
                                <input
                                    id="picture_link"
                                    type="text"
                                    class="form-control
                                    @error('picture_link') is-invalid @enderror"
                                    name="picture_link"
                                    value="{{ $pokemon->picture_link }}"
                                    required
                                    autofocus
                                >

                                @error('picture_link')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="mt-3 row">
                            <label for="types" class="col-md-4 col-form-label text-md-end">Types</label>

                            <div class="col-md-6">
                                <select id="types" class="form-select" name="types[]" multiple required aria-label="multiple select">
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" @if($pokemon->types->contains($type)) selected @endif>{{ $type->name }}</option>
                                    @endforeach
                                </select>

                                @error('types')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3 row">
                            <label for="sex" class="col-md-4 col-form-label text-md-end">Sexe</label>

                            <div class="col-md-6">
                                <select id="sex" class="form-select" name="sex" required>
                                    <option value="M" @if ($pokemon->sex == 'M') selected @endif>Mâle</option>
                                    <option value="F" @if ($pokemon->sex == 'F') selected @endif>Femelle</option>
                                </select>

                                @error('sex')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3 row">
                            <label for="desc" class="col-md-4 col-form-label text-md-end">Description <i class="bi bi-markdown"></i></label>

                            <div class="col-md-6">
                                <textarea id="desc" type="text" class="form-control @error('desc') is-invalid @enderror" name="desc">{{ $pokemon->desc }}</textarea>

                                @error('desc')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3 row">
                            <label for="strengths" class="col-md-4 col-form-label text-md-end">Forces <i class="bi bi-markdown"></i></label>

                            <div class="col-md-6">
                                <textarea id="strengths" type="text" class="form-control @error('strengths') is-invalid @enderror" name="strengths">{{ $pokemon->strengths }}</textarea>

                                @error('strengths')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3 row">
                            <label for="weaknesses" class="col-md-4 col-form-label text-md-end">Faiblesses <i class="bi bi-markdown"></i></label>

                            <div class="col-md-6">
                                <textarea id="weaknesses" type="text" class="form-control @error('weaknesses') is-invalid @enderror" name="weaknesses">{{ $pokemon->weaknesses }}</textarea>

                                @error('weaknesses')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex w-100 justify-content-between">
                            <button id="btn_send" type="submit" class="btn btn-primary">
                                Valider
                            </button>

                            <a class="btn btn-link" onclick="window.history.back()">Retour</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <br/>

    <div id="modal-delete" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('pokemons.destroy', $pokemon->id) }}">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation de suppression</h5>
                    </div>
                    <div class="modal-body">
                        <div id="warning-delete">
                            <p>
                                Êtes-vous sûr de ce que vous faites ?
                            </p>
                            <p>
                                Si vous ne l'êtes pas, <strong>fuyez pauvre fou !</strong>
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">
                    Suppression de {{ $pokemon->name }}
                    @if($pokemon->sex == 'F')
                        (<i class="bi bi-gender-female"></i>)
                    @else()
                        (<i class="bi bi-gender-male"></i>)
                    @endif
                </h5>
                    <div class="card-body">
                        <div class="row">
                            <label for="warning-delete" class="col-md-4 col-form-label text-md-end">Attention</label>

                            <div id="warning-delete" class="col-md-6">
                                <p>
                                    La suppression d'un intémon est irreversible. <br/>
                                    Les utilisateurs l'ayant capturé ne le verront plus apparaitre dans leur intédex. <br/>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex w-100 justify-content-between">
                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete">
                                Supprimer
                            </button>

                            <a class="btn btn-link" onclick="window.history.back()">Retour</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
