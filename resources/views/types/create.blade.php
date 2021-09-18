@extends('layouts.app')

@section('content')

<script type="text/javascript">
    window.default_picture = "{{ asset('images/unknown-picture.png') }}";
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Nouveau type</h5>

                <form method="POST" action="{{ route('types.store') }}">
                    @csrf

                    <div class="card-body">

                        <div class="row">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nom</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>

                                @error('name')
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
                                        src="{{ asset('images/unknown-picture.png') }}"
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
                                    value="{{ old('picture_link') }}"
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
                                <textarea id="teaser" type="text" class="form-control @error('desc') is-invalid @enderror" name="teaser">{{ old('teaser') }}</textarea>

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
                                <textarea id="desc" type="text" class="form-control @error('desc') is-invalid @enderror" name="desc">{{ old('desc') }}</textarea>

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
                                <input id="color" type="color" class="form-control @error('color') is-invalid @enderror" name="color" value="{{ old('color') }}" required/>

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
                                Créer
                            </button>

                            <a class="btn btn-link" href="{{ route('types.index') }}">
                                Annuler
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
