@extends('base')

@section('title', 'Communications de la Session')

@section('content')
<div class="container">
    <h1>Communications pour la session : {{ $sessi->nom }}</h1>

    @if ($sessi->communications->isEmpty())
    <p>Aucune communication pour cette session.</p>
@else
    <div class="row">
        @foreach ($sessi->communications as $communication)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $communication->titre }}</h5>
                        <p class="card-text">
                            <strong>Type:</strong> {{ $communication->type }} <br>
                            <strong>Date:</strong> {{ $communication->date }} <br>
                            <strong>Horaire:</strong> {{ $communication->heure_debut }} - {{ $communication->heure_fin }} <br>
                            <strong>Salle:</strong> {{ $communication->salle->nom ?? 'Non spécifiée' }} <br>
                            <strong>Description:</strong> {{ $communication->description }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

    {{-- Formulaire pour ajouter une communication --}}
    <h3>Ajouter une communication</h3>
    <form action="{{ route('communications.store') }}" method="POST">
        @csrf
        <input type="hidden" name="sessis_id" value="{{ $sessi->id }}">

        <div class="mb-2">
            <label for="titre">Titre</label>
            <input type="text" id="titre" name="titre" class="form-control" required>
        </div>

        <div class="mb-2">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control"></textarea>
        </div>

        <div class="mb-2">
            <label for="type">Type</label>
            <select id="type" name="type" class="form-control" required>
                <option value="communication">Communication</option>
                <option value="symposium">Symposium</option>
                <option value="atelier">Atelier</option>
                <option value="pause">Pause</option>
            </select>
        </div>



        <button type="submit" class="btn btn-primary">Ajouter une communication</button>
    </form>
</div>
@endsection
