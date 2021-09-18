@extends('layouts.app')

@section('content')

<script type="text/javascript">
    window.default_picture = "{{ asset('images/unknown-picture.png') }}";
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Édition de type</h5>


                <form method="POST" action="{{ route('types.update', $type->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="row">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nom</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $type->name }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3 row">
                            <label for="picture_link" class="col-md-4 col-form-label text-md-end">Photo</label>

                            <div class="col-md-6">
                                <div class="d-flex w-100">
                                    <img
                                        id="picture"
                                        src="{!! $type->picture_link !!}"
                                        class="figure-img rounded"
                                        style="width: 100px; height: 100px"
                                        alt="Logo du type"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="picture_link" class="col-md-4 col-form-label text-md-end">Lien du logo</label>

                            <div class="col-md-6">
                                <input
                                    id="picture_link"
                                    type="text"
                                    class="form-control
                                    @error('picture_link') is-invalid @enderror"
                                    name="picture_link"
                                    value="{{ $type->picture_link }}"
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
                            <label for="teaser" class="col-md-4 col-form-label text-md-end">Teaser <i class="bi bi-markdown"></i></label>

                            <div class="col-md-6">
                                <textarea id="teaser" type="text" class="form-control @error('desc') is-invalid @enderror" name="teaser">{{ $type->teaser }}</textarea>

                                @error('teaser')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3 row">
                            <label for="desc" class="col-md-4 col-form-label text-md-end">Description <i class="bi bi-markdown"></i></label>

                            <div class="col-md-6">
                                <textarea id="desc" type="text" class="form-control @error('desc') is-invalid @enderror" name="desc">{{ $type->desc }}</textarea>

                                @error('desc')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3 row">
                            <label for="color" class="col-md-4 col-form-label text-md-end">Couleur</label>

                            <div class="col-md-6">
                                <input id="color" type="color" class="form-control @error('desc') is-invalid @enderror" name="color" value="{{ $type->color }}" required/>

                                @error('color')
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
            <form method="POST" action="{{ route('types.destroy', $type->id) }}">
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
                <h5 class="card-header">Suppression du type {{ $type->name }}</h5>
                    <div class="card-body">
                        <div class="row">
                            <label for="warning-delete" class="col-md-4 col-form-label text-md-end">Attention</label>

                            <div id="warning-delete" class="col-md-6">
                                <p>
                                    La suppression d'un type est irreversible. <br/>
                                    Les intémons uniquement associés à ce type seront supprimés (ceux qui ont d'autres types seront conservés sans celui-ci).
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex w-100 justify-content-between">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete">
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
