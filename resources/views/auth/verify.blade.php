@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Vérifiez votre courriel</h5>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Un lien de vérification a été envoyé à votre courriel.
                        </div>
                    @endif

                        Avant de continuer, veuillez vérifier votre courriel. <br/>
                        Si vous n'avez pas reçu le lien de vérification,
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">cliquez ici pour en recevoir un autre !</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
