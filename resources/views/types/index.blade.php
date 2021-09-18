@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Liste des types</h5>

                <div class="card-body">
                    @if ($types->count() === 0)
                        <h5 class="mb-1">Aucun type de pokémon n'a été enregistré</h5>
                    @else
                        <div class="list-group">
                            @foreach($types as $type)
                                <a
                                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center flex-wrap"
                                    href="{{ route('types.show', $type->id) }}"
                                >
                                    <img
                                        src="{!! $type->picture_link !!}"
                                        class="rounded-circle"
                                        style="width: 2.5em; height: 2.5em"
                                        alt="Photo du type"
                                    />

                                    <div class="mt-3 mt-md-0 ms-md-3 text-center text-md-start flex-text-truncate" style="font-size: 1.2rem; max-width: 80%">
                                        {{ $type->name }}
                                    </div>
                                </a>

                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="card-footer">
                    <div class="d-flex w-100 justify-content-start">
                        <a class="btn btn-primary" href="{{ route('types.create') }}" >
                            Créer
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
