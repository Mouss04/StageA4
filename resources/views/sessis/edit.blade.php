@extends('base')

@section('title', 'Modifier la session')

@section('content')
<div class="container">
    <h1>Modifier la session</h1>

    {{-- Afficher les erreurs de validation --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire de modification de la session --}}
    <form action="{{ route('sessis.update', $sessi->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Cette ligne permet d'utiliser la méthode PUT pour la mise à jour --}}

        <div class="form-group">
            <label for="nom">Nom de la session</label>
            <input type="text" name="nom" class="form-control" id="nom" value="{{ old('nom', $sessi->nom) }}" required>
        </div>

        <div class="form-group">
            <label for="date">Date de la session</label>
            <input type="date" name="date" class="form-control" id="date" value="{{ old('date', $sessi->date) }}" required>
        </div>

        <div class="form-group">
            <label for="heure_debut">Heure de début</label>
            <input type="time" name="heure_debut" class="form-control" id="heure_debut"
                   value="{{ old('heure_debut', $sessi->heure_debut) }}" required>
        </div>

        <div class="form-group">
            <label for="heure_fin">Heure de fin</label>
            <input type="time" name="heure_fin" class="form-control" id="heure_fin"
                   value="{{ old('heure_fin', $sessi->heure_fin) }}" required>
        </div>

        {{-- Orateurs --}}
        @if (!$sessi->orateurs->isEmpty())
            <div class="form-group" id="orateurs-container">
                <label for="orateurs">Modérateurs</label>
                <select name="orateurs[]" id="orateurs" class="form-control" multiple>
                    @foreach ($orateurs as $orateur)
                        <option value="{{ $orateur->id }}"
                            @if (isset($sessi) && $sessi->orateurs->contains($orateur->id)) selected @endif>
                            {{ $orateur->nom_complet }}
                        </option>
                    @endforeach
                </select>
            </div>
        @else
            <p><strong>Modérateurs:</strong> Non définis</p>
        @endif

        {{-- Liste des communications --}}
        <h3>Communications associées</h3>
        @if ($sessi->communications->isEmpty())
            <p>Aucune communication associée à cette session.</p>
        @else
            <ul>
                @foreach ($sessi->communications as $communication)
                    <li>
                        <strong>{{ $communication->titre }}</strong> : {{ $communication->description }}
                        <form action="{{ route('communications.destroy', $communication->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- Bouton pour ajouter une communication --}}
        <a href="{{ route('communications.create', $sessi->id) }}" class="btn btn-primary mt-3">Ajouter une communication</a>

        <button type="submit" class="btn btn-primary mt-3">Mettre à jour la session</button>
    </form>
</div>

@endsection
