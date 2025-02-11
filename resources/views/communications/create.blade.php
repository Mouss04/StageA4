@extends('base')

@section('title', 'Créer une Communication')

@section('content')
<div class="container">
    <h1>Créer une communication pour la session : {{ $sessi->nom }}</h1>

    <form action="{{ route('communications.store') }}" method="POST">
        @csrf
        <input type="hidden" name="sessis_id" value="{{ $sessi->id }}">

        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" class="form-control" id="titre" name="titre" value="{{ old('titre') }}" required>
            @error('titre')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-control" id="type" name="type" required>
                <option value="communication">Communication</option>
                <option value="symposium">Symposium</option>
                <option value="atelier">Atelier</option>
                <option value="pause">Pause</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="salle_id" class="form-label">Salle</label>
            <select class="form-control" id="salle_id" name="salle_id" required>
                @foreach ($salles as $salle)
                    <option value="{{ $salle->id }}">{{ $salle->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
            @error('date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="heure_debut" class="form-label">Heure de début</label>
            <input type="time" class="form-control" id="heure_debut" name="heure_debut" value="{{ old('heure_debut') }}" required>
            @error('heure_debut')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="heure_fin" class="form-label">Heure de fin</label>
            <input type="time" class="form-control" id="heure_fin" name="heure_fin" value="{{ old('heure_fin') }}" required>
            @error('heure_fin')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="orateurs" class="form-label">Orateurs</label>
            <select name="orateurs[]" id="orateurs" class="form-control" multiple>
                @foreach ($orateurs as $orateur)
                    <option value="{{ $orateur->id }}"
                        @if (isset($communication) && $communication->orateurs->contains($orateur->id)) selected @endif>
                        {{ $orateur->nom_complet }}
                    </option>
                @endforeach
            </select>
        </div>
//todo add redirect to home page and send message
        <button type="submit" class="btn btn-primary">Créer la communication</button>
    </form>
</div>
@endsection
