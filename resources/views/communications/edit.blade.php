@extends('base')

@section('title', 'Modifier la Communication')

@section('content')
<div class="container">
    <h1>Modifier la communication : {{ $communication->titre }}</h1>

    <form action="{{ route('communications.update', $communication->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Champ Titre -->
        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" class="form-control" id="titre" name="titre" value="{{ old('titre', $communication->titre) }}" required>
            @error('titre')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Champ Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $communication->description) }}</textarea>
        </div>

        <!-- Champ Type -->
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-control" id="type" name="type" required>
                <option value="communication" {{ $communication->type == 'communication' ? 'selected' : '' }}>Communication</option>
                <option value="symposium" {{ $communication->type == 'symposium' ? 'selected' : '' }}>Symposium</option>
                <option value="atelier" {{ $communication->type == 'atelier' ? 'selected' : '' }}>Atelier</option>
                <option value="pause" {{ $communication->type == 'pause' ? 'selected' : '' }}>Pause</option>
            </select>
        </div>

        <!-- Champ Salle -->
        <div class="mb-3">
            <label for="salle_id" class="form-label">Salle</label>
            <select class="form-control" id="salle_id" name="salle_id" required>
                @foreach ($salles as $salle)
                    <option value="{{ $salle->id }}" {{ $communication->salle_id == $salle->id ? 'selected' : '' }}>{{ $salle->nom }}</option>
                @endforeach
            </select>
        </div>

        <!-- Champ Date -->
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $communication->date) }}" required>
            @error('date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Heure Début -->
        <div class="mb-3">
            <label for="heure_debut" class="form-label">Heure de début</label>
            <input type="time" class="form-control" id="heure_debut" name="heure_debut" value="{{ old('heure_debut', $communication->heure_debut) }}" required>
            @error('heure_debut')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Heure Fin -->
        <div class="mb-3">
            <label for="heure_fin" class="form-label">Heure de fin</label>
            <input type="time" class="form-control" id="heure_fin" name="heure_fin" value="{{ old('heure_fin', $communication->heure_fin) }}" required>
            @error('heure_fin')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Orateurs -->
        <div class="mb-3">
            <label for="orateurs" class="form-label">Orateurs</label>
            <select class="form-control" id="orateurs" name="orateurs[]" multiple>
                @foreach ($orateurs as $orateur)
                    <option value="{{ $orateur->id }}" {{ in_array($orateur->id, $communication->orateurs->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $orateur->nom_complet }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>

</div>
@endsection
