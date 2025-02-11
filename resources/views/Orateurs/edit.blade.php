@extends('base')

@section('title', 'Modifier l\'Orateur')

@section('content')
<div class="container">
    <h1>Modifier un Orateur</h1>

    <form action="{{ route('orateurs.update', $orateur->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nom_complet">Nom Complet</label>
            <input type="text" class="form-control" id="nom_complet" name="nom_complet" value="{{ old('nom_complet', $orateur->nom_complet) }}" required>
        </div>

        <div class="form-group">
            <label for="biographie">Biographie</label>
            <textarea class="form-control" id="biographie" name="biographie">{{ old('biographie', $orateur->biographie) }}</textarea>
        </div>

        <div class="form-group">
            <label for="photo">Photo</label>
            <div>
                @if($orateur->photo)
                    <img src="{{ asset('storage/' . $orateur->photo) }}" alt="Photo" width="100">
                    <br>
                    <small>Si vous voulez changer la photo, sélectionnez une nouvelle image ci-dessous.</small>
                @else
                    <p>Aucune photo actuelle</p>
                @endif
            </div>
            <input type="file" class="form-control" id="photo" name="photo">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
