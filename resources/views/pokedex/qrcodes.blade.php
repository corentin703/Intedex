@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Téléchargement des codes QR</h5>

                <form method="POST" action="{{ route('pokedex.qrcodes.download') }}">
                    @csrf

                    <div class="card-body container">
                        <div class="input-group col-md-6">
                            <label for="size" class="input-group-text">Taille d'image</label>
                            <input id="size" type="number" class="form-control @error('size') is-invalid @enderror" name="size" required autofocus>
                            <span class="input-group-text">px</span>


                            @error('size')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer d-flex flex-column flex-shrink-1 flex-md-row justify-content-between align-items-center flex-wrap">
                        <button class="mb-2 mb-md-auto btn btn-primary" type="submit">
                            Télécharger
                        </button>

                        <a class="btn btn-link" onclick="window.history.back()">Retour</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
