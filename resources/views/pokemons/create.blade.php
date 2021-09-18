@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.default_picture = "{{ asset('images/unknown-picture.png') }}";
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Nouveau intémon</h5>


                <form method="POST" action="{{ route('pokemons.store') }}">
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

                            <div class="row">
                                <label for="rareness" class="col-md-4 col-form-label text-md-end">Rareté</label>

                                <div class="col-md-6">
                                    <select class="form-control" name="rareness" required>
                                        <option value="COMMON" @if (old('rareness') == null || old('rareness') === 'COMMON') selected @endif>Commun</option>
                                        <option value="RARE" @if (old('rareness') === 'RARE') selected @endif>Rare</option>
                                        <option value="LEGENDARY" @if (old('rareness') === 'LEGENDARY') selected @endif>Légendaire</option>
                                    </select>

                                    @error('rareness')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label for="picture_link" class="col-md-4 col-form-label text-md-end">Photo</label>

                                <div class="col-md-6">
                                    <div class="d-flex w-100">
                                        <img
                                            id="picture"
                                            src="{{ old('picture_link') ?? asset('images/unknown-picture.png') }}"
                                            class="rounded-circle w-10 h-10"
                                            style="width: 100px; height: 100px"
                                            alt="Photo de l'utilisateur"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label for="picture_link" class="col-md-4 col-form-label text-md-end">Lien de la photo</label>

                                <div class="col-md-6">
                                    <input
                                        id="picture_link"
                                        type="text"
                                        class="form-control
                                        is-invalid
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

                            <div class="row">
                                <label for="types" class="col-md-4 col-form-label text-md-end">Types</label>

                                <div class="col-md-6">
                                    <select id="types" class="custom-select" name="types[]" multiple required>
                                        @foreach($types as $key => $type)
                                            <option value="{{ $type->id }}">
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('types')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label for="sex" class="col-md-4 col-form-label text-md-end">Sexe</label>

                                <div class="col-md-6">
                                    <select id="sex" class="form-control" name="sex" required>
                                        <option value="F" @if (old('sex') == null || old('sex') === 'F') selected @endif>Femelle</option>
                                        <option value="M" @if (old('sex') === 'M') selected @endif>Mâle</option>
                                    </select>

                                    @error('sex')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
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

                            <div class="row">
                                <label for="strengths" class="col-md-4 col-form-label text-md-end">Forces <i class="bi bi-markdown"></i></label>

                                <div class="col-md-6">
                                    <textarea id="strengths" type="text" class="form-control @error('strengths') is-invalid @enderror" name="strengths">{{ old('strengths') }}</textarea>

                                    @error('strengths')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <label for="weaknesses" class="col-md-4 col-form-label text-md-end">Faiblesses <i class="bi bi-markdown"></i></label>

                                <div class="col-md-6">
                                    <textarea id="weaknesses" type="text" class="form-control @error('weaknesses') is-invalid @enderror" name="weaknesses">{{ old('weaknesses') }}</textarea>

                                    @error('weaknesses')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button id="btn_send" type="submit" class="btn btn-primary">
                                    Créer
                                </button>

                                <a class="btn btn-link" href="{{ route('pokemons.index') }}">
                                    Annuler
                                </a>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
