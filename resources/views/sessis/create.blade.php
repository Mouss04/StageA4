@extends('base')

@section('content')
<div class="container">
    <h1>Créer une nouvelle session</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sessis.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la session</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom') }}" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
        </div>

        <div class="mb-3">
            <label for="heure_debut" class="form-label">Heure de début</label>
            <input type="time" class="form-control" id="heure_debut" name="heure_debut" value="{{ old('heure_debut') }}" required>
        </div>

        <div class="mb-3">
            <label for="heure_fin" class="form-label">Heure de fin</label>
            <input type="time" class="form-control" id="heure_fin" name="heure_fin" value="{{ old('heure_fin') }}" required>
        </div>

        <div class="form-group">
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

        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>
@endsection
