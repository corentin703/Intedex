@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Édition de {{ $user->name }}</h5>

                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                            <div class="row">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Surnom</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        <div class="mt-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Courriel (devra être revérifié)</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        @if (Auth::user()->is_admin && $user->id != Auth::id())
                        <div class="form-check row">
                            <div class="offset-md-4 col-md-6 text-center">
                                <input class="form-check-input" type="checkbox" @if($user->is_admin) checked @endif name="is_admin" id="is_admin">
                                <label class="form-check-label" for="is_admin">
                                    Admin
                                </label>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="d-flex w-100 justify-content-between">
                            <button type="submit" class="btn btn-primary">
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

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Changement de mot de passe</h5>

                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="row">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Mot de passe</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="" required autofocus>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3 row">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">Confirmation du mot de passe</label>

                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="" required autofocus>

                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex w-100 justify-content-between">
                            <button type="submit" class="btn btn-primary">
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
            <form method="POST" action="{{ route('users.destroy', $user->id) }}">
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
                <h5 class="card-header">Suppression de {{ $user->name }}</h5>
                    <div class="card-body">
                        <div class="row">
                            <label for="warning-delete" class="col-md-4 col-form-label text-md-end">Attention</label>

                            <div id="warning-delete" class="col-md-6">
                                <p>
                                    La suppression d'un utilisateur est irrréversible. <br/>
                                    Toutes les données associées (captures) seront perdues.
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
